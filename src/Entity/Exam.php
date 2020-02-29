<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExamRepository")
 */
class Exam
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("exam:add")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("exam:add")
     */
    private $exam_name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Subjects")
     * @Groups("exam:add")
     */
    private $subject;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StudentGroup")
     * @Groups("exam:add")
     */
    private $student_group;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Classes")
     * @Groups("exam:add")
     */
    private $classes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Section")
     * @Groups("exam:add")
     * 
     */
    private $section;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     * @Groups("exam:add")
     */
    private $time;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups("exam:remove")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Session")
     * @Groups("exam:add")
     */
    private $session;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Term")
     * @Groups("exam:add")
     */
    private $term;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExamName(): ?string
    {
        return $this->exam_name;
    }

    public function setExamName(string $exam_name): self
    {
        $this->exam_name = $exam_name;

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

    public function getStudentGroup(): ?StudentGroup
    {
        return $this->student_group;
    }

    public function setStudentGroup(?StudentGroup $student_group): self
    {
        $this->student_group = $student_group;

        return $this;
    }

    public function getClasses(): ?Classes
    {
        return $this->classes;
    }

    public function setClasses(?Classes $classes): self
    {
        $this->classes = $classes;

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

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(?string $time): self
    {
        $this->time = $time;

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
}
