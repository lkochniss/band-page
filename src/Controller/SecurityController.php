<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\CreateUserType;
use App\Form\Type\EditUserType;
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

    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(CreateUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

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
     */
    public function edit(int $id, Request $request, UserRepository $userRepository): Response
    {
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

    public function list(UserRepository $userRepository): Response
    {
        return $this->render(
            'User/list.html.twig',
            [
                'users' => $userRepository->findAll()
            ]
        );
    }
}
