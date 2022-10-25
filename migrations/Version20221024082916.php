<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221024082916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permission ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE permission ADD CONSTRAINT FK_E04992AAED5CA9E6 FOREIGN KEY (service_id) REFERENCES structure (id)');
        $this->addSql('CREATE INDEX IDX_E04992AAED5CA9E6 ON permission (service_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permission DROP FOREIGN KEY FK_E04992AAED5CA9E6');
        $this->addSql('DROP INDEX IDX_E04992AAED5CA9E6 ON permission');
        $this->addSql('ALTER TABLE permission DROP service_id');
    }
}
