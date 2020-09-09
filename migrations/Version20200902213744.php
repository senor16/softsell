<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200902213744 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app (id INT AUTO_INCREMENT NOT NULL, genre_id INT NOT NULL, developer_id INT NOT NULL, title VARCHAR(255) NOT NULL, short_description VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price INT NOT NULL, cover VARCHAR(255) NOT NULL, classification VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C96E70CF4296D31F (genre_id), INDEX IDX_C96E70CF64DD9267 (developer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, app_id INT NOT NULL, author VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, INDEX IDX_9474526C7987212D (app_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developer (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, gender TINYINT(1) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developer_app (developer_id INT NOT NULL, app_id INT NOT NULL, INDEX IDX_7108313564DD9267 (developer_id), INDEX IDX_710831357987212D (app_id), PRIMARY KEY(developer_id, app_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE executable (id INT AUTO_INCREMENT NOT NULL, app_id INT DEFAULT NULL, filename VARCHAR(255) NOT NULL, platform VARCHAR(255) NOT NULL, size INT NOT NULL, INDEX IDX_D68EDA017987212D (app_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, fr VARCHAR(255) NOT NULL, en VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, tag VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE screenshot (id INT AUTO_INCREMENT NOT NULL, app_id INT DEFAULT NULL, filename VARCHAR(255) NOT NULL, INDEX IDX_58991E417987212D (app_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, gender TINYINT(1) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_app (user_id INT NOT NULL, app_id INT NOT NULL, INDEX IDX_22781144A76ED395 (user_id), INDEX IDX_227811447987212D (app_id), PRIMARY KEY(user_id, app_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app ADD CONSTRAINT FK_C96E70CF4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE app ADD CONSTRAINT FK_C96E70CF64DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C7987212D FOREIGN KEY (app_id) REFERENCES app (id)');
        $this->addSql('ALTER TABLE developer_app ADD CONSTRAINT FK_7108313564DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developer_app ADD CONSTRAINT FK_710831357987212D FOREIGN KEY (app_id) REFERENCES app (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE executable ADD CONSTRAINT FK_D68EDA017987212D FOREIGN KEY (app_id) REFERENCES app (id)');
        $this->addSql('ALTER TABLE screenshot ADD CONSTRAINT FK_58991E417987212D FOREIGN KEY (app_id) REFERENCES app (id)');
        $this->addSql('ALTER TABLE user_app ADD CONSTRAINT FK_22781144A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_app ADD CONSTRAINT FK_227811447987212D FOREIGN KEY (app_id) REFERENCES app (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C7987212D');
        $this->addSql('ALTER TABLE developer_app DROP FOREIGN KEY FK_710831357987212D');
        $this->addSql('ALTER TABLE executable DROP FOREIGN KEY FK_D68EDA017987212D');
        $this->addSql('ALTER TABLE screenshot DROP FOREIGN KEY FK_58991E417987212D');
        $this->addSql('ALTER TABLE user_app DROP FOREIGN KEY FK_227811447987212D');
        $this->addSql('ALTER TABLE app DROP FOREIGN KEY FK_C96E70CF64DD9267');
        $this->addSql('ALTER TABLE developer_app DROP FOREIGN KEY FK_7108313564DD9267');
        $this->addSql('ALTER TABLE app DROP FOREIGN KEY FK_C96E70CF4296D31F');
        $this->addSql('ALTER TABLE user_app DROP FOREIGN KEY FK_22781144A76ED395');
        $this->addSql('DROP TABLE app');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE developer');
        $this->addSql('DROP TABLE developer_app');
        $this->addSql('DROP TABLE executable');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE screenshot');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_app');
    }
}
