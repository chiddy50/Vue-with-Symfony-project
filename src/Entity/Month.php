<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="App\Repository\MonthRepository")
 */
class Month
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("month:add")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     * @Groups("month:add")
     */
    private $month;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StudentAttendance", mappedBy="month")
     */
    private $attendance;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClassAttendance", mappedBy="month")
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

    public function getMonth(): ?string
    {
        return $this->month;
    }

    public function setMonth(string $month): self
    {
        $this->month = $month;

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
    //         $attendance->setMonth($this);
    //     }

    //     return $this;
    // }

    // public function removeAttendance(StudentAttendance $attendance): self
    // {
    //     if ($this->attendance->contains($attendance)) {
    //         $this->attendance->removeElement($attendance);
    //         // set the owning side to null (unless already changed)
    //         if ($attendance->getMonth() === $this) {
    //             $attendance->setMonth(null);
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
    //         $classAttendance->setMonth($this);
    //     }

    //     return $this;
    // }

    // public function removeClassAttendance(ClassAttendance $classAttendance): self
    // {
    //     if ($this->class_attendance->contains($classAttendance)) {
    //         $this->class_attendance->removeElement($classAttendance);
    //         // set the owning side to null (unless already changed)
    //         if ($classAttendance->getMonth() === $this) {
    //             $classAttendance->setMonth(null);
    //         }
    //     }

    //     return $this;
    // }
}
