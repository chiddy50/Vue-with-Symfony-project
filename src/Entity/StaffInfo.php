<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StaffInfoRepository")
 */
class StaffInfo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $staff_no;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $fullname;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=9)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=11)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $marital_status;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_of_employment;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $termination_date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $entryBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $entryDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Designation", inversedBy="staffs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $designation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StaffType", inversedBy="staffs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $staff_type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StaffStatus", inversedBy="staffs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $staff_status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStaffNo(): ?int
    {
        return $this->staff_no;
    }

    public function setStaffNo(int $staff_no): self
    {
        $this->staff_no = $staff_no;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }


    public function getMaritalStatus(): ?string
    {
        return $this->marital_status;
    }

    public function setMaritalStatus(string $marital_status): self
    {
        $this->marital_status = $marital_status;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateOfEmployment(): ?\DateTimeInterface
    {
        return $this->date_of_employment;
    }

    public function setDateOfEmployment(\DateTimeInterface $date_of_employment): self
    {
        $this->date_of_employment = $date_of_employment;

        return $this;
    }

    public function getTerminationDate(): ?\DateTimeInterface
    {
        return $this->termination_date;
    }

    public function setTerminationDate(?\DateTimeInterface $termination_date): self
    {
        $this->termination_date = $termination_date;

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

    public function getDesignation(): ?Designation
    {
        return $this->designation;
    }

    public function setDesignation(?Designation $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getStaffType(): ?StaffType
    {
        return $this->staff_type;
    }

    public function setStaffType(?StaffType $staff_type): self
    {
        $this->staff_type = $staff_type;

        return $this;
    }

    public function getStaffStatus(): ?StaffStatus
    {
        return $this->staff_status;
    }

    public function setStaffStatus(?StaffStatus $staff_status): self
    {
        $this->staff_status = $staff_status;

        return $this;
    }
}
