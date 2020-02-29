<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentGroupRepository")
 */
class StudentGroup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"student_group:add", "exam:add", "student:add"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"student_group:add", "exam:add", "student:add"})
     */
    private $group_name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StudentInfo", mappedBy="student_group")
     */
    private $group_students;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Subjects", inversedBy="groups")
     * @ORM\JoinTable(
     *  name="subject_group",
     *  joinColumns={
     *      @ORM\JoinColumn(name="student_group_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
     *  }
     * )
     */
    private $subjects;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Exam", mappedBy="student_group", orphanRemoval=true)
     */
    private $exams;

    // public function __construct()
    // {
    //     $this->group_students = new ArrayCollection();
    //     $this->subjects = new ArrayCollection();
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupName(): ?string
    {
        return $this->group_name;
    }

    public function setGroupName(string $group_name): self
    {
        $this->group_name = $group_name;

        return $this;
    }

    // /**
    //  * @return Collection|StudentInfo[]
    //  */
    // public function getGroupStudents(): Collection
    // {
    //     return $this->group_students;
    // }

    // public function addGroupStudent(StudentInfo $groupStudent): self
    // {
    //     if (!$this->group_students->contains($groupStudent)) {
    //         $this->group_students[] = $groupStudent;
    //         $groupStudent->setStudentGroup($this);
    //     }

    //     return $this;
    // }

    // public function removeGroupStudent(StudentInfo $groupStudent): self
    // {
    //     if ($this->group_students->contains($groupStudent)) {
    //         $this->group_students->removeElement($groupStudent);
    //         // set the owning side to null (unless already changed)
    //         if ($groupStudent->getStudentGroup() === $this) {
    //             $groupStudent->setStudentGroup(null);
    //         }
    //     }

    //     return $this;
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

}
