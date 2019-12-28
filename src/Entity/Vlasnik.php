<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vlasnik
 *
 * @ORM\Table(name="vlasnik")
 * @ORM\Entity
 */
class Vlasnik
{
    /**
     * @var int
     *
     * @ORM\Column(name="Vlasnik_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $vlasnikId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Naziv_vlasnika", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $nazivVlasnika;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Kontakt_broj", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $kontaktBroj;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Elektronska_posta", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $elektronskaPosta;

    public function getVlasnikId(): ?int
    {
        return $this->vlasnikId;
    }

    public function getNazivVlasnika(): ?string
    {
        return $this->nazivVlasnika;
    }

    public function setNazivVlasnika(?string $nazivVlasnika): self
    {
        $this->nazivVlasnika = $nazivVlasnika;

        return $this;
    }

    public function getKontaktBroj(): ?string
    {
        return $this->kontaktBroj;
    }

    public function setKontaktBroj(?string $kontaktBroj): self
    {
        $this->kontaktBroj = $kontaktBroj;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->elektronskaPosta;
    }

    public function setEmail(?string $elektronskaPosta): self
    {
        $this->elektronskaPosta = $elektronskaPosta;

        return $this;
    }


}
