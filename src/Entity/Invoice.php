<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invoice
 *
 * @ORM\Table(name="invoice", indexes={@ORM\Index(name="pk_invoice_user", columns={"user_id"})})
 * @ORM\Entity
 */
class Invoice
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ninvoice", type="string", length=255, nullable=true)
     */
    private $ninvoice;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var string|null
     *
     * @ORM\Column(name="priority", type="string", length=20, nullable=true)
     */
    private $priority;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_invoice", type="datetime", nullable=true)
     */
    private $dateInvoice;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="create_at", type="datetime", nullable=true)
     */
    private $createAt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rfc", type="string", length=255, nullable=true)
     */
    private $rfc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="imagen", type="string", length=255, nullable=true)
     */
    private $imagen;

    /**
     * @var float|null
     *
     * @ORM\Column(name="mount", type="decimal", precision=10, scale=4, nullable=true)
     */
    private $mount;

    /**
     * @var User|null
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @var Response|null
     *
     * @ORM\OneToOne(targetEntity="Response", mappedBy="invoice", cascade={"persist", "remove"})
     */
    private $response;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNinvoice(): ?string
    {
        return $this->ninvoice;
    }

    public function setNinvoice(?string $ninvoice): static
    {
        $this->ninvoice = $ninvoice;
        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;
        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(?string $priority): static
    {
        $this->priority = $priority;
        return $this;
    }

    public function getDateInvoice(): ?\DateTimeInterface
    {
        return $this->dateInvoice;
    }

    public function setDateInvoice(?\DateTimeInterface $dateInvoice): static
    {
        $this->dateInvoice = $dateInvoice;
        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(?\DateTimeInterface $createAt): static
    {
        $this->createAt = $createAt;
        return $this;
    }

    public function getRfc(): ?string
    {
        return $this->rfc;
    }

    public function setRfc(?string $rfc): static
    {
        $this->rfc = $rfc;
        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): static
    {
        $this->imagen = $imagen;
        return $this;
    }

    public function getMount(): ?float
    {
        return $this->mount;
    }

    public function setMount(?float $mount): static
    {
        $this->mount = $mount;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getResponse(): ?Response
    {
        return $this->response;
    }

    public function setResponse(?Response $response): static
    {
        $this->response = $response;

        // Asegúrate de que la relación esté sincronizada
        if ($response !== null && $response->getInvoice() !== $this) {
            $response->setInvoice($this);
        }

        return $this;
    }
}
