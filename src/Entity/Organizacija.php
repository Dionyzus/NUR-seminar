<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Organizacija
 *
 * @ORM\Table(name="organizacija")
 * @ORM\Entity
 */
class Organizacija
{
    /**
     * @var int
     *
     * @ORM\Column(name="Organizacija_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $organizacijaId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Naziv_organizacije", type="string", length=65, nullable=true, options={"default"="NULL"})
     */
    private $nazivOrganizacije;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Opis_organizacije", type="string", length=100, nullable=true, options={"default"="NULL"})
     */
    private $opisOrganizacije;

    public function getOrganizacijaId(): ?int
    {
        return $this->organizacijaId;
    }

    public function getNazivOrganizacije(): ?string
    {
        return $this->nazivOrganizacije;
    }

    public function setNazivOrganizacije(?string $nazivOrganizacije): self
    {
        $this->nazivOrganizacije = $nazivOrganizacije;

        return $this;
    }

    public function getOpisOrganizacije(): ?string
    {
        return $this->opisOrganizacije;
    }

    public function setOpisOrganizacije(?string $opisOrganizacije): self
    {
        $this->opisOrganizacije = $opisOrganizacije;

        return $this;
    }


}
