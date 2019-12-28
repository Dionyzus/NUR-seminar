<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Software
 *
 * @ORM\Table(name="software", indexes={@ORM\Index(name="Organizacija", columns={"Organizacija"}), @ORM\Index(name="Vlasnistvo", columns={"Vlasnistvo"}), @ORM\Index(name="Namjena", columns={"Namjena"}), @ORM\Index(name="Ustanova", columns={"Ustanova"})})
 * @ORM\Entity
 */
class Software
{
    /**
     * @var string
     *
     * @ORM\Column(name="Sifra_software", type="string", length=50, nullable=false)
     * @ORM\Id
     */
    private $sifraSoftware;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Naziv_Software", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $nazivSoftware;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Kontakt_osoba", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $kontaktOsoba;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Broj_licenci", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $brojLicenci;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Trajanje_licence", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $trajanjeLicence;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Datum_nabave", type="date", nullable=true)
     */
    private $datumNabave;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Vrijednost", type="decimal", precision=19, scale=4, nullable=true)
     */
    private $vrijednost;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Opis", type="string", length=100, nullable=true, options={"default"="NULL"})
     */
    private $opis;

    /**
     * @var \Vlasnik
     *
     * @ORM\ManyToOne(targetEntity="Vlasnik")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Vlasnistvo", referencedColumnName="Vlasnik_ID")
     * })
     */
    private $vlasnistvo;

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

    public function getSifraSoftware(): ?string
    {
        return $this->sifraSoftware;
    }

    public function setSifraSoftware(?string $sifraSoftware): self
    {
        $this->sifraSoftware = $sifraSoftware;

        return $this;
    }

    public function getNazivSoftware(): ?string
    {
        return $this->nazivSoftware;
    }

    public function setNazivSoftware(?string $nazivSoftware): self
    {
        $this->nazivSoftware = $nazivSoftware;

        return $this;
    }

    public function getKontaktOsoba(): ?string
    {
        return $this->kontaktOsoba;
    }

    public function setKontaktOsoba(?string $kontaktOsoba): self
    {
        $this->kontaktOsoba = $kontaktOsoba;

        return $this;
    }

    public function getBrojLicenci(): ?int
    {
        return $this->brojLicenci;
    }

    public function setBrojLicenci(?int $brojLicenci): self
    {
        $this->brojLicenci = $brojLicenci;

        return $this;
    }

    public function getTrajanjeLicence(): ?string
    {
        return $this->trajanjeLicence;
    }

    public function setTrajanjeLicence(?string $trajanjeLicence): self
    {
        $this->trajanjeLicence = $trajanjeLicence;

        return $this;
    }

    public function getDatumNabave(): ?\DateTimeInterface
    {
        return $this->datumNabave;
    }

    public function setDatumNabave(?\DateTimeInterface $datumNabave): self
    {
        $this->datumNabave = $datumNabave;

        return $this;
    }

    public function getVrijednost(): ?string
    {
        return $this->vrijednost;
    }

    public function setVrijednost(?string $vrijednost): self
    {
        $this->vrijednost = $vrijednost;

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

    public function getVlasnistvo(): ?Vlasnik
    {
        return $this->vlasnistvo;
    }

    public function setVlasnistvo(?Vlasnik $vlasnistvo): self
    {
        $this->vlasnistvo = $vlasnistvo;

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
        return (string) $this->getSifraSoftware();
    }
}
