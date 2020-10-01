<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201001030206 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app ADD CONSTRAINT FK_C96E70CF64DD9267 FOREIGN KEY (developer_id) REFERENCES user (id)');
        $this->addSql('DROP INDEX IDX_709AE2DD64DD9267 ON app_download');
        $this->addSql('ALTER TABLE app_download DROP developer_id');
        $this->addSql('ALTER TABLE user ADD role VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app DROP FOREIGN KEY FK_C96E70CF64DD9267');
        $this->addSql('ALTER TABLE app_download ADD developer_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_709AE2DD64DD9267 ON app_download (developer_id)');
        $this->addSql('ALTER TABLE user DROP role');
    }
}
