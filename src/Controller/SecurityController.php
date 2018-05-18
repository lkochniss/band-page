<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\CreateUserType;
use App\Form\Type\EditUserType;
use App\Form\Type\PasswordReset;
use App\Form\Type\PasswordResetType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class SecurityController
 */
class SecurityController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login()
    {
        return $this->render(
            'Security/login.html.twig'
        );
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = new User();
        $form = $this->createForm(CreateUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->encryptPasswordAndSaveUser($user, $encoder);

            return $this->redirectToRoute('user_edit', ['id' => $user->getId()]);
        }

        return $this->render(
            'User/create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @param int $id
     * @param Request $request
     * @param UserRepository $userRepository
     * @return Response
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     */
    public function edit(int $id, Request $request, UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = $userRepository->find($id);

        if (is_null($user)) {
            throw new NotFoundHttpException('User not found');
        }

        $user->setPlainPassword('dirty-hack-no-idea-why-this-field-needs-a-value');

        $form = $this->createForm(EditUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render(
            'User/edit.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user
            ]
        );
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function reset(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(PasswordResetType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            $this->encryptPasswordAndSaveUser($user, $encoder);
        }

        return $this->render(
            'User/reset.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @param UserRepository $userRepository
     * @return Response
     */
    public function list(UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render(
            'User/list.html.twig',
            [
                'users' => $userRepository->findAll()
            ]
        );
    }

    /**
     * @param User $user
     * @param UserPasswordEncoderInterface $encoder
     */
    private function encryptPasswordAndSaveUser(User $user, UserPasswordEncoderInterface $encoder): void
    {
        $password = $encoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
    }
}
