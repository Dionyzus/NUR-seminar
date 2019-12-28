<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HardwareSoftware
 *
 * @ORM\Table(name="hardware_software")
 * @ORM\Entity
 */
class HardwareSoftware
{
    /**
     * @var string
     *
     * @ORM\Column(name="Broj_inventara", type="string", length=50, nullable=false)
     * @ORM\Id
     */
    private $brojInventara;

    /**
     * @var string
     *
     * @ORM\Column(name="Sifra_software", type="string", length=50, nullable=false)
     * @ORM\Id
     */
    private $sifraSoftware;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Datum_Aktivacije", type="date", nullable=true)
     */
    private $datumAktivacije;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Datum_isteka_licence", type="date", nullable=true)
     */
    private $datumIstekaLicence;

    public function getBrojInventara(): ?string
    {
        return $this->brojInventara;
    }

    public function setBrojInventara(?string $brojInventara): self
    {
        $this->brojInventara = $brojInventara;

        return $this;
    }

    public function getSifraSoftware(): ?string
    {
        return $this->sifraSoftware;
    }

    public function setSifraSoftware(?string $sifraSoftware): self
    {
        $this->sifraSoftware = $sifraSoftware;

        return $this;
    }

    public function getDatumAktivacije(): ?\DateTimeInterface
    {
        return $this->datumAktivacije;
    }

    public function setDatumAktivacije(?\DateTimeInterface $datumAktivacije): self
    {
        $this->datumAktivacije = $datumAktivacije;

        return $this;
    }

    public function getDatumIstekaLicence(): ?\DateTimeInterface
    {
        return $this->datumIstekaLicence;
    }

    public function setDatumIstekaLicence(?\DateTimeInterface $datumIstekaLicence): self
    {
        $this->datumIstekaLicence = $datumIstekaLicence;

        return $this;
    }


}
