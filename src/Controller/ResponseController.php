<?php

namespace App\Controller;

use App\Entity\Response;
use App\Entity\Invoice; // Asegúrate de importar la clase Invoice
use App\Form\ResponseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse; // Alias para evitar confusiones
use Symfony\Component\Routing\Annotation\Route;

class ResponseController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/invoice/{invoiceId}', name: 'app_invoice_response_create')]
    public function create(Request $request, int $invoiceId): HttpResponse
    {
        $response = new Response();
        $form = $this->createForm(ResponseType::class, $response);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pdfFile = $form->get('pdfFilename')->getData();
            $xmlFile = $form->get('xmlFilename')->getData();

            // Asignar nombres únicos a los archivos
            $pdfFilename = uniqid().'.'.$pdfFile->guessExtension();
            $xmlFilename = uniqid().'.'.$xmlFile->guessExtension();

            // Mover los archivos a sus respectivos directorios
            $pdfFile->move($this->getParameter('pdf_directory'), $pdfFilename);
            $xmlFile->move($this->getParameter('xml_directory'), $xmlFilename);

            // Asignar los valores a la entidad
            $response->setPdfFilename($pdfFilename);
            $response->setXmlFilename($xmlFilename);
            $response->setUuid($form->get('uuid')->getData()); // Cambiado a 'uuid'

            // Obtener la factura relacionada
            $invoice = $this->entityManager->getRepository(Invoice::class)->find($invoiceId);
            if ($invoice) {
                $response->setInvoice($invoice);
            }

            // Persistir la respuesta
            $this->entityManager->persist($response);
            $this->entityManager->flush();

            //return $this->redirectToRoute('app_invoice_view', ['id' => $invoiceId]);

            return $this->redirectToRoute('index', );
        }

        return $this->render('response/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
