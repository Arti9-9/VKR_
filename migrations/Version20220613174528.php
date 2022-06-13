<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220613174528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE pattern_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE pattern (id INT NOT NULL, address VARCHAR(500) NOT NULL, buildings TEXT NOT NULL, building_area DOUBLE PRECISION NOT NULL, property VARCHAR(500) NOT NULL, owner VARCHAR(500) NOT NULL, document TEXT NOT NULL, cadastral_number VARCHAR(255) NOT NULL, date_number VARCHAR(500) NOT NULL, requisites TEXT NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE pattern_id_seq CASCADE');
        $this->addSql('DROP TABLE pattern');
    }
}
