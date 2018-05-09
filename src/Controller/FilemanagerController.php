<?php

namespace App\Controller;

use App\Entity\Directory;
use App\Entity\Image;
use App\Form\Type\DirectoryType;
use App\Form\Type\UploadType;
use App\Repository\DirectoryRepository;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FilemanagerController
 */
class FilemanagerController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @param DirectoryRepository $directoryRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     */
    public function create(Request $request, int $id, DirectoryRepository $directoryRepository)
    {
        $directory = new Directory();
        $parentDirectory = $directoryRepository->findOrCreateRoot($id);

        $form = $this->createForm(DirectoryType::class, $directory);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $directory->setParentDirectory($parentDirectory);
            $directoryRepository->save($directory);

            $filesystem = new Filesystem();
            $filesystem->mkdir($directory->getFullPath());

            return $this->redirect($this->generateUrl('filemanager_list', ['id' => $id]));
        }

        return $this->render(
            'Filemanager/edit.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @param int $id
     * @param Request $request
     * @param ImageRepository $imageRepository
     * @param DirectoryRepository $directoryRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     */
    public function upload(
        int $id,
        Request $request,
        ImageRepository $imageRepository,
        DirectoryRepository $directoryRepository
    ) {
        $image = new Image();
        $directory = $directoryRepository->findOrCreateRoot($id);

        $form = $this->createForm(UploadType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image->setParentDirectory($directory);
            $imageRepository->save($image);
            return $this->redirect($this->generateUrl('filemanager_list', ['id' => $id]));
        }

        return $this->render(
            'Filemanager/upload.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @param int $id
     * @param DirectoryRepository $directoryRepository
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     */
    public function list(DirectoryRepository $directoryRepository, int $id = 0): Response
    {
        /**
         * @var Directory $directory
         */
        $directory = $directoryRepository->findOrCreateRoot($id);

        if (is_null($directory)) {
            $directory = $directoryRepository->findOneBy(['parentDirectory' => null]);
        }

        return $this->render(
            'Filemanager/list.html.twig',
            [
                'currentDirectory' => $directory,
            ]
        );
    }
}
