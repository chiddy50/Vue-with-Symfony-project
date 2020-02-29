<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DesignationRepository")
 */
class Designation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $designation;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $salary;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $entryBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $entryDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StaffInfo", mappedBy="designation")
     */
    private $staffs;

    public function __construct()
    {
        $this->staffs = new ArrayCollection();
    }

    // /**
    //  * @ORM\OneToMany(targetEntity="App\Entity\StaffInfo", mappedBy="designation_id")
    //  */
    // private $staffs;

    // public function __construct()
    // {
    //     $this->staffs = new ArrayCollection();
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getSalary()
    {
        return $this->salary;
    }

    public function setSalary($salary): self
    {
        $this->salary = $salary;

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

    /**
     * @return Collection|StaffInfo[]
     */
    public function getStaffs(): Collection
    {
        return $this->staffs;
    }

    public function addStaff(StaffInfo $staff): self
    {
        if (!$this->staffs->contains($staff)) {
            $this->staffs[] = $staff;
            $staff->setDesignation($this);
        }

        return $this;
    }

    public function removeStaff(StaffInfo $staff): self
    {
        if ($this->staffs->contains($staff)) {
            $this->staffs->removeElement($staff);
            // set the owning side to null (unless already changed)
            if ($staff->getDesignation() === $this) {
                $staff->setDesignation(null);
            }
        }

        return $this;
    }

    // /**
    //  * @return Collection|StaffInfo[]
    //  */
    // public function getStaffs(): Collection
    // {
    //     return $this->staffs;
    // }

    // public function addStaff(StaffInfo $staff): self
    // {
    //     if (!$this->staffs->contains($staff)) {
    //         $this->staffs[] = $staff;
    //         $staff->setDesignationId($this);
    //     }

    //     return $this;
    // }

    // public function removeStaff(StaffInfo $staff): self
    // {
    //     if ($this->staffs->contains($staff)) {
    //         $this->staffs->removeElement($staff);
    //         // set the owning side to null (unless already changed)
    //         if ($staff->getDesignationId() === $this) {
    //             $staff->setDesignationId(null);
    //         }
    //     }

    //     return $this;
    // }
}
