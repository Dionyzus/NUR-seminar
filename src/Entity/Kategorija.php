<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Kategorija
 *
 * @ORM\Table(name="kategorija")
 * @ORM\Entity
 */
class Kategorija
{
    /**
     * @var int
     *
     * @ORM\Column(name="Kategorija_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $kategorijaId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Naziv_kategorije", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $nazivKategorije;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Opis_kategorije", type="string", length=100, nullable=true, options={"default"="NULL"})
     */
    private $opisKategorije;

    public function getKategorijaId(): ?int
    {
        return $this->kategorijaId;
    }

    public function getNazivKategorije(): ?string
    {
        return $this->nazivKategorije;
    }

    public function setNazivKategorije(?string $nazivKategorije): self
    {
        $this->nazivKategorije = $nazivKategorije;

        return $this;
    }

    public function getOpisKategorije(): ?string
    {
        return $this->opisKategorije;
    }

    public function setOpisKategorije(?string $opisKategorije): self
    {
        $this->opisKategorije = $opisKategorije;

        return $this;
    }


}
