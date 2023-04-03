<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230403154740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre_album VARCHAR(255) NOT NULL, date DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE artiste (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE genre (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_genre VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE musique (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, artiste_id INTEGER DEFAULT NULL, album_id INTEGER DEFAULT NULL, titre_musique VARCHAR(255) NOT NULL, date DATETIME NOT NULL, CONSTRAINT FK_EE1D56BC21D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_EE1D56BC1137ABCF FOREIGN KEY (album_id) REFERENCES album (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_EE1D56BC21D25844 ON musique (artiste_id)');
        $this->addSql('CREATE INDEX IDX_EE1D56BC1137ABCF ON musique (album_id)');
        $this->addSql('CREATE TABLE musique_genre (musique_id INTEGER NOT NULL, genre_id INTEGER NOT NULL, PRIMARY KEY(musique_id, genre_id), CONSTRAINT FK_D23C44E925E254A1 FOREIGN KEY (musique_id) REFERENCES musique (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D23C44E94296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_D23C44E925E254A1 ON musique_genre (musique_id)');
        $this->addSql('CREATE INDEX IDX_D23C44E94296D31F ON musique_genre (genre_id)');
        $this->addSql('CREATE TABLE musique_playlist (musique_id INTEGER NOT NULL, playlist_id INTEGER NOT NULL, PRIMARY KEY(musique_id, playlist_id), CONSTRAINT FK_EE1C1A7925E254A1 FOREIGN KEY (musique_id) REFERENCES musique (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_EE1C1A796BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_EE1C1A7925E254A1 ON musique_playlist (musique_id)');
        $this->addSql('CREATE INDEX IDX_EE1C1A796BBD148 ON musique_playlist (playlist_id)');
        $this->addSql('CREATE TABLE playlist (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre_playlist VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE playlist_utilisateur (playlist_id INTEGER NOT NULL, utilisateur_id INTEGER NOT NULL, PRIMARY KEY(playlist_id, utilisateur_id), CONSTRAINT FK_38D1E59C6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_38D1E59CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_38D1E59C6BBD148 ON playlist_utilisateur (playlist_id)');
        $this->addSql('CREATE INDEX IDX_38D1E59CFB88E14F ON playlist_utilisateur (utilisateur_id)');
        $this->addSql('CREATE TABLE utilisateur (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE artiste');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE musique');
        $this->addSql('DROP TABLE musique_genre');
        $this->addSql('DROP TABLE musique_playlist');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE playlist_utilisateur');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
