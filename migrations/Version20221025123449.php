<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221025123449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EAA76ED395');
        $this->addSql('DROP INDEX IDX_6F0137EAA76ED395 ON structure');
        $this->addSql('ALTER TABLE structure DROP user_id');
        $this->addSql('ALTER TABLE user ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD password VARCHAR(255) NOT NULL, DROP first_name, DROP last_name, DROP created_at, DROP updated_at, CHANGE email email VARCHAR(180) NOT NULL, CHANGE role full_name VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6F0137EAA76ED395 ON structure (user_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(50) NOT NULL, ADD last_name VARCHAR(50) NOT NULL, ADD role VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, DROP full_name, DROP roles, DROP password, CHANGE email email VARCHAR(255) NOT NULL');
    }
}
