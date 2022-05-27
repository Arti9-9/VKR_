<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220527130837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE curriculum ADD direction_id INT NOT NULL');
        $this->addSql('ALTER TABLE curriculum ADD CONSTRAINT FK_7BE2A7C3AF73D997 FOREIGN KEY (direction_id) REFERENCES direction (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7BE2A7C3AF73D997 ON curriculum (direction_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE curriculum DROP CONSTRAINT FK_7BE2A7C3AF73D997');
        $this->addSql('DROP INDEX IDX_7BE2A7C3AF73D997');
        $this->addSql('ALTER TABLE curriculum DROP direction_id');
    }
}
