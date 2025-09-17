<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250917093440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movie (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, release_year INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE quote (id SERIAL NOT NULL, movie_id INT NOT NULL, quote VARCHAR(255) NOT NULL, character VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6B71CBF48F93B6FC ON quote (movie_id)');
        $this->addSql('ALTER TABLE quote ADD CONSTRAINT FK_6B71CBF48F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE quote DROP CONSTRAINT FK_6B71CBF48F93B6FC');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE quote');
    }
}
