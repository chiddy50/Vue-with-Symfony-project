<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="App\Repository\SubjectTypeRepository")
 */
class SubjectType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("subject:add")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups("subject:add")
     */
    private $subject_type;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("subject:add")
     */
    private $entryBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("subject:add")
     */
    private $entryDate;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubjectType(): ?string
    {
        return $this->subject_type;
    }

    public function setSubjectType(string $subject_type): self
    {
        $this->subject_type = $subject_type;

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

    public function setEntryDate(?\DateTimeInterface $entryDate): self
    {
        $this->entryDate = $entryDate;

        return $this;
    }

    
}
