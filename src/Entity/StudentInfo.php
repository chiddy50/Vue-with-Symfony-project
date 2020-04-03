<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

// use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentInfoRepository")
 */
class StudentInfo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"student:add", "exam_result:add"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10, unique=true)
     * @Groups({"student:add", "exam_result:add"})
     */
    private $roll_no;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups({"student:add", "exam_result:add"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=10)
     * @Groups({"student:add", "exam_result:add"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("student:add")
     */
    private $admission_date;

    /**
     * @ORM\Column(type="datetime")     
     * @Groups("student:add")
     */
    private $dob;
    
    /**
     * @ORM\Column(type="string", length=30, nullable=true)     
     * @Groups("student:add")
     */
    private $email;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Classes", inversedBy="students")
     * @Groups("student:add")
     * 
     */
    private $classes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parents")
     * @Groups("student:add")
     */
    private $parent;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StudentGroup", inversedBy="group_students")     
     * @Groups("student:add")
     */
    private $student_group;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Section", inversedBy="students")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("student:add")
     */
    private $section;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gender", inversedBy="students")
     * @ORM\JoinColumn(nullable=false)     
     * @Groups({"gender:add", "student:add", "exam_result:add"})
     */
    private $gender;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StudentAttendance", mappedBy="students")     
     */
    private $attendance;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     */
    private $entryBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $entryDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClassAttendance", mappedBy="student")
     */
    private $class_attendance;
    

    // public function __construct()
    // {
    //     $this->attendance = new ArrayCollection();
    //     $this->class_attendance = new ArrayCollection();
    // }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRollNo(): ?string
    {
        return $this->roll_no;
    }

    public function setRollNo(string $roll_no): self
    {
        $this->roll_no = $roll_no;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAdmissionDate(): ?\DateTimeInterface
    {
        return $this->admission_date;
    }

    public function setAdmissionDate(\DateTimeInterface $admission_date): self
    {
        $this->admission_date = $admission_date;

        return $this;
    }

    public function getDob(): ?\DateTimeInterface
    {
        return $this->dob;
    }

    public function setDob(\DateTimeInterface $dob): self
    {
        $this->dob = $dob;

        return $this;
    }

    
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

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

    public function getClasses(): ?Classes
    {
        return $this->classes;
    }

    public function setClasses(?Classes $classes): self
    {
        $this->classes = $classes;

        return $this;
    }

    public function getParent(): ?Parents
    {
        return $this->parent;
    }

    public function setParent(?Parents $parent): self
    {
        $this->parent = $parent;

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

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

        return $this;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    // /**
    //  * @return Collection|StudentAttendance[]
    //  */
    // public function getAttendance(): Collection
    // {
    //     return $this->attendance;
    // }

    // public function addAttendance(StudentAttendance $attendance): self
    // {
    //     if (!$this->attendance->contains($attendance)) {
    //         $this->attendance[] = $attendance;
    //         $attendance->setStudents($this);
    //     }

    //     return $this;
    // }

    // public function removeAttendance(StudentAttendance $attendance): self
    // {
    //     if ($this->attendance->contains($attendance)) {
    //         $this->attendance->removeElement($attendance);
    //         // set the owning side to null (unless already changed)
    //         if ($attendance->getStudents() === $this) {
    //             $attendance->setStudents(null);
    //         }
    //     }

    //     return $this;
    // }

    // /**
    //  * @return Collection|ClassAttendance[]
    //  */
    // public function getClassAttendance(): Collection
    // {
    //     return $this->class_attendance;
    // }

    // public function addClassAttendance(ClassAttendance $classAttendance): self
    // {
    //     if (!$this->class_attendance->contains($classAttendance)) {
    //         $this->class_attendance[] = $classAttendance;
    //         $classAttendance->setStudent($this);
    //     }

    //     return $this;
    // }

    // public function removeClassAttendance(ClassAttendance $classAttendance): self
    // {
    //     if ($this->class_attendance->contains($classAttendance)) {
    //         $this->class_attendance->removeElement($classAttendance);
    //         // set the owning side to null (unless already changed)
    //         if ($classAttendance->getStudent() === $this) {
    //             $classAttendance->setStudent(null);
    //         }
    //     }

    //     return $this;
    // }

    

 
}
