<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClassesRepository")
 */
class Classes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"class:add", "exam:add", "student:add"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups({"class:add", "exam:add", "student:add"})
     */
    private $class_name;

    /**
     * @ORM\Column(type="string", length=5)
     * @Groups({"class:add", "exam:add"})
     */
    private $class_code;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("class:remove")
     */
    private $entryBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("class:remove")
     */
    private $entryDate;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Subjects", inversedBy="classes")
     * @Groups("class:remove")
     */
    private $subjects;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StudentInfo", mappedBy="classes")
     * @Groups("class:remove")
     */
    private $students;

    // /**
    //  * @ORM\ManyToMany(targetEntity="App\Entity\StudentAttendance", mappedBy="class_id")
    //  * @Groups("class:remove")
    //  */
    // private $class_attendance;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Exam", mappedBy="classes", orphanRemoval=true)
     * @Groups("class:remove")
     */
    private $exams;

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClassName(): ?string
    {
        return $this->class_name;
    }

    public function setClassName(string $class_name): self
    {
        $this->class_name = $class_name;

        return $this;
    }

    public function getClassCode(): ?string
    {
        return $this->class_code;
    }

    public function setClassCode(string $class_code): self
    {
        $this->class_code = $class_code;

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

   


    // /**
    //  * @return Collection|StudentAttendance[]
    //  */
    // public function getClassAttendance(): Collection
    // {
    //     return $this->class_attendance;
    // }

    // public function addClassAttendance(StudentAttendance $classAttendance): self
    // {
    //     if (!$this->class_attendance->contains($classAttendance)) {
    //         $this->class_attendance[] = $classAttendance;
    //         $classAttendance->addClassId($this);
    //     }

    //     return $this;
    // }

    // public function removeClassAttendance(StudentAttendance $classAttendance): self
    // {
    //     if ($this->class_attendance->contains($classAttendance)) {
    //         $this->class_attendance->removeElement($classAttendance);
    //         $classAttendance->removeClassId($this);
    //     }

    //     return $this;
    // }

   
}
