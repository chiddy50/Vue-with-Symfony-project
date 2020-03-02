<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="App\Repository\GradeRepository")
 */
class Grade
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("subject_result:add")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups("subject_result:add")
     */
    public $grade;

    /**
     * @ORM\Column(type="integer")
     * @Groups("subject_result:add")
     */
    public $percent_from;

    /**
     * @ORM\Column(type="integer")
     * @Groups("subject_result:add")
     */
    public $percent_upto;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups("subject_result:add")
     */
    public $comment;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups("subject_result:add")
     */
    public $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getPercentFrom(): ?int
    {
        return $this->percent_from;
    }

    public function setPercentFrom(int $percent_from): self
    {
        $this->percent_from = $percent_from;

        return $this;
    }

    public function getPercentUpto(): ?int
    {
        return $this->percent_upto;
    }

    public function setPercentUpto(int $percent_upto): self
    {
        $this->percent_upto = $percent_upto;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
