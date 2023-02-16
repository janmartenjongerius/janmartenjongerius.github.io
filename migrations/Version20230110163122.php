<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230110163122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create employment, link to employer.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employment (id INT AUTO_INCREMENT NOT NULL, employer_id INT NOT NULL, title VARCHAR(50) NOT NULL, start_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', description LONGTEXT NOT NULL, experience LONGTEXT NOT NULL, INDEX IDX_BF089C9841CD9E7A (employer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employment ADD CONSTRAINT FK_BF089C9841CD9E7A FOREIGN KEY (employer_id) REFERENCES employer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employment DROP FOREIGN KEY FK_BF089C9841CD9E7A');
        $this->addSql('DROP TABLE employment');
    }
}
