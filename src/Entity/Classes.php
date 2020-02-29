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

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\StudentAttendance", mappedBy="class_id")
     * @Groups("class:remove")
     */
    private $class_attendance;

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
    //  * @return Collection|Subjects[]
    //  */
    // public function getSubjects(): Collection
    // {
    //     return $this->subjects;
    // }

    // public function addSubject(Subjects $subject): self
    // {
    //     if (!$this->subjects->contains($subject)) {
    //         $this->subjects[] = $subject;
    //     }

    //     return $this;
    // }

    // public function removeSubject(Subjects $subject): self
    // {
    //     if ($this->subjects->contains($subject)) {
    //         $this->subjects->removeElement($subject);
    //     }

    //     return $this;
    // }

    // /**
    //  * @return Collection|StudentInfo[]
    //  */
    // public function getStudents(): Collection
    // {
    //     return $this->students;
    // }

    // public function addStudent(StudentInfo $student): self
    // {
    //     if (!$this->students->contains($student)) {
    //         $this->students[] = $student;
    //         $student->setClasses($this);
    //     }

    //     return $this;
    // }

    // public function removeStudent(StudentInfo $student): self
    // {
    //     if ($this->students->contains($student)) {
    //         $this->students->removeElement($student);
    //         // set the owning side to null (unless already changed)
    //         if ($student->getClasses() === $this) {
    //             $student->setClasses(null);
    //         }
    //     }

    //     return $this;
    // }

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

    // /**
    //  * @return Collection|Exam[]
    //  */
    // public function getExams(): Collection
    // {
    //     return $this->exams;
    // }

    // public function addExam(Exam $exam): self
    // {
    //     if (!$this->exams->contains($exam)) {
    //         $this->exams[] = $exam;
    //         $exam->setClasses($this);
    //     }

    //     return $this;
    // }

    // public function removeExam(Exam $exam): self
    // {
    //     if ($this->exams->contains($exam)) {
    //         $this->exams->removeElement($exam);
    //         // set the owning side to null (unless already changed)
    //         if ($exam->getClasses() === $this) {
    //             $exam->setClasses(null);
    //         }
    //     }

    //     return $this;
    // }

   
}
