<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200522172907 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, profil_id INT NOT NULL, content LONGTEXT DEFAULT NULL, rating INT NOT NULL, created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_9474526CF675F31B (author_id), INDEX IDX_9474526C275ED078 (profil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_A412FA92A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE information (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, sujet VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_29791883A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, description LONGTEXT NOT NULL, city VARCHAR(255) NOT NULL, zip INT NOT NULL, pays VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_F65593E5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE streaming (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, link VARCHAR(255) NOT NULL, INDEX IDX_26431861A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE localisation (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, adresse VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, code_postal INT NOT NULL, UNIQUE INDEX UNIQ_BFD3CE8FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, link VARCHAR(255) NOT NULL, support VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_7CC7DA2CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discuter (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, sujet VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_D511153CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proposition (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, city VARCHAR(255) NOT NULL, zip INT NOT NULL, pays VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_C7CDC353A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, update_at DATETIME DEFAULT NULL, description LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, matiere VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_404021BFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, zip INT NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_D19FA60A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gaming (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_A683AD1FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE initiative (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, link VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_E115DEFEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diy (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, zip INT NOT NULL, description LONGTEXT NOT NULL, link VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_2D79A398A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C275ED078 FOREIGN KEY (profil_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE information ADD CONSTRAINT FK_29791883A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE streaming ADD CONSTRAINT FK_26431861A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE localisation ADD CONSTRAINT FK_BFD3CE8FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE discuter ADD CONSTRAINT FK_D511153CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE proposition ADD CONSTRAINT FK_C7CDC353A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE entreprise ADD CONSTRAINT FK_D19FA60A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE gaming ADD CONSTRAINT FK_A683AD1FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE initiative ADD CONSTRAINT FK_E115DEFEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE diy ADD CONSTRAINT FK_2D79A398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C275ED078');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA92A76ED395');
        $this->addSql('ALTER TABLE information DROP FOREIGN KEY FK_29791883A76ED395');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5A76ED395');
        $this->addSql('ALTER TABLE streaming DROP FOREIGN KEY FK_26431861A76ED395');
        $this->addSql('ALTER TABLE localisation DROP FOREIGN KEY FK_BFD3CE8FA76ED395');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CA76ED395');
        $this->addSql('ALTER TABLE discuter DROP FOREIGN KEY FK_D511153CA76ED395');
        $this->addSql('ALTER TABLE proposition DROP FOREIGN KEY FK_C7CDC353A76ED395');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BFA76ED395');
        $this->addSql('ALTER TABLE entreprise DROP FOREIGN KEY FK_D19FA60A76ED395');
        $this->addSql('ALTER TABLE gaming DROP FOREIGN KEY FK_A683AD1FA76ED395');
        $this->addSql('ALTER TABLE initiative DROP FOREIGN KEY FK_E115DEFEA76ED395');
        $this->addSql('ALTER TABLE diy DROP FOREIGN KEY FK_2D79A398A76ED395');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE information');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE streaming');
        $this->addSql('DROP TABLE localisation');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE discuter');
        $this->addSql('DROP TABLE proposition');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE gaming');
        $this->addSql('DROP TABLE initiative');
        $this->addSql('DROP TABLE diy');
    }
}
