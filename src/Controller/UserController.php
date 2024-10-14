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
use Doctrine\ORM\EntityManagerInterface;


class UserController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $user->setRole('ROLE_USER');
            $user->setCreateAt(new \Datetime('now'));
            $encodedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($encodedPassword);
            $user->setImagen('default_');

            // Persistir y guardar el usuario
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // Redirigir o mostrar un mensaje de éxito, si lo deseas

            

            return $this->redirectToRoute('index');



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

        return $this->render('user/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }

public function AllUsers(){
    $users = $this->entityManager->getRepository(User::class)->findAll();


    //var_dump($invoices);


return $this->render('user/index.html.twig', ['users' => $users
  
]);

}


public function DetailUser(Request $request, int $userid): Response {
    $user = $this->entityManager->getRepository(User::class)->find($userid);
    
    // Verifica si el usuario fue encontrado
    if (!$user) {
        throw $this->createNotFoundException('Usuario no encontrado');
    }

    // Realiza la consulta para contar las facturas
    $invoiceData = $this->entityManager->createQueryBuilder()
        ->select('COUNT(i.id) AS total_invoices,
                  SUM(CASE WHEN r.id IS NOT NULL THEN 1 ELSE 0 END) AS completas,
                  SUM(CASE WHEN r.id IS NULL THEN 1 ELSE 0 END) AS faltantes')
        ->from('App\Entity\Invoice', 'i')
        ->leftJoin('i.response', 'r')
        ->where('i.user = :userId')
        ->setParameter('userId', $userid)
        ->getQuery()
        ->getSingleResult();

    return $this->render('user/detail.html.twig', [
        'user' => $user,
        'invoiceData' => $invoiceData
    ]);
}



}



