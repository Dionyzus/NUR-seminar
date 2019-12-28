<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Namjena
 *
 * @ORM\Table(name="namjena")
 * @ORM\Entity
 */
class Namjena
{
    /**
     * @var int
     *
     * @ORM\Column(name="Namjena_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $namjenaId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Naziv_namjene", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $nazivNamjene;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Opis_namjene", type="string", length=100, nullable=true, options={"default"="NULL"})
     */
    private $opisNamjene;

    public function getNamjenaId(): ?int
    {
        return $this->namjenaId;
    }

    public function getNazivNamjene(): ?string
    {
        return $this->nazivNamjene;
    }

    public function setNazivNamjene(?string $nazivNamjene): self
    {
        $this->nazivNamjene = $nazivNamjene;

        return $this;
    }

    public function getOpisNamjene(): ?string
    {
        return $this->opisNamjene;
    }

    public function setOpisNamjene(?string $opisNamjene): self
    {
        $this->opisNamjene = $opisNamjene;

        return $this;
    }


}
