<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="App\Repository\GenderRepository")
 */
class Gender
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"gender:add", "student:add"})
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=10)
     * @Groups({"gender:add", "student:add"})
     */
    public $gender;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StudentInfo", mappedBy="gender")
     * @Groups("gender:remove")
     */
    public $students;

    // public function __construct()
    // {
    //     $this->students = new ArrayCollection();
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

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
    //         $student->setGender($this);
    //     }

    //     return $this;
    // }

    // public function removeStudent(StudentInfo $student): self
    // {
    //     if ($this->students->contains($student)) {
    //         $this->students->removeElement($student);
    //         // set the owning side to null (unless already changed)
    //         if ($student->getGender() === $this) {
    //             $student->setGender(null);
    //         }
    //     }

    //     return $this;
    // }
}
