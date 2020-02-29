<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StaffTypeRepository")
 */
class StaffType
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
    private $staff_type;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $entryBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $entryDate;

    // /**
    //  * @ORM\OneToMany(targetEntity="App\Entity\StaffInfo", mappedBy="staff_type")
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

    public function getStaffType(): ?string
    {
        return $this->staff_type;
    }

    public function setStaffType(string $staff_type): self
    {
        $this->staff_type = $staff_type;

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
    //         $staff->setStaffType($this);
    //     }

    //     return $this;
    // }

    // public function removeStaff(StaffInfo $staff): self
    // {
    //     if ($this->staffs->contains($staff)) {
    //         $this->staffs->removeElement($staff);
    //         // set the owning side to null (unless already changed)
    //         if ($staff->getStaffType() === $this) {
    //             $staff->setStaffType(null);
    //         }
    //     }

    //     return $this;
    // }

    
}
