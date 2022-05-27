<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220525112650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE direction ADD responsible_id INT NOT NULL');
        $this->addSql('ALTER TABLE direction ADD CONSTRAINT FK_3E4AD1B3602AD315 FOREIGN KEY (responsible_id) REFERENCES "worker" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3E4AD1B3602AD315 ON direction (responsible_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE direction DROP CONSTRAINT FK_3E4AD1B3602AD315');
        $this->addSql('DROP INDEX IDX_3E4AD1B3602AD315');
        $this->addSql('ALTER TABLE direction DROP responsible_id');
    }
}
