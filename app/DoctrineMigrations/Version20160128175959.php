<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160128175959 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Heuresup (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, chantier VARCHAR(255) NOT NULL, date DATE NOT NULL, nombre INT NOT NULL, INDEX IDX_C62B6719A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Panier (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, chantier VARCHAR(255) NOT NULL, date DATE NOT NULL, INDEX IDX_236008C4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Heuresup ADD CONSTRAINT FK_C62B6719A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE Panier ADD CONSTRAINT FK_236008C4A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE Heuresup');
        $this->addSql('DROP TABLE Panier');
    }
}
