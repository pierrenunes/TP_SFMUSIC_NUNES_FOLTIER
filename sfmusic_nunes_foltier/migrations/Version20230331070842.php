<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230331070842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__musique AS SELECT id, artiste_id, nom, date_sortie FROM musique');
        $this->addSql('DROP TABLE musique');
        $this->addSql('CREATE TABLE musique (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, artiste_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL, date_sortie DATE NOT NULL, CONSTRAINT FK_EE1D56BC21D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO musique (id, artiste_id, nom, date_sortie) SELECT id, artiste_id, nom, date_sortie FROM __temp__musique');
        $this->addSql('DROP TABLE __temp__musique');
        $this->addSql('CREATE INDEX IDX_EE1D56BC21D25844 ON musique (artiste_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE musique ADD COLUMN genre VARCHAR(255) NOT NULL');
    }
}
