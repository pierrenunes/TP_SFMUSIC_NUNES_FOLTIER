<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230331123739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, artiste_id INTEGER NOT NULL, nom VARCHAR(255) NOT NULL, pochette VARCHAR(255) NOT NULL, entry_id INTEGER NOT NULL, utilisateur VARCHAR(255) NOT NULL, date_sortie DATE NOT NULL, CONSTRAINT FK_39986E4321D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_39986E4321D25844 ON album (artiste_id)');
        $this->addSql('CREATE TABLE album_genre (album_id INTEGER NOT NULL, genre_id INTEGER NOT NULL, PRIMARY KEY(album_id, genre_id), CONSTRAINT FK_F5E879DE1137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F5E879DE4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F5E879DE1137ABCF ON album_genre (album_id)');
        $this->addSql('CREATE INDEX IDX_F5E879DE4296D31F ON album_genre (genre_id)');
        $this->addSql('CREATE TABLE artiste (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, age INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE genre (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE musique (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, artiste_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL, date_sortie DATE NOT NULL, CONSTRAINT FK_EE1D56BC21D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_EE1D56BC21D25844 ON musique (artiste_id)');
        $this->addSql('CREATE TABLE musique_genre (musique_id INTEGER NOT NULL, genre_id INTEGER NOT NULL, PRIMARY KEY(musique_id, genre_id), CONSTRAINT FK_D23C44E925E254A1 FOREIGN KEY (musique_id) REFERENCES musique (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D23C44E94296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_D23C44E925E254A1 ON musique_genre (musique_id)');
        $this->addSql('CREATE INDEX IDX_D23C44E94296D31F ON musique_genre (genre_id)');
        $this->addSql('CREATE TABLE playlist (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, date_creation DATE NOT NULL)');
        $this->addSql('CREATE TABLE playlist_musique (playlist_id INTEGER NOT NULL, musique_id INTEGER NOT NULL, PRIMARY KEY(playlist_id, musique_id), CONSTRAINT FK_512241A66BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_512241A625E254A1 FOREIGN KEY (musique_id) REFERENCES musique (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_512241A66BBD148 ON playlist_musique (playlist_id)');
        $this->addSql('CREATE INDEX IDX_512241A625E254A1 ON playlist_musique (musique_id)');
        $this->addSql('CREATE TABLE utilisateur (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, pswd VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE album_genre');
        $this->addSql('DROP TABLE artiste');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE musique');
        $this->addSql('DROP TABLE musique_genre');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE playlist_musique');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
