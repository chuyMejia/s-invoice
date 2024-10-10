<?php

namespace App\Controller;

use App\Entity\Invoice;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceController extends AbstractController
{
    #[Route('/invoice', name: 'app_invoice')]
    public function index(): Response
    {
        return $this->render('invoice/index.html.twig', [
            'controller_name' => 'InvoiceController',
        ]);
    }

    #[Route('/invoices', name: 'app_all_invoices')] // Agrega una ruta para listar todas las facturas
    public function allInvoices(EntityManagerInterface $entityManager): Response
    {
        $invoiceRepo = $entityManager->getRepository(Invoice::class);
        $invoices = $invoiceRepo->findAll(); // Cambié el nombre de la variable a invoices

        dump($invoices); // Para depurar
        die();

        return $this->render('invoice/all_invoices.html.twig', [
            'controller_name' => 'InvoiceController',
            'invoices' => $invoices, // Cambié el nombre de la variable a invoices
        ]);
    }
}
