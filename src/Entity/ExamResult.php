<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ExamResultRepository")
 */
class ExamResult
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("exam_result:add")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StudentInfo")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("exam_result:add")
     */
    private $student;

    /**
     * @ORM\Column(type="integer")
     * @Groups("exam_result:add")
     */
    private $first_ca;

    /**
     * @ORM\Column(type="integer")
     * @Groups("exam_result:add")
     */
    private $second_ca;

    /**
     * @ORM\Column(type="integer")
     * @Groups("exam_result:add")
     */
    private $exam;

    /**
     * @ORM\Column(type="integer")
     * @Groups("exam_result:add")
     */
    private $total;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Grade")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("exam_result:add")
     */
    private $grade;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Subjects")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("exam_result:add")
     */
    private $subject;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Session")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("exam_result:add")
     */
    private $session;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Term")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("exam_result:add")
     */
    private $term;

    /**
     * @ORM\Column(type="date")
     * @Groups("exam_result:add")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Classes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("exam_result:add")
     */
    private $class;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Section")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("exam_result:add")
     */
    private $section;

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

    public function getFirstCa(): ?int
    {
        return $this->first_ca;
    }

    public function setFirstCa(?int $first_ca): self
    {
        $this->first_ca = $first_ca;

        return $this;
    }

    public function getSecondCa(): ?int
    {
        return $this->second_ca;
    }

    public function setSecondCa(?int $second_ca): self
    {
        $this->second_ca = $second_ca;

        return $this;
    }

    public function getExam(): ?int
    {
        return $this->exam;
    }

    public function setExam(int $exam): self
    {
        $this->exam = $exam;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

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

    public function getTerm(): ?Term
    {
        return $this->term;
    }

    public function setTerm(?Term $term): self
    {
        $this->term = $term;

        return $this;
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

    public function getClass(): ?Classes
    {
        return $this->class;
    }

    public function setClass(?Classes $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

        return $this;
    }
}
