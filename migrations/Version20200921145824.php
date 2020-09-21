<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200921145824 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE executable CHANGE filename executablename VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE genre ADD classification_id INT DEFAULT NULL, DROP is_game');
        $this->addSql('ALTER TABLE genre ADD CONSTRAINT FK_835033F82A86559F FOREIGN KEY (classification_id) REFERENCES classification (id)');
        $this->addSql('CREATE INDEX IDX_835033F82A86559F ON genre (classification_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE executable CHANGE executablename filename VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE genre DROP FOREIGN KEY FK_835033F82A86559F');
        $this->addSql('DROP INDEX IDX_835033F82A86559F ON genre');
        $this->addSql('ALTER TABLE genre ADD is_game TINYINT(1) NOT NULL, DROP classification_id');
    }
}
