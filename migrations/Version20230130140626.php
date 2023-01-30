<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230130140626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add logo to employer.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employer ADD logo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE employer ADD CONSTRAINT FK_DE4CF066F98F144A FOREIGN KEY (logo_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_DE4CF066F98F144A ON employer (logo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employer DROP FOREIGN KEY FK_DE4CF066F98F144A');
        $this->addSql('DROP INDEX IDX_DE4CF066F98F144A ON employer');
        $this->addSql('ALTER TABLE employer DROP logo_id');
    }
}
