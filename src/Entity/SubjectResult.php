<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubjectResultRepository")
 */
class SubjectResult
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("subject_result:add")
     */
    public $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StudentInfo")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("subject_result:add")
     */
    public $student;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Grade")
     * @Groups("subject_result:add")
     */
    public $grade;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Subjects")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("subject_result:add")
     */
    public $subject;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Session")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("subject_result:add")
     */
    public $session;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups("subject_result:add")
     */
    public $date;

    /**
     * @ORM\Column(type="integer")
     * @Groups("subject_result:add")
     */
    public $score;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Term")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("subject_result:add")
     */
    public $term;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getGrade(): ?Grade
    {
        return $this->grade;
    }

    public function setGrade(?Grade $grade): self
    {
        $this->grade = $grade;

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

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        $this->session = $session;

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

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getTerm(): ?Term
    {
        return $this->term;
    }

    public function setTerm(?Term $term): self
    {
        $this->term = $term;

        return $this;
    }
}
