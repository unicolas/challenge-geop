<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240202000618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE player (id UUID NOT NULL, name VARCHAR(255) NOT NULL, ability INT NOT NULL, gender VARCHAR(255) NOT NULL, strength INT DEFAULT NULL, speed INT DEFAULT NULL, recovery_time INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN player.id IS \'(DC2Type:ulid)\'');
        $this->addSql('CREATE TABLE tournament_result (id UUID NOT NULL, winner_id UUID DEFAULT NULL, type VARCHAR(255) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_77C03F435DFCD4B8 ON tournament_result (winner_id)');
        $this->addSql('COMMENT ON COLUMN tournament_result.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN tournament_result.winner_id IS \'(DC2Type:ulid)\'');
        $this->addSql('ALTER TABLE tournament_result ADD CONSTRAINT FK_77C03F435DFCD4B8 FOREIGN KEY (winner_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tournament_result DROP CONSTRAINT FK_77C03F435DFCD4B8');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE tournament_result');
    }
}
