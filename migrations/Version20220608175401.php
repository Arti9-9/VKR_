<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608175401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE atributes_for_requirement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE atributes_for_requirement (id INT NOT NULL, requipment_id INT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, unit_measurements VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_908C82B9FF76A0DC ON atributes_for_requirement (requipment_id)');
        $this->addSql('ALTER TABLE atributes_for_requirement ADD CONSTRAINT FK_908C82B9FF76A0DC FOREIGN KEY (requipment_id) REFERENCES requirements (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE atributes_for_requirement_id_seq CASCADE');
        $this->addSql('DROP TABLE atributes_for_requirement');
    }
}
