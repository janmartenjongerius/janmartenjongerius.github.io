<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230209102717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add unique constraints to employer name and skill name.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DE4CF0665E237E06 ON employer (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E3DE4775E237E06 ON skill (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_DE4CF0665E237E06 ON employer');
        $this->addSql('DROP INDEX UNIQ_5E3DE4775E237E06 ON skill');
    }
}
