<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specijalizacija
 *
 * @ORM\Table(name="specijalizacija")
 * @ORM\Entity
 */
class Specijalizacija
{
    /**
     * @var string
     *
     * @ORM\Column(name="Specijalizacija_id", type="string", length=50, nullable=false)
     * @ORM\Id
     */
    private $specijalizacijaId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Naziv_specijalizacije", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $nazivSpecijalizacije;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Opis_specijalizacije", type="string", length=100, nullable=true, options={"default"="NULL"})
     */
    private $opisSpecijalizacije;

    public function getSpecijalizacijaId(): ?string
    {
        return $this->specijalizacijaId;
    }

    public function setSpecijalizacijaId(?string $specijalizacijaId): self
    {
        $this->specijalizacijaId = $specijalizacijaId;

        return $this;
    }

    public function getNazivSpecijalizacije(): ?string
    {
        return $this->nazivSpecijalizacije;
    }

    public function setNazivSpecijalizacije(?string $nazivSpecijalizacije): self
    {
        $this->nazivSpecijalizacije = $nazivSpecijalizacije;

        return $this;
    }

    public function getOpisSpecijalizacije(): ?string
    {
        return $this->opisSpecijalizacije;
    }

    public function setOpisSpecijalizacije(?string $opisSpecijalizacije): self
    {
        $this->opisSpecijalizacije = $opisSpecijalizacije;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getSpecijalizacijaId();
    }
}
