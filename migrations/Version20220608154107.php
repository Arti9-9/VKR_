<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608154107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE requirements_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE requirements (id INT NOT NULL, curriculum_id INT NOT NULL, discipline_id INT NOT NULL, name_equipment VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_70BEA1AA5AEA4428 ON requirements (curriculum_id)');
        $this->addSql('CREATE INDEX IDX_70BEA1AAA5522701 ON requirements (discipline_id)');
        $this->addSql('ALTER TABLE requirements ADD CONSTRAINT FK_70BEA1AA5AEA4428 FOREIGN KEY (curriculum_id) REFERENCES curriculum (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE requirements ADD CONSTRAINT FK_70BEA1AAA5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE requirements_id_seq CASCADE');
        $this->addSql('DROP TABLE requirements');
    }
}
