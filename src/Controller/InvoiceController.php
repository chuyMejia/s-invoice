<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Form\InvoiceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class InvoiceController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/invoice/create', name: 'app_invoice_create')]
    public function creation(Request $request, UserInterface $user): Response
    {
        $invoice = new Invoice();
        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoice->setCreateAt(new \DateTime('now'));
            $invoice->setUser($user);
            $invoice->setImagen('Default_app');

            $this->entityManager->persist($invoice);
            $this->entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('invoice/creation.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/invoice/my-invoices', name: 'app_my_invoices')]
    public function myInvoices(): Response
    {
        $user = $this->getUser(); // Obtiene el usuario actualmente autenticado

        if (!$user instanceof UserInterface) {
            throw $this->createAccessDeniedException('Necesitas estar logueado para acceder a esta página.');
        }

        // Obtener las facturas del usuario
        // Aquí deberías agregar la lógica para obtener las facturas relacionadas con el usuario
         $invoices = $this->entityManager->getRepository(Invoice::class)->findBy(['user' => $user]);

        return $this->render('invoice/my-invoice.html.twig', [
             'invoices' => $invoices,
        ]);
    }
}
