<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220122183941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transfer (id SERIAL NOT NULL, payer_id INT NOT NULL, payee_id INT NOT NULL, value NUMERIC(20, 2) NOT NULL, status VARCHAR(25) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4034A3C0C17AD9A9 ON transfer (payer_id)');
        $this->addSql('CREATE INDEX IDX_4034A3C0CB4B68F ON transfer (payee_id)');
        $this->addSql('ALTER TABLE transfer ADD CONSTRAINT FK_4034A3C0C17AD9A9 FOREIGN KEY (payer_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transfer ADD CONSTRAINT FK_4034A3C0CB4B68F FOREIGN KEY (payee_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE transfer');
    }
}
