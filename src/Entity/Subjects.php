<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubjectsRepository")
 */
class Subjects
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"exam:add", "subject:add", "subject_result:add"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"exam:add", "subject:add", "subject_result:add"})
     */
    private $subject;

    /**
     * @ORM\Column(type="string", length=15)
     * @Groups("subject:add")
     */
    private $subject_code;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("subject:add")
     */
    private $entryBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("subject:add")
     */
    private $entyDate;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Classes", mappedBy="subjects")
     */
    private $classes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SubjectType")
     * @Groups("subject:add")
     */
    private $subject_type;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ClassAttendance", mappedBy="subject_id")
     */
    private $subject_attendance;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\StudentGroup", mappedBy="subjects")
     */
    private $groups;

    // public function __construct()
    // {
    //     $this->subject_attendance = new ArrayCollection();
    //     $this->groups = new ArrayCollection();
    // }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getSubjectCode(): ?string
    {
        return $this->subject_code;
    }

    public function setSubjectCode(string $subject_code): self
    {
        $this->subject_code = $subject_code;

        return $this;
    }

    public function getEntryBy(): ?string
    {
        return $this->entryBy;
    }

    public function setEntryBy(string $entryBy): self
    {
        $this->entryBy = $entryBy;

        return $this;
    }

    public function getEntyDate(): ?\DateTimeInterface
    {
        return $this->entyDate;
    }

    public function setEntyDate(?\DateTimeInterface $entyDate): self
    {
        $this->entyDate = $entyDate;

        return $this;
    }

    // /**
    //  * @return Collection|Classes[]
    //  */
    // public function getClasses(): Collection
    // {
    //     return $this->classes;
    // }

    // public function addClass(Classes $class): self
    // {
    //     if (!$this->classes->contains($class)) {
    //         $this->classes[] = $class;
    //         $class->addSubject($this);
    //     }

    //     return $this;
    // }

    // public function removeClass(Classes $class): self
    // {
    //     if ($this->classes->contains($class)) {
    //         $this->classes->removeElement($class);
    //         $class->removeSubject($this);
    //     }

    //     return $this;
    // }

    public function getSubjectType(): ?SubjectType
    {
        return $this->subject_type;
    }

    public function setSubjectType(?SubjectType $subject_type): self
    {
        $this->subject_type = $subject_type;

        return $this;
    }

    public function addGroup(StudentGroup $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->addSubject($this);
        }

        return $this;
    }

    public function removeGroup(StudentGroup $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
            $group->removeSubject($this);
        }

        return $this;
    }

    
}
