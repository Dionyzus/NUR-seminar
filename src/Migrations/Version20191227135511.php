<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191227135511 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE hardware (Broj_inventara VARCHAR(50) NOT NULL, Naziv_hardware VARCHAR(50) DEFAULT \'NULL\', Kontakt_osoba VARCHAR(50) DEFAULT \'NULL\', Model_i_godina_proizvodnje VARCHAR(50) DEFAULT \'NULL\', Opis VARCHAR(100) DEFAULT \'NULL\', Datum_nabave DATE DEFAULT NULL, Vijek_trajanja VARCHAR(50) DEFAULT NULL, Datum_isteka_jamstva DATE DEFAULT NULL, Vrijednost NUMERIC(19, 4) DEFAULT NULL, Teunutna_vrijednost NUMERIC(19, 4) DEFAULT NULL, Vlasnistvo INT DEFAULT NULL, Ustanova INT DEFAULT NULL, Organizacija INT DEFAULT NULL, Kategorija INT DEFAULT NULL, Namjena INT DEFAULT NULL, Broj_ucionice VARCHAR(50) DEFAULT NULL, INDEX Organizacija (Organizacija), INDEX Broj_ucionice (Broj_ucionice), INDEX Vlasnistvo (Vlasnistvo), INDEX Kategorija (Kategorija), INDEX Ustanova (Ustanova), INDEX Namjena (Namjena), PRIMARY KEY(Broj_inventara)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hardware_software (Broj_inventara VARCHAR(50) NOT NULL, Sifra_software VARCHAR(50) NOT NULL, Datum_Aktivacije DATE DEFAULT NULL, Datum_isteka_licence DATE DEFAULT NULL, PRIMARY KEY(Broj_inventara, Sifra_software)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kategorija (Kategorija_ID INT AUTO_INCREMENT NOT NULL, Naziv_kategorije VARCHAR(50) DEFAULT \'NULL\', Opis_kategorije VARCHAR(100) DEFAULT \'NULL\', PRIMARY KEY(Kategorija_ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lokacija (Broj_ucionice VARCHAR(50) NOT NULL, Opis VARCHAR(100) DEFAULT \'NULL\', Ustanova INT DEFAULT NULL, Organizacija INT DEFAULT NULL, Namjena INT DEFAULT NULL, INDEX Namjena (Namjena), INDEX Ustanova (Ustanova), INDEX Organizacija (Organizacija), PRIMARY KEY(Broj_ucionice)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lokacija_specijalizacija (ucionica_broj VARCHAR(255) NOT NULL, specijalizacija_id VARCHAR(255) NOT NULL, INDEX IDX_B6833CD8C787F200 (specijalizacija_id), INDEX IDX_B6833CD8EDFE8F0E (ucionica_broj), PRIMARY KEY(ucionica_broj, specijalizacija_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE namjena (Namjena_ID INT AUTO_INCREMENT NOT NULL, Naziv_namjene VARCHAR(50) DEFAULT \'NULL\', Opis_namjene VARCHAR(100) DEFAULT \'NULL\', PRIMARY KEY(Namjena_ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organizacija (Organizacija_ID INT AUTO_INCREMENT NOT NULL, Naziv_organizacije VARCHAR(65) DEFAULT \'NULL\', Opis_organizacije VARCHAR(100) DEFAULT \'NULL\', PRIMARY KEY(Organizacija_ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE software (Sifra_software VARCHAR(50) NOT NULL, Naziv_Software VARCHAR(50) DEFAULT \'NULL\', Kontakt_osoba VARCHAR(50) DEFAULT \'NULL\', Broj_licenci INT DEFAULT NULL, Trajanje_licence VARCHAR(50) DEFAULT \'NULL\', Datum_nabave DATE DEFAULT NULL, Vrijednost NUMERIC(19, 4) DEFAULT NULL, Opis VARCHAR(100) DEFAULT \'NULL\', Vlasnistvo INT DEFAULT NULL, Ustanova INT DEFAULT NULL, Organizacija INT DEFAULT NULL, Namjena INT DEFAULT NULL, INDEX Organizacija (Organizacija), INDEX Vlasnistvo (Vlasnistvo), INDEX Namjena (Namjena), INDEX Ustanova (Ustanova), PRIMARY KEY(Sifra_software)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specijalizacija (Specijalizacija_id VARCHAR(50) NOT NULL, Naziv_specijalizacije VARCHAR(50) DEFAULT \'NULL\', Opis_specijalizacije VARCHAR(100) DEFAULT \'NULL\', PRIMARY KEY(Specijalizacija_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ustanova (Ustanova_ID INT AUTO_INCREMENT NOT NULL, Naziv_ustanove VARCHAR(65) DEFAULT \'NULL\', PRIMARY KEY(Ustanova_ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vlasnik (Vlasnik_ID INT AUTO_INCREMENT NOT NULL, Naziv_vlasnika VARCHAR(50) DEFAULT \'NULL\', Kontakt_broj VARCHAR(50) DEFAULT \'NULL\', Elektronska_posta VARCHAR(50) DEFAULT \'NULL\', PRIMARY KEY(Vlasnik_ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hardware ADD CONSTRAINT FK_FE99E9E04D0900B FOREIGN KEY (Vlasnistvo) REFERENCES vlasnik (Vlasnik_ID)');
        $this->addSql('ALTER TABLE hardware ADD CONSTRAINT FK_FE99E9E04A277AC4 FOREIGN KEY (Ustanova) REFERENCES ustanova (Ustanova_ID)');
        $this->addSql('ALTER TABLE hardware ADD CONSTRAINT FK_FE99E9E0F9D93E76 FOREIGN KEY (Organizacija) REFERENCES organizacija (Organizacija_ID)');
        $this->addSql('ALTER TABLE hardware ADD CONSTRAINT FK_FE99E9E0125868CB FOREIGN KEY (Kategorija) REFERENCES kategorija (Kategorija_ID)');
        $this->addSql('ALTER TABLE hardware ADD CONSTRAINT FK_FE99E9E0F01EB712 FOREIGN KEY (Namjena) REFERENCES namjena (Namjena_ID)');
        $this->addSql('ALTER TABLE hardware ADD CONSTRAINT FK_FE99E9E03756AF47 FOREIGN KEY (Broj_ucionice) REFERENCES lokacija (Broj_ucionice)');
        $this->addSql('ALTER TABLE lokacija ADD CONSTRAINT FK_92CB8D544A277AC4 FOREIGN KEY (Ustanova) REFERENCES ustanova (Ustanova_ID)');
        $this->addSql('ALTER TABLE lokacija ADD CONSTRAINT FK_92CB8D54F9D93E76 FOREIGN KEY (Organizacija) REFERENCES organizacija (Organizacija_ID)');
        $this->addSql('ALTER TABLE lokacija ADD CONSTRAINT FK_92CB8D54F01EB712 FOREIGN KEY (Namjena) REFERENCES namjena (Namjena_ID)');
        $this->addSql('ALTER TABLE software ADD CONSTRAINT FK_77D068CF4D0900B FOREIGN KEY (Vlasnistvo) REFERENCES vlasnik (Vlasnik_ID)');
        $this->addSql('ALTER TABLE software ADD CONSTRAINT FK_77D068CF4A277AC4 FOREIGN KEY (Ustanova) REFERENCES ustanova (Ustanova_ID)');
        $this->addSql('ALTER TABLE software ADD CONSTRAINT FK_77D068CFF9D93E76 FOREIGN KEY (Organizacija) REFERENCES organizacija (Organizacija_ID)');
        $this->addSql('ALTER TABLE software ADD CONSTRAINT FK_77D068CFF01EB712 FOREIGN KEY (Namjena) REFERENCES namjena (Namjena_ID)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hardware DROP FOREIGN KEY FK_FE99E9E0125868CB');
        $this->addSql('ALTER TABLE hardware DROP FOREIGN KEY FK_FE99E9E03756AF47');
        $this->addSql('ALTER TABLE hardware DROP FOREIGN KEY FK_FE99E9E0F01EB712');
        $this->addSql('ALTER TABLE lokacija DROP FOREIGN KEY FK_92CB8D54F01EB712');
        $this->addSql('ALTER TABLE software DROP FOREIGN KEY FK_77D068CFF01EB712');
        $this->addSql('ALTER TABLE hardware DROP FOREIGN KEY FK_FE99E9E0F9D93E76');
        $this->addSql('ALTER TABLE lokacija DROP FOREIGN KEY FK_92CB8D54F9D93E76');
        $this->addSql('ALTER TABLE software DROP FOREIGN KEY FK_77D068CFF9D93E76');
        $this->addSql('ALTER TABLE hardware DROP FOREIGN KEY FK_FE99E9E04A277AC4');
        $this->addSql('ALTER TABLE lokacija DROP FOREIGN KEY FK_92CB8D544A277AC4');
        $this->addSql('ALTER TABLE software DROP FOREIGN KEY FK_77D068CF4A277AC4');
        $this->addSql('ALTER TABLE hardware DROP FOREIGN KEY FK_FE99E9E04D0900B');
        $this->addSql('ALTER TABLE software DROP FOREIGN KEY FK_77D068CF4D0900B');
        $this->addSql('DROP TABLE hardware');
        $this->addSql('DROP TABLE hardware_software');
        $this->addSql('DROP TABLE kategorija');
        $this->addSql('DROP TABLE lokacija');
        $this->addSql('DROP TABLE lokacija_specijalizacija');
        $this->addSql('DROP TABLE namjena');
        $this->addSql('DROP TABLE organizacija');
        $this->addSql('DROP TABLE software');
        $this->addSql('DROP TABLE specijalizacija');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE ustanova');
        $this->addSql('DROP TABLE vlasnik');
    }
}
