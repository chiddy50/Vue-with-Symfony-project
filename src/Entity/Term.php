<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="App\Repository\TermRepository")
 */
class Term
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"term:add", "exam:add"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"term:add", "exam:add", "exam_result:add"})
     */
    private $term_code;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"term:add", "exam:add"})
     */
    private $term_description;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTermCode(): ?string
    {
        return $this->term_code;
    }

    public function setTermCode(string $term_code): self
    {
        $this->term_code = $term_code;

        return $this;
    }

    public function getTermDescription(): ?string
    {
        return $this->term_description;
    }

    public function setTermDescription(string $term_description): self
    {
        $this->term_description = $term_description;

        return $this;
    }

    
}
