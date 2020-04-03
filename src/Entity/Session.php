<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="App\Repository\SessionRepository")
 */
class Session
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"session:add", "exam:add", "exam_result:add"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     * @Groups({"session:add", "exam:add", "exam_result:add"})
     */
    private $session;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StudentAttendance", mappedBy="session")
     */
    private $attendance;

    // public function __construct()
    // {
    //     $this->attendance = new ArrayCollection();
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSession(): ?string
    {
        return $this->session;
    }

    public function setSession(string $session): self
    {
        $this->session = $session;

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
    //         $attendance->setSession($this);
    //     }

    //     return $this;
    // }

    // public function removeAttendance(StudentAttendance $attendance): self
    // {
    //     if ($this->attendance->contains($attendance)) {
    //         $this->attendance->removeElement($attendance);
    //         // set the owning side to null (unless already changed)
    //         if ($attendance->getSession() === $this) {
    //             $attendance->setSession(null);
    //         }
    //     }

    //     return $this;
    // }
}
