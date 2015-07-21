<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150630172809 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE besoin_dimension');
        $this->addSql('DROP TABLE besoin_stock');
        $this->addSql('DROP TABLE dimension_besoin');
        $this->addSql('ALTER TABLE besoin ADD stock_id INT NOT NULL, ADD dimension_id INT NOT NULL');
        $this->addSql('ALTER TABLE besoin ADD CONSTRAINT FK_86B4ED27DCD6110 FOREIGN KEY (stock_id) REFERENCES Stock (id)');
        $this->addSql('ALTER TABLE besoin ADD CONSTRAINT FK_86B4ED27277428AD FOREIGN KEY (dimension_id) REFERENCES Dimension (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_86B4ED27DCD6110 ON besoin (stock_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_86B4ED27277428AD ON besoin (dimension_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE besoin_dimension (besoin_id INT NOT NULL, dimension_id INT NOT NULL, INDEX IDX_4FBA627CFE6EED44 (besoin_id), INDEX IDX_4FBA627C277428AD (dimension_id), PRIMARY KEY(besoin_id, dimension_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE besoin_stock (besoin_id INT NOT NULL, stock_id INT NOT NULL, INDEX IDX_647AE91BFE6EED44 (besoin_id), INDEX IDX_647AE91BDCD6110 (stock_id), PRIMARY KEY(besoin_id, stock_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dimension_besoin (dimension_id INT NOT NULL, besoin_id INT NOT NULL, INDEX IDX_35D1C6A8277428AD (dimension_id), INDEX IDX_35D1C6A8FE6EED44 (besoin_id), PRIMARY KEY(dimension_id, besoin_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE besoin_dimension ADD CONSTRAINT FK_4FBA627C277428AD FOREIGN KEY (dimension_id) REFERENCES dimension (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE besoin_dimension ADD CONSTRAINT FK_4FBA627CFE6EED44 FOREIGN KEY (besoin_id) REFERENCES besoin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE besoin_stock ADD CONSTRAINT FK_647AE91BDCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE besoin_stock ADD CONSTRAINT FK_647AE91BFE6EED44 FOREIGN KEY (besoin_id) REFERENCES besoin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dimension_besoin ADD CONSTRAINT FK_35D1C6A8FE6EED44 FOREIGN KEY (besoin_id) REFERENCES besoin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dimension_besoin ADD CONSTRAINT FK_35D1C6A8277428AD FOREIGN KEY (dimension_id) REFERENCES dimension (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Besoin DROP FOREIGN KEY FK_86B4ED27DCD6110');
        $this->addSql('ALTER TABLE Besoin DROP FOREIGN KEY FK_86B4ED27277428AD');
        $this->addSql('DROP INDEX UNIQ_86B4ED27DCD6110 ON Besoin');
        $this->addSql('DROP INDEX UNIQ_86B4ED27277428AD ON Besoin');
        $this->addSql('ALTER TABLE Besoin DROP stock_id, DROP dimension_id');
    }
}
