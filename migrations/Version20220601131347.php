<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601131347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auditorium DROP CONSTRAINT fk_41be81706c68ae55');
        $this->addSql('DROP INDEX idx_41be81706c68ae55');
        $this->addSql('ALTER TABLE auditorium DROP shedule_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE auditorium ADD shedule_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE auditorium ADD CONSTRAINT fk_41be81706c68ae55 FOREIGN KEY (shedule_id) REFERENCES shedule (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_41be81706c68ae55 ON auditorium (shedule_id)');
    }
}
