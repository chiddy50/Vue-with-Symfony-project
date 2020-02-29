<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ParentsRepository")
 */
class Parents
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("student:add")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("student:add")
     */
    private $fullname;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     * @Groups("student:add")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=9)
     * @Groups("student:add")
     */
    private $gender;

    /**
     * @ORM\Column(type="text")
     * @Groups("student:add")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups("student:add")
     */
    private $phone;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("student:add")
     */
    private $entryBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("student:add")
     */
    private $entryDate;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

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

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEntryBy(): ?int
    {
        return $this->entryBy;
    }

    public function setEntryBy(int $entryBy): self
    {
        $this->entryBy = $entryBy;

        return $this;
    }

    public function getEntryDate(): ?\DateTimeInterface
    {
        return $this->entryDate;
    }

    public function setEntryDate(\DateTimeInterface $entryDate): self
    {
        $this->entryDate = $entryDate;

        return $this;
    }

    
}
