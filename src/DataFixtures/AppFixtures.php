<?php
namespace App\DataFixtures;

use App\Entity\HardwareSoftware;
use App\Entity\LokacijaSpecijalizacija;
use App\Entity\Software;
use App\Entity\Hardware;
use App\Entity\Lokacija;
use App\Entity\Organizacija;
use App\Entity\Kategorija;
use App\Entity\Specijalizacija;
use App\Entity\Namjena;
use App\Entity\Ustanova;
use App\Entity\Vlasnik;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $vlasnik = new Vlasnik();
        $vlasnik->setEmail("oss.vlasnik@oss.unist.hr");
        $vlasnik->setKontaktBroj("021/555-777");
        $vlasnik->setNazivVlasnika("OSS");
        $manager->persist($vlasnik);

        $vlasnik1 = new Vlasnik();
        $vlasnik1->setEmail("soss.vlasnik@oss.unist.hr");
        $vlasnik1->setKontaktBroj("021/555-333");
        $vlasnik1->setNazivVlasnika("SOSS");
        $manager->persist($vlasnik1);

        $ustanova = new Ustanova();
        $ustanova->setNazivUstanove("OSS");
        $manager->persist($ustanova);

        $ustanova1 = new Ustanova();
        $ustanova1->setNazivUstanove("SOSS");
        $manager->persist($ustanova1);

        $specijalizacija = new Specijalizacija();
        $specijalizacija->setNazivSpecijalizacije("Baze podataka");
        $specijalizacija->setSpecijalizacijaId("1");
        $specijalizacija->setOpisSpecijalizacije("Obrada i analiza podataka");
        $manager->persist($specijalizacija);

        $specijalizacija1 = new Specijalizacija();
        $specijalizacija1->setNazivSpecijalizacije("Programiranje");
        $specijalizacija1->setSpecijalizacijaId("2");
        $specijalizacija1->setOpisSpecijalizacije("Programski jezici");
        $manager->persist($specijalizacija1);

        $organizacija = new Organizacija();
        $organizacija->setNazivOrganizacije("Rektorat");
        $organizacija->setOpisOrganizacije("Glavni");
        $manager->persist($organizacija);

        $organizacija1 = new Organizacija();
        $organizacija1->setNazivOrganizacije("Sveuciliste");
        $organizacija1->setOpisOrganizacije("Sporedni");
        $manager->persist($organizacija1);

        $namjena = new Namjena();
        $namjena->setNazivNamjene("Istrazivanje");
        $namjena->setOpisNamjene("Za potrebe istrazivanja");
        $manager->persist($namjena);

        $namjena1 = new Namjena();
        $namjena1->setNazivNamjene("Laboratorij");
        $namjena1->setOpisNamjene("Za potrebe labova");
        $manager->persist($namjena1);

        $kategorija = new Kategorija();
        $kategorija->setNazivKategorije("Elektronicka oprema");
        $kategorija->setOpisKategorije("Za potrebe labova OEIE");
        $manager->persist($kategorija);

        $kategorija1 = new Kategorija();
        $kategorija1->setNazivKategorije("Računala");
        $kategorija1->setOpisKategorije("Za potrebe labova IT");
        $manager->persist($kategorija1);

        $lokacija = new Lokacija();
        $lokacija->setBrojUcionice("100");
        $lokacija->setOpis("Za održavanje predavanja");
        $lokacija->setNamjena($namjena);
        $lokacija->setOrganizacija($organizacija);
        $lokacija->setUstanova($ustanova);
        $manager->persist($lokacija);

        $lokacija1 = new Lokacija();
        $lokacija1->setBrojUcionice("101");
        $lokacija1->setOpis("Za održavanje labova");
        $lokacija1->setNamjena($namjena1);
        $lokacija1->setOrganizacija($organizacija1);
        $lokacija1->setUstanova($ustanova1);
        $manager->persist($lokacija1);

        $software = new Software();
        $software->setSifraSoftware("123");
        $software->setNazivSoftware("Windows 10");
        $software->setOpis("Instalacija operativnog sustava");
        $software->setUstanova($ustanova);
        $software->setVlasnistvo($vlasnik);
        $software->setKontaktOsoba("Ivica Ruzic");
        $software->setOrganizacija($organizacija);
        $software->setDatumNabave(\DateTime::createFromFormat('Y-m-d', "2018-09-09"));
        $software->setNamjena($namjena);
        $software->setBrojLicenci(50);
        $software->setTrajanjeLicence(365);
        $software->setVrijednost("1000");
        $manager->persist($software);

        $software1 = new Software();
        $software1->setSifraSoftware("123754");
        $software1->setNazivSoftware("Linux");
        $software1->setOpis("Instalacija operativnog sustava");
        $software1->setUstanova($ustanova1);
        $software1->setVlasnistvo($vlasnik1);
        $software1->setKontaktOsoba("Nikola Grgić");
        $software1->setOrganizacija($organizacija1);
        $software1->setDatumNabave(\DateTime::createFromFormat('Y-m-d', "2018-09-09"));
        $software1->setNamjena($namjena1);
        $software1->setBrojLicenci(50);
        $software1->setTrajanjeLicence(365);
        $software1->setVrijednost("0.50");
        $manager->persist($software1);

        $hardware = new Hardware();
        $hardware->setBrojInventara("55");
        $hardware->setNazivHardware("HDD");
        $hardware->setOpis("Tvrdi disk za pohranu podataka");
        $hardware->setUstanova($ustanova);
        $hardware->setVlasnistvo($vlasnik);
        $hardware->setKontaktOsoba("Ivica Ružić");
        $hardware->setOrganizacija($organizacija);
        $hardware->setDatumNabave(\DateTime::createFromFormat('Y-m-d', "2018-09-09"));
        $hardware->setNamjena($namjena);
        $hardware->setVrijednost("500");
        $hardware->setTrenutnaVrijednost("0");
        $hardware->setDatumIstekaJamstva(\DateTime::createFromFormat('Y-m-d', "2020-09-09"));
        $hardware->setBrojUcionice($lokacija);
        $hardware->setModelIGodinaProizvodnje("Toshiba,2014");
        $hardware->setKategorija($kategorija);
        $hardware->setVijekTrajanja("10");
        $manager->persist($hardware);

        $hardware1 = new Hardware();
        $hardware1->setBrojInventara("56");
        $hardware1->setNazivHardware("SSD");
        $hardware1->setOpis("Brzi disk za pohranu podataka");
        $hardware1->setUstanova($ustanova1);
        $hardware1->setVlasnistvo($vlasnik1);
        $hardware1->setKontaktOsoba("Ivica Ružić");
        $hardware1->setOrganizacija($organizacija1);
        $hardware1->setDatumNabave(\DateTime::createFromFormat('Y-m-d', "2018-09-09"));
        $hardware1->setNamjena($namjena1);
        $hardware1->setVrijednost("500");
        $hardware1->setTrenutnaVrijednost("350");
        $hardware1->setDatumIstekaJamstva(\DateTime::createFromFormat('Y-m-d', "2020-09-09"));
        $hardware1->setBrojUcionice($lokacija);
        $hardware1->setModelIGodinaProizvodnje("Samsung,2014");
        $hardware1->setKategorija($kategorija);
        $hardware1->setVijekTrajanja("5");
        $manager->persist($hardware1);

        $hardwareSoftware = new HardwareSoftware();
        $hardwareSoftware->setBrojInventara($hardware->getBrojInventara());
        $hardwareSoftware->setSifraSoftware($software->getSifraSoftware());
        $hardwareSoftware->setDatumAktivacije(\DateTime::createFromFormat('Y-m-d', "2019-09-09"));
        $hardwareSoftware->setDatumIstekaLicence(\DateTime::createFromFormat('Y-m-d', "2021-09-09"));
        $manager->persist($hardwareSoftware);

        $lokacijaSpecijalizacija = new LokacijaSpecijalizacija();
        $lokacijaSpecijalizacija->setSpecijalizacijaId($specijalizacija->getSpecijalizacijaId());
        $lokacijaSpecijalizacija->setUcionicaBroj($lokacija->getBrojUcionice());
        $manager->persist($lokacijaSpecijalizacija);

        $manager->flush();
    }
}