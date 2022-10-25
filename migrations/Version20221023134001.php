<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221023134001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE permission_structure (permission_id INT NOT NULL, structure_id INT NOT NULL, INDEX IDX_4DF61986FED90CCA (permission_id), INDEX IDX_4DF619862534008B (structure_id), PRIMARY KEY(permission_id, structure_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE permission_structure ADD CONSTRAINT FK_4DF61986FED90CCA FOREIGN KEY (permission_id) REFERENCES permission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE permission_structure ADD CONSTRAINT FK_4DF619862534008B FOREIGN KEY (structure_id) REFERENCES structure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE structure ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6F0137EAA76ED395 ON structure (user_id)');
        $this->addSql('ALTER TABLE user ADD structure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6492534008B ON user (structure_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permission_structure DROP FOREIGN KEY FK_4DF61986FED90CCA');
        $this->addSql('ALTER TABLE permission_structure DROP FOREIGN KEY FK_4DF619862534008B');
        $this->addSql('DROP TABLE permission_structure');
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EAA76ED395');
        $this->addSql('DROP INDEX IDX_6F0137EAA76ED395 ON structure');
        $this->addSql('ALTER TABLE structure DROP user_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6492534008B');
        $this->addSql('DROP INDEX IDX_8D93D6492534008B ON user');
        $this->addSql('ALTER TABLE user DROP structure_id');
    }
}
