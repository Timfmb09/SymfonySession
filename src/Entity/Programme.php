<?php

namespace App\Entity;

use App\Repository\ProgrammeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProgrammeRepository::class)
 */
class Programme
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbJour;

    /**
     * @ORM\ManyToOne(targetEntity=Session::class, inversedBy="programmes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sessions;

    /**
     * @ORM\ManyToOne(targetEntity=Module::class, inversedBy="programmes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $modules;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbJour(): ?int
    {
        return $this->nbJour;
    }

    public function setNbJour(int $nbJour): self
    {
        $this->nbJour = $nbJour;

        return $this;
    }

    public function getSessions(): ?Session
    {
        return $this->sessions;
    }

    public function setSessions(?Session $sessions): self
    {
        $this->sessions = $sessions;

        return $this;
    }

    public function getModules(): ?Module
    {
        return $this->modules;
    }

    public function setModules(?Module $modules): self
    {
        $this->modules = $modules;

        return $this;
    }
}
