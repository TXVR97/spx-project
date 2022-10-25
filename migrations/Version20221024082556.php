<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221024082556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permission_structure DROP FOREIGN KEY FK_4DF61986FED90CCA');
        $this->addSql('ALTER TABLE permission_structure DROP FOREIGN KEY FK_4DF619862534008B');
        $this->addSql('DROP TABLE permission_structure');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE permission_structure (permission_id INT NOT NULL, structure_id INT NOT NULL, INDEX IDX_4DF61986FED90CCA (permission_id), INDEX IDX_4DF619862534008B (structure_id), PRIMARY KEY(permission_id, structure_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE permission_structure ADD CONSTRAINT FK_4DF61986FED90CCA FOREIGN KEY (permission_id) REFERENCES permission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE permission_structure ADD CONSTRAINT FK_4DF619862534008B FOREIGN KEY (structure_id) REFERENCES structure (id) ON DELETE CASCADE');
    }
}
