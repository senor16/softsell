<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200919115143 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app DROP cover_size');
        $this->addSql('ALTER TABLE executable ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE screenshot ADD updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app ADD cover_size INT NOT NULL');
        $this->addSql('ALTER TABLE executable DROP updated_at');
        $this->addSql('ALTER TABLE screenshot DROP updated_at');
    }
}
