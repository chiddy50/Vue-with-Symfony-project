<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClassAttendanceRepository")
 */
class ClassAttendance
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="boolean")
     */
    public $present;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    public $entryBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $entryDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Month", inversedBy="class_attendance")
     * @ORM\JoinColumn(nullable=true)
     */
    public $month;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Session")
     * @ORM\JoinColumn(nullable=true)
     */
    public $session;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StudentInfo", inversedBy="class_attendance")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    public $student;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Subjects")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    public $subject;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $date;


    public function getId(): ?int
    {
        return $this->id;
    }



    public function getPresent(): ?bool
    {
        return $this->present;
    }

    public function setPresent(bool $present): self
    {
        $this->present = $present;

        return $this;
    }

    public function getEntryBy(): ?int
    {
        return $this->entryBy;
    }

    public function setEntryBy(?int $entryBy): self
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

    public function getMonth(): ?Month
    {
        return $this->month;
    }

    public function setMonth(?Month $month): self
    {
        $this->month = $month;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        $this->session = $session;

        return $this;
    }

    public function getStudent(): ?StudentInfo
    {
        return $this->student;
    }

    public function setStudent(?StudentInfo $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getSubject(): ?Subjects
    {
        return $this->subject;
    }

    public function setSubject(?Subjects $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }


    

    
}
