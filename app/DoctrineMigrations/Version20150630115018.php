<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150630115018 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Besoin (id INT AUTO_INCREMENT NOT NULL, nombre INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE besoin_stock (besoin_id INT NOT NULL, stock_id INT NOT NULL, INDEX IDX_647AE91BFE6EED44 (besoin_id), INDEX IDX_647AE91BDCD6110 (stock_id), PRIMARY KEY(besoin_id, stock_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE besoin_dimension (besoin_id INT NOT NULL, dimension_id INT NOT NULL, INDEX IDX_4FBA627CFE6EED44 (besoin_id), INDEX IDX_4FBA627C277428AD (dimension_id), PRIMARY KEY(besoin_id, dimension_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dimension_besoin (dimension_id INT NOT NULL, besoin_id INT NOT NULL, INDEX IDX_35D1C6A8277428AD (dimension_id), INDEX IDX_35D1C6A8FE6EED44 (besoin_id), PRIMARY KEY(dimension_id, besoin_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE besoin_stock ADD CONSTRAINT FK_647AE91BFE6EED44 FOREIGN KEY (besoin_id) REFERENCES Besoin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE besoin_stock ADD CONSTRAINT FK_647AE91BDCD6110 FOREIGN KEY (stock_id) REFERENCES Stock (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE besoin_dimension ADD CONSTRAINT FK_4FBA627CFE6EED44 FOREIGN KEY (besoin_id) REFERENCES Besoin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE besoin_dimension ADD CONSTRAINT FK_4FBA627C277428AD FOREIGN KEY (dimension_id) REFERENCES Dimension (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dimension_besoin ADD CONSTRAINT FK_35D1C6A8277428AD FOREIGN KEY (dimension_id) REFERENCES Dimension (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dimension_besoin ADD CONSTRAINT FK_35D1C6A8FE6EED44 FOREIGN KEY (besoin_id) REFERENCES Besoin (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE besoin_stock DROP FOREIGN KEY FK_647AE91BFE6EED44');
        $this->addSql('ALTER TABLE besoin_dimension DROP FOREIGN KEY FK_4FBA627CFE6EED44');
        $this->addSql('ALTER TABLE dimension_besoin DROP FOREIGN KEY FK_35D1C6A8FE6EED44');
        $this->addSql('DROP TABLE Besoin');
        $this->addSql('DROP TABLE besoin_stock');
        $this->addSql('DROP TABLE besoin_dimension');
        $this->addSql('DROP TABLE dimension_besoin');
    }
}
