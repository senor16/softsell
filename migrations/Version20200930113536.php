<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200930113536 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_download ADD developer_id INT DEFAULT NULL, ADD platform VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE app_download ADD CONSTRAINT FK_709AE2DD64DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id)');
        $this->addSql('CREATE INDEX IDX_709AE2DD64DD9267 ON app_download (developer_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_download DROP FOREIGN KEY FK_709AE2DD64DD9267');
        $this->addSql('DROP INDEX IDX_709AE2DD64DD9267 ON app_download');
        $this->addSql('ALTER TABLE app_download DROP developer_id, DROP platform');
    }
}
