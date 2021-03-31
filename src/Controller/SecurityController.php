<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, UsersRepository $usersRepository): Response
    {
      //  $users = $usersRepository->findAll();

    //    if ($this->getUser() && $this->getRoles() == ["ROLE_ADMIN" ,"ROLE_USER"] ) {
      //      return $this->redirectToRoute('admin');
      //  }

       if ($this->getUser()) {

          return $this->redirectToRoute('home');
    }

     //  if ($this->getUser() && $this->getRoles()=='ROLE_ADMIN') {
     //       return $this->redirectToRoute('admin');
      //  }


        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');

    }


/*
    /**
     * @Route("/delete/{id})
     */
 /*   public function deleteAction ($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(Users::class)->find($id);


        if (!$user) {
            throw $this->createNotFoundException('No student found for id '.$id);
        }

        $entityManager ->remove($user);
        $entityManager ->flush();

        return new Response('Record deleted!');
    }*/

    /**
     * @Route("/delete/{id}" , name="delete")
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(Users::class);
        $user = $user->find($id);
        if (!$user) {
            throw $this->createNotFoundException(
                'There are no user with the following id: ' . $id
            );
        }
        $em->remove($user);
        $em->flush();
        return $this->redirect($this->generateUrl('home'));
    }


}
