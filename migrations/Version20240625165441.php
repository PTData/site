<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240625165441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client_technology ADD technology_id INT NOT NULL');
        $this->addSql('ALTER TABLE client_technology ADD CONSTRAINT FK_64376F0C4235D463 FOREIGN KEY (technology_id) REFERENCES technology (id)');
        $this->addSql('CREATE INDEX IDX_64376F0C4235D463 ON client_technology (technology_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client_technology DROP FOREIGN KEY FK_64376F0C4235D463');
        $this->addSql('DROP INDEX IDX_64376F0C4235D463 ON client_technology');
        $this->addSql('ALTER TABLE client_technology DROP technology_id');
    }
}
