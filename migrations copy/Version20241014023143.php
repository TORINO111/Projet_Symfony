<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241014023143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dette ADD client_id INT NOT NULL, CHANGE montant_total montant_total INT NOT NULL, CHANGE montant_verse montant_verse INT NOT NULL, CHANGE montant_restant montant_restant INT NOT NULL');
        $this->addSql('ALTER TABLE dette ADD CONSTRAINT FK_831BC80819EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_831BC80819EB6921 ON dette (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dette DROP FOREIGN KEY FK_831BC80819EB6921');
        $this->addSql('DROP INDEX IDX_831BC80819EB6921 ON dette');
        $this->addSql('ALTER TABLE dette DROP client_id, CHANGE montant_total montant_total DOUBLE PRECISION NOT NULL, CHANGE montant_verse montant_verse DOUBLE PRECISION NOT NULL, CHANGE montant_restant montant_restant DOUBLE PRECISION NOT NULL');
    }
}
