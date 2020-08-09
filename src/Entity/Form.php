<?php

namespace App\Entity;

use App\Repository\FormRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FormRepository::class)
 */
class Form
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/[0-9]{10}/")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(min=10)
     */
    private $adress;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(min=20)
     */
    private $message;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
