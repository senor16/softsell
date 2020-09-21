<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200918132007 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app ADD genre_id INT DEFAULT NULL, ADD classification_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE app ADD CONSTRAINT FK_C96E70CF4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE app ADD CONSTRAINT FK_C96E70CF2A86559F FOREIGN KEY (classification_id) REFERENCES classification (id)');
        $this->addSql('CREATE INDEX IDX_C96E70CF4296D31F ON app (genre_id)');
        $this->addSql('CREATE INDEX IDX_C96E70CF2A86559F ON app (classification_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app DROP FOREIGN KEY FK_C96E70CF4296D31F');
        $this->addSql('ALTER TABLE app DROP FOREIGN KEY FK_C96E70CF2A86559F');
        $this->addSql('DROP INDEX IDX_C96E70CF4296D31F ON app');
        $this->addSql('DROP INDEX IDX_C96E70CF2A86559F ON app');
        $this->addSql('ALTER TABLE app DROP genre_id, DROP classification_id');
    }
}