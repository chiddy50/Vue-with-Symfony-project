<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
// use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SectionRepository")
 */
class Section
{
    // use TimestampableEntity;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"exam:add", "section:add", "student:add"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     * @Groups({"exam:add", "section:add", "student:add"})
     */
    private $section_name;

    /**
     * @ORM\Column(type="string", length=7)
     * @Groups({"section:add", "student:add"})
     */
    private $section_code;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $entryBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $entryDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StudentInfo", mappedBy="section")
     */
    private $students;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSectionName(): ?string
    {
        return $this->section_name;
    }

    public function setSectionName(string $section_name): self
    {
        $this->section_name = $section_name;

        return $this;
    }

    public function getSectionCode(): ?string
    {
        return $this->section_code;
    }

    public function setSectionCode(string $section_code): self
    {
        $this->section_code = $section_code;

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
