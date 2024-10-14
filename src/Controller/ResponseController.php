<?php

namespace App\Controller;

use App\Entity\Response;
use App\Entity\Invoice;
use App\Form\ResponseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ResponseController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private MailerInterface $mailer;

    public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
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
            $pdfFilename = uniqid() . '.' . $pdfFile->guessExtension();
            $xmlFilename = uniqid() . '.' . $xmlFile->guessExtension();

            // Mover los archivos a sus respectivos directorios
            $pdfFile->move($this->getParameter('pdf_directory'), $pdfFilename);
            $xmlFile->move($this->getParameter('xml_directory'), $xmlFilename);

            // Asignar los valores a la entidad
            $response->setPdfFilename($pdfFilename);
            $response->setXmlFilename($xmlFilename);
            $response->setUuid($form->get('uuid')->getData());

            // Obtener la factura relacionada
            $invoice = $this->entityManager->getRepository(Invoice::class)->find($invoiceId);
            if ($invoice) {
                $response->setInvoice($invoice);

                // Obtener el correo del usuario que creó la factura
                $userEmail = $invoice->getUser()->getEmail();

                // Persistir la respuesta
                $this->entityManager->persist($response);
                $this->entityManager->flush();

                // Enviar el correo al usuario que creó la factura
                $email = (new Email())
                    ->from('traversmex@gmail.com')
                    ->to($userEmail)
                    ->subject('Tu factura está lista para descargar')
                    ->html('<p>Hola,</p>
                            <p>Tu factura con el número ' . $invoice->getNinvoice() . ' ha sido procesada y está lista para descargar.</p>
                            <p>Por favor, ingresa a la plataforma para acceder a ella.</p>');

                $this->mailer->send($email);
            }

            return $this->redirectToRoute('invoices');
        }

        return $this->render('response/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
