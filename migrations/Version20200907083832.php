<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200907083832 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE comment ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE developer ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user ADD created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app DROP created_at');
        $this->addSql('ALTER TABLE comment DROP created_at');
        $this->addSql('ALTER TABLE developer DROP created_at');
        $this->addSql('ALTER TABLE user DROP created_at');
    }
}
