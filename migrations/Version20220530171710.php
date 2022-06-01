<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220530171710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE curriculum_discipline (curriculum_id INT NOT NULL, discipline_id INT NOT NULL, PRIMARY KEY(curriculum_id, discipline_id))');
        $this->addSql('CREATE INDEX IDX_80C061355AEA4428 ON curriculum_discipline (curriculum_id)');
        $this->addSql('CREATE INDEX IDX_80C06135A5522701 ON curriculum_discipline (discipline_id)');
        $this->addSql('ALTER TABLE curriculum_discipline ADD CONSTRAINT FK_80C061355AEA4428 FOREIGN KEY (curriculum_id) REFERENCES curriculum (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE curriculum_discipline ADD CONSTRAINT FK_80C06135A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE discipline DROP CONSTRAINT fk_75beee3f5aea4428');
        $this->addSql('DROP INDEX idx_75beee3f5aea4428');
        $this->addSql('ALTER TABLE discipline DROP curriculum_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE curriculum_discipline');
        $this->addSql('ALTER TABLE discipline ADD curriculum_id INT NOT NULL');
        $this->addSql('ALTER TABLE discipline ADD CONSTRAINT fk_75beee3f5aea4428 FOREIGN KEY (curriculum_id) REFERENCES curriculum (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_75beee3f5aea4428 ON discipline (curriculum_id)');
    }
}
