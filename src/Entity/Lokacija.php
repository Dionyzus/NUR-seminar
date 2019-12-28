<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lokacija
 *
 * @ORM\Table(name="lokacija", indexes={@ORM\Index(name="Namjena", columns={"Namjena"}), @ORM\Index(name="Ustanova", columns={"Ustanova"}), @ORM\Index(name="Organizacija", columns={"Organizacija"})})
 * @ORM\Entity
 */
class Lokacija
{
    /**
     * @var string
     *
     * @ORM\Column(name="Broj_ucionice", type="string", length=50, nullable=false)
     * @ORM\Id
     */
    private $brojUcionice;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Opis", type="string", length=100, nullable=true, options={"default"="NULL"})
     */
    private $opis;

    /**
     * @var \Ustanova
     *
     * @ORM\ManyToOne(targetEntity="Ustanova")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Ustanova", referencedColumnName="Ustanova_ID")
     * })
     */
    private $ustanova;

    /**
     * @var \Organizacija
     *
     * @ORM\ManyToOne(targetEntity="Organizacija")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Organizacija", referencedColumnName="Organizacija_ID")
     * })
     */
    private $organizacija;

    /**
     * @var \Namjena
     *
     * @ORM\ManyToOne(targetEntity="Namjena")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Namjena", referencedColumnName="Namjena_ID")
     * })
     */
    private $namjena;

    public function getBrojUcionice(): ?string
    {
        return $this->brojUcionice;
    }

    public function setBrojUcionice(?string $brojUcionice): self
    {
        $this->brojUcionice = $brojUcionice;

        return $this;
    }

    public function getOpis(): ?string
    {
        return $this->opis;
    }

    public function setOpis(?string $opis): self
    {
        $this->opis = $opis;

        return $this;
    }

    public function getUstanova(): ?Ustanova
    {
        return $this->ustanova;
    }

    public function setUstanova(?Ustanova $ustanova): self
    {
        $this->ustanova = $ustanova;

        return $this;
    }

    public function getOrganizacija(): ?Organizacija
    {
        return $this->organizacija;
    }

    public function setOrganizacija(?Organizacija $organizacija): self
    {
        $this->organizacija = $organizacija;

        return $this;
    }

    public function getNamjena(): ?Namjena
    {
        return $this->namjena;
    }

    public function setNamjena(?Namjena $namjena): self
    {
        $this->namjena = $namjena;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getBrojUcionice();
    }
}
