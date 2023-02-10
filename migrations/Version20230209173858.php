<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230209173858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create employment skill pivot.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employment_skill (id INT AUTO_INCREMENT NOT NULL, employment_id INT NOT NULL, skill_id INT NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_3A70C716466E61E3 (employment_id), INDEX IDX_3A70C7165585C142 (skill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employment_skill ADD CONSTRAINT FK_3A70C716466E61E3 FOREIGN KEY (employment_id) REFERENCES employment (id)');
        $this->addSql('ALTER TABLE employment_skill ADD CONSTRAINT FK_3A70C7165585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employment_skill DROP FOREIGN KEY FK_3A70C716466E61E3');
        $this->addSql('ALTER TABLE employment_skill DROP FOREIGN KEY FK_3A70C7165585C142');
        $this->addSql('DROP TABLE employment_skill');
    }
}
