<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220508225601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE attribute_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE auditorium_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE curriculum_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE direction_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE discipline_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE equipment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_equipment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE attribute (id INT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, unit_measurements VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE auditorium (id INT NOT NULL, count_seats INT DEFAULT NULL, number VARCHAR(50) NOT NULL, square DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE curriculum (id INT NOT NULL, name VARCHAR(500) NOT NULL, educational_program VARCHAR(500) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE direction (id INT NOT NULL, name VARCHAR(500) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE discipline (id INT NOT NULL, name VARCHAR(500) NOT NULL, semester INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE equipment (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE type_equipment (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, login VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649AA08CB10 ON "user" (login)');
    }

    public function down(Schema $schema): void
    {

        $this->addSql('DROP SEQUENCE attribute_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE auditorium_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE curriculum_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE direction_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE discipline_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE equipment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_equipment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE attribute');
        $this->addSql('DROP TABLE auditorium');
        $this->addSql('DROP TABLE curriculum');
        $this->addSql('DROP TABLE direction');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE type_equipment');
        $this->addSql('DROP TABLE "user"');
    }
}
