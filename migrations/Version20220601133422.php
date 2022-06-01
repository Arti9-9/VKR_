<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601133422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auditorium_discipline (auditorium_id INT NOT NULL, discipline_id INT NOT NULL, PRIMARY KEY(auditorium_id, discipline_id))');
        $this->addSql('CREATE INDEX IDX_8481F7F73CF19AA0 ON auditorium_discipline (auditorium_id)');
        $this->addSql('CREATE INDEX IDX_8481F7F7A5522701 ON auditorium_discipline (discipline_id)');
        $this->addSql('ALTER TABLE auditorium_discipline ADD CONSTRAINT FK_8481F7F73CF19AA0 FOREIGN KEY (auditorium_id) REFERENCES auditorium (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE auditorium_discipline ADD CONSTRAINT FK_8481F7F7A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE auditorium_discipline');
    }
}
