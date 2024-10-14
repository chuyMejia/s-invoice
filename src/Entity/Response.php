<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="response")
 */
class Response
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="pdfFilename", type="string", length=255)
     */
    private $pdfFilename;

    /**
     * @ORM\Column(name="xmlFilename", type="string", length=255)
     */
    private $xmlFilename;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $uuid;

    /**
     * @ORM\ManyToOne(targetEntity="Invoice", inversedBy="responses")
     * @ORM\JoinColumn(name="invoice_id", referencedColumnName="id", nullable=false)
     */
    private $invoice;

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPdfFilename(): ?string
    {
        return $this->pdfFilename;
    }

    public function setPdfFilename(string $pdfFilename): self
    {
        $this->pdfFilename = $pdfFilename;
        return $this;
    }

    public function getXmlFilename(): ?string
    {
        return $this->xmlFilename;
    }

    public function setXmlFilename(string $xmlFilename): self
    {
        $this->xmlFilename = $xmlFilename;
        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): self
    {
        $this->invoice = $invoice;
        return $this;
    }
}
