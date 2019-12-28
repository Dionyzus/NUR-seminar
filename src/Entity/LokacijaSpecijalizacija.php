<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LokacijaSpecijalizacija
 *
 * @ORM\Table(name="lokacija_specijalizacija", indexes={@ORM\Index(name="IDX_B6833CD8C787F200", columns={"specijalizacija_id"}), @ORM\Index(name="IDX_B6833CD8EDFE8F0E", columns={"ucionica_broj"})})
 * @ORM\Entity
 */
class LokacijaSpecijalizacija
{
    /**
     * @var string
     *
     * @ORM\Column(name="ucionica_broj", type="string", nullable=false)
     * @ORM\Id
     */
    private $ucionicaBroj;

    /**
     * @var string
     *
     * @ORM\Column(name="specijalizacija_id", type="string", nullable=false)
     * @ORM\Id
     */
    private $specijalizacijaId;

    public function getUcionicaBroj(): ?string
    {
        return $this->ucionicaBroj;
    }

    public function setUcionicaBroj(?string $ucionicaBroj): self
    {
        $this->ucionicaBroj = $ucionicaBroj;

        return $this;
    }

    public function getSpecijalizacijaId(): ?string
    {
        return $this->specijalizacijaId;
    }

    public function setSpecijalizacijaId(?string $specijalizacijaId): self
    {
        $this->specijalizacijaId = $specijalizacijaId;

        return $this;
    }

}
