<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601141845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schedule ADD auditorium_id INT NOT NULL');
        $this->addSql('ALTER TABLE schedule ADD discipline_id INT NOT NULL');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB3CF19AA0 FOREIGN KEY (auditorium_id) REFERENCES auditorium (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FBA5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5A3811FB3CF19AA0 ON schedule (auditorium_id)');
        $this->addSql('CREATE INDEX IDX_5A3811FBA5522701 ON schedule (discipline_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE schedule DROP CONSTRAINT FK_5A3811FB3CF19AA0');
        $this->addSql('ALTER TABLE schedule DROP CONSTRAINT FK_5A3811FBA5522701');
        $this->addSql('DROP INDEX IDX_5A3811FB3CF19AA0');
        $this->addSql('DROP INDEX IDX_5A3811FBA5522701');
        $this->addSql('ALTER TABLE schedule DROP auditorium_id');
        $this->addSql('ALTER TABLE schedule DROP discipline_id');
    }
}
