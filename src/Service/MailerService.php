<?php



// src/Service/MailerService.php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendInvoiceEmail($userEmail, $invoice)
    {
        $email = (new Email())
            ->from('traversmex@gmail.com')
            ->to($userEmail)
            ->addTo('jesussoft95@gmail.com')
            ->subject('Nueva Factura Creada')
            ->html('<p>Se ha creado una nueva factura con el número: ' . $invoice->getNinvoice() . '</p>');

        $this->mailer->send($email);
    }
}
