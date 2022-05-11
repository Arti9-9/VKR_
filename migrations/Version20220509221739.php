<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220509221739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE type_equipment_id_seq CASCADE');
        $this->addSql('DROP TABLE type_equipment');
        $this->addSql('ALTER TABLE equipment ADD auditorium_id INT NOT NULL');
        $this->addSql('ALTER TABLE equipment ADD category VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D5833CF19AA0 FOREIGN KEY (auditorium_id) REFERENCES auditorium (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D338D5833CF19AA0 ON equipment (auditorium_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE type_equipment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE type_equipment (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE equipment DROP CONSTRAINT FK_D338D5833CF19AA0');
        $this->addSql('DROP INDEX IDX_D338D5833CF19AA0');
        $this->addSql('ALTER TABLE equipment DROP auditorium_id');
        $this->addSql('ALTER TABLE equipment DROP category');
    }
}
