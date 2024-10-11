<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\InvoiceType;


class UserController extends AbstractController
{
    
   // public function register(): Response
   public function register(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {

    $user = new User();
    $form = $this->createForm(RegisterType::class, $user);


    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) { 
        $user->setRole('ROLE_USER');
        $user->setCreateAt(new \Datetime('now'));
         // CIFRAR CONTRASEÑA Y GUARDAR EN OBJETO 
         $encodedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
         $user->setPassword($encodedPassword);
         $user->setImagen('default_');

        // var_dump($user);
        // Persistir y guardar el usuario
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
    }


        return $this->render('user/register.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->createView()
        ]);
    }





    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        // echo "Action log-in";
        // die();

        return $this->render('user/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }






}
