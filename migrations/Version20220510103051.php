<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220510103051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribute ADD equipment_id INT NOT NULL');
        $this->addSql('ALTER TABLE attribute ADD CONSTRAINT FK_FA7AEFFB517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_FA7AEFFB517FE9FE ON attribute (equipment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE attribute DROP CONSTRAINT FK_FA7AEFFB517FE9FE');
        $this->addSql('DROP INDEX IDX_FA7AEFFB517FE9FE');
        $this->addSql('ALTER TABLE attribute DROP equipment_id');
    }
}
