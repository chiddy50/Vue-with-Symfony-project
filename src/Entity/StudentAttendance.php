<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentAttendanceRepository")
 */
class StudentAttendance
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    public $date;

    /**
     * @ORM\Column(type="boolean")
     */
    public $present;

    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Month", inversedBy="attendance")
     * @ORM\JoinColumn(nullable=true)
     */
    public $month;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Session", inversedBy="attendance")
     * @ORM\JoinColumn(nullable=true)
     */
    public $session;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StudentInfo", inversedBy="attendance")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="CASCADE")
     */
    public $students;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    public $entryBy;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    public $entryDate;



    public function getId(): ?int
    {
        return $this->id;
    }

   
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
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

    public function getStudents(): ?StudentInfo
    {
        return $this->student;
    }

    public function setStudents(?StudentInfo $students): self
    {
        $this->students = $students;

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
