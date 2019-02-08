<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190208145708 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE gamer DROP FOREIGN KEY `FK_88241BA7E48FD905`');
        $this->addSql('ALTER TABLE game CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\'');
        $this->addSql('ALTER TABLE gamer CHANGE game_id game_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\'');
        $this->addSql('ALTER TABLE gamer ADD CONSTRAINT `FK_88241BA7E48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE gamer DROP FOREIGN KEY `FK_88241BA7E48FD905`');
        $this->addSql('ALTER TABLE game CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE gamer CHANGE game_id game_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gamer ADD CONSTRAINT `FK_88241BA7E48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`)');
    }
}
