<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hardware
 *
 * @ORM\Table(name="hardware", indexes={@ORM\Index(name="Organizacija", columns={"Organizacija"}), @ORM\Index(name="Broj_ucionice", columns={"Broj_ucionice"}), @ORM\Index(name="Vlasnistvo", columns={"Vlasnistvo"}), @ORM\Index(name="Kategorija", columns={"Kategorija"}), @ORM\Index(name="Ustanova", columns={"Ustanova"}), @ORM\Index(name="Namjena", columns={"Namjena"})})
 * @ORM\Entity
 */
class Hardware
{
    /**
     * @var string
     *
     * @ORM\Column(name="Broj_inventara", type="string", length=50, nullable=false)
     * @ORM\Id
     */
    private $brojInventara;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Naziv_hardware", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $nazivHardware;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Kontakt_osoba", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $kontaktOsoba;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Model_i_godina_proizvodnje", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $modelIGodinaProizvodnje;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Opis", type="string", length=100, nullable=true, options={"default"="NULL"})
     */
    private $opis;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Datum_nabave", type="date", nullable=true)
     */
    private $datumNabave;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Vijek_trajanja", type="string", length=50, nullable=true)
     */
    private $vijekTrajanja;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Datum_isteka_jamstva", type="date", nullable=true)
     */
    private $datumIstekaJamstva;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Vrijednost", type="decimal", precision=19, scale=4, nullable=true)
     */
    private $vrijednost;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Teunutna_vrijednost", type="decimal", precision=19, scale=4, nullable=true)
     */
    private $trenutnaVrijednost;

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
     * @var \Kategorija
     *
     * @ORM\ManyToOne(targetEntity="Kategorija")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Kategorija", referencedColumnName="Kategorija_ID")
     * })
     */
    private $kategorija;

    /**
     * @var \Namjena
     *
     * @ORM\ManyToOne(targetEntity="Namjena")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Namjena", referencedColumnName="Namjena_ID")
     * })
     */
    private $namjena;

    /**
     * @var \Lokacija
     *
     * @ORM\ManyToOne(targetEntity="Lokacija")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Broj_ucionice", referencedColumnName="Broj_ucionice")
     * })
     */
    private $brojUcionice;

    public function getBrojInventara(): ?string
    {
        return $this->brojInventara;
    }

    public function setBrojInventara(?string $brojInventara): self
    {
        $this->brojInventara = $brojInventara;

        return $this;
    }

    public function getNazivHardware(): ?string
    {
        return $this->nazivHardware;
    }

    public function setNazivHardware(?string $nazivHardware): self
    {
        $this->nazivHardware = $nazivHardware;

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

    public function getModelIGodinaProizvodnje(): ?string
    {
        return $this->modelIGodinaProizvodnje;
    }

    public function setModelIGodinaProizvodnje(?string $modelIGodinaProizvodnje): self
    {
        $this->modelIGodinaProizvodnje = $modelIGodinaProizvodnje;

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

    public function getDatumNabave(): ?\DateTimeInterface
    {
        return $this->datumNabave;
    }

    public function setDatumNabave(?\DateTimeInterface $datumNabave): self
    {
        $this->datumNabave = $datumNabave;

        return $this;
    }

    public function getVijekTrajanja(): ?string
    {
        return $this->vijekTrajanja;
    }

    public function setVijekTrajanja(?string $vijekTrajanja): self
    {
        $this->vijekTrajanja = $vijekTrajanja;

        return $this;
    }

    public function getDatumIstekaJamstva(): ?\DateTimeInterface
    {
        return $this->datumIstekaJamstva;
    }

    public function setDatumIstekaJamstva(?\DateTimeInterface $datumIstekaJamstva): self
    {
        $this->datumIstekaJamstva = $datumIstekaJamstva;

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

    public function getTrenutnaVrijednost(): ?string
    {
        return $this->trenutnaVrijednost;
    }

    public function setTrenutnaVrijednost(?string $trenutnaVrijednost): self
    {
        $this->trenutnaVrijednost = $trenutnaVrijednost;

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

    public function getKategorija(): ?Kategorija
    {
        return $this->kategorija;
    }

    public function setKategorija(?Kategorija $kategorija): self
    {
        $this->kategorija = $kategorija;

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

    public function getBrojUcionice(): ?Lokacija
    {
        return $this->brojUcionice;
    }

    public function setBrojUcionice(?Lokacija $brojUcionice): self
    {
        $this->brojUcionice = $brojUcionice;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getBrojInventara();
    }
}
