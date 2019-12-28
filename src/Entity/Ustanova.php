<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ustanova
 *
 * @ORM\Table(name="ustanova")
 * @ORM\Entity
 */
class Ustanova
{
    /**
     * @var int
     *
     * @ORM\Column(name="Ustanova_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ustanovaId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Naziv_ustanove", type="string", length=65, nullable=true, options={"default"="NULL"})
     */
    private $nazivUstanove;

    public function getUstanovaId(): ?int
    {
        return $this->ustanovaId;
    }

    public function getNazivUstanove(): ?string
    {
        return $this->nazivUstanove;
    }

    public function setNazivUstanove(?string $nazivUstanove): self
    {
        $this->nazivUstanove = $nazivUstanove;

        return $this;
    }


}
