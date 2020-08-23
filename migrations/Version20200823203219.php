<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200823203219 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE analytic (id INT AUTO_INCREMENT NOT NULL, windows INT NOT NULL, linux INT NOT NULL, mac INT NOT NULL, android INT NOT NULL, views INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, genre_id INT NOT NULL, analytics_id INT NOT NULL, file_id INT NOT NULL, title VARCHAR(255) NOT NULL, short_description VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, is_game TINYINT(1) NOT NULL, price INT DEFAULT NULL, cover VARCHAR(255) NOT NULL, added_at DATETIME NOT NULL, INDEX IDX_C96E70CFA76ED395 (user_id), UNIQUE INDEX UNIQ_C96E70CF4296D31F (genre_id), UNIQUE INDEX UNIQ_C96E70CFF4297814 (analytics_id), UNIQUE INDEX UNIQ_C96E70CF93CB796C (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, app_id INT NOT NULL, author VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, INDEX IDX_9474526C7987212D (app_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, windows INT NOT NULL, linux INT NOT NULL, mac INT NOT NULL, android INT NOT NULL, windows_file VARCHAR(255) NOT NULL, linux_file VARCHAR(255) NOT NULL, mac_file VARCHAR(255) NOT NULL, android_file VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, tag VARCHAR(255) NOT NULL, fr VARCHAR(255) NOT NULL, en VARCHAR(255) NOT NULL, is_game TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE screenshot (id INT AUTO_INCREMENT NOT NULL, app_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, INDEX IDX_58991E417987212D (app_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, gender TINYINT(1) NOT NULL, is_developper TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app ADD CONSTRAINT FK_C96E70CFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE app ADD CONSTRAINT FK_C96E70CF4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE app ADD CONSTRAINT FK_C96E70CFF4297814 FOREIGN KEY (analytics_id) REFERENCES analytic (id)');
        $this->addSql('ALTER TABLE app ADD CONSTRAINT FK_C96E70CF93CB796C FOREIGN KEY (file_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C7987212D FOREIGN KEY (app_id) REFERENCES app (id)');
        $this->addSql('ALTER TABLE screenshot ADD CONSTRAINT FK_58991E417987212D FOREIGN KEY (app_id) REFERENCES app (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app DROP FOREIGN KEY FK_C96E70CFF4297814');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C7987212D');
        $this->addSql('ALTER TABLE screenshot DROP FOREIGN KEY FK_58991E417987212D');
        $this->addSql('ALTER TABLE app DROP FOREIGN KEY FK_C96E70CF93CB796C');
        $this->addSql('ALTER TABLE app DROP FOREIGN KEY FK_C96E70CF4296D31F');
        $this->addSql('ALTER TABLE app DROP FOREIGN KEY FK_C96E70CFA76ED395');
        $this->addSql('DROP TABLE analytic');
        $this->addSql('DROP TABLE app');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE screenshot');
        $this->addSql('DROP TABLE user');
    }
}
