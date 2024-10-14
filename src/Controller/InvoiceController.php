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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class InvoiceController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private MailerInterface $mailer;

    public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    #[Route('/invoice/create', name: 'app_invoice_create')]
    public function creation(Request $request, UserInterface $user): Response
    {
        $invoice = new Invoice();
        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);

        $exist = '0';

        if ($form->isSubmitted() && $form->isValid()) {
            // Verificar si ya existe la factura
            $existingInvoice = $this->entityManager->getRepository(Invoice::class)->findOneBy([
                'ninvoice' => $invoice->getNinvoice()
            ]);
        
            if ($existingInvoice) {
                $this->addFlash('error', 'La factura ya existe. Revisa su estatus');
                $exist = '1';
                return $this->render('invoice/creation.html.twig', [
                    'form' => $form->createView(),
                    'exist' => $exist,
                ]);
            }
        
            // Si no existe, procede a guardar la nueva factura
            $invoice->setCreateAt(new \DateTime('now'));
            $invoice->setUser($user);
            $invoice->setPriority('0');
            $invoice->setImagen('Default_app');
        
            $this->entityManager->persist($invoice);
            $this->entityManager->flush();



            $htmlContent = '
    <p style="font-size: 16px; color: #333; line-height: 1.5;">
        Hola <strong>' . $user->getName() . '</strong>,
    </p>
    <p style="font-size: 16px; color: #333; line-height: 1.5;">
        Se ha creado una nueva factura con el número: <strong>' . $invoice->getNinvoice() . '</strong>.
    </p>
    <p style="font-size: 16px; color: #333; line-height: 1.5;">
        Gracias por usar nuestra plataforma.
    </p>
    <p style="font-size: 16px; color: #555; line-height: 1.5;">
        Saludos,<br>
        El equipo de [Sistemas Travers]
    </p>
    <p>dudas ext:2702</p>
';

            // Enviar el correo de notificación
            $email = (new Email())
                ->from('traversmex@gmail.com') // Cambia esto si es necesario
                ->to($user->getEmail()) // Asegúrate de que el usuario tenga un email
                ->subject('Nueva Factura Creada')
                ->html($htmlContent);

            $this->mailer->send($email);

            return $this->redirectToRoute('index');
        }
        
        return $this->render('invoice/creation.html.twig', [
            'form' => $form->createView(),
            'exist' => $exist
        ]);
    }

    #[Route('/invoice/my-invoices', name: 'app_my_invoices')]
    public function myInvoices(): Response
    {
        $user = $this->getUser(); // Obtiene el usuario actualmente autenticado

        if (!$user instanceof UserInterface) {
            throw $this->createAccessDeniedException('Necesitas estar logueado para acceder a esta página.');
        }

        // Obtener las facturas del usuario junto con las respuestas
        $invoices = $this->entityManager->getRepository(Invoice::class)
            ->createQueryBuilder('i')
            ->leftJoin('i.response', 'r') // Usar el nombre correcto de la relación
            ->addSelect('r') // Selecciona las respuestas también
            ->where('i.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();

        return $this->render('invoice/my-invoice.html.twig', [
            'invoices' => $invoices,
        ]);
    }

    #[Route('/invoice/all', name: 'app_all_invoices')]
    public function allInvoices(): Response
    {
        $invoices = $this->entityManager->getRepository(Invoice::class)->findAll();
    
        // Forzar la inicialización de los usuarios
        foreach ($invoices as $invoice) {
            $user = $invoice->getUser();
            if ($user) {
                // Acceder a algunos métodos para inicializar el proxy
                $user->getEmail(); // Esto forzará la carga
            }
        }
    
        return $this->render('invoice/index.html.twig', [
            'controller_name' => 'InvoiceController',
            'invoices' => $invoices,
        ]);
    }
    
}
