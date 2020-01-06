<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200105194723 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE movies_has_categories');
        $this->addSql('ALTER TABLE movies CHANGE reviews reviews SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE movies ADD CONSTRAINT FK_C61EED30F675F31B FOREIGN KEY (author_id) REFERENCES authors (id)');
        $this->addSql('ALTER TABLE movies RENAME INDEX author_id TO IDX_C61EED30F675F31B');
        $this->addSql('ALTER TABLE authors CHANGE link link VARCHAR(255) DEFAULT NULL, CHANGE biography biograpĥy LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE movies_has_categories (movie_id INT NOT NULL, category_id INT NOT NULL, INDEX category_id (category_id), INDEX movie_id (movie_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE authors CHANGE link link VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE biograpĥy biography TEXT CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE movies DROP FOREIGN KEY FK_C61EED30F675F31B');
        $this->addSql('ALTER TABLE movies CHANGE reviews reviews TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE movies RENAME INDEX idx_c61eed30f675f31b TO author_id');
    }
}
