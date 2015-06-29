<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150626174500 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Dimension (id INT AUTO_INCREMENT NOT NULL, longueur INT NOT NULL, largeur INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dimension_stock (dimension_id INT NOT NULL, stock_id INT NOT NULL, INDEX IDX_89A6D89C277428AD (dimension_id), INDEX IDX_89A6D89CDCD6110 (stock_id), PRIMARY KEY(dimension_id, stock_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Stock (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, prix INT NOT NULL, besoin INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_dimension (stock_id INT NOT NULL, dimension_id INT NOT NULL, INDEX IDX_52062774DCD6110 (stock_id), INDEX IDX_52062774277428AD (dimension_id), PRIMARY KEY(stock_id, dimension_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dimension_stock ADD CONSTRAINT FK_89A6D89C277428AD FOREIGN KEY (dimension_id) REFERENCES Dimension (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dimension_stock ADD CONSTRAINT FK_89A6D89CDCD6110 FOREIGN KEY (stock_id) REFERENCES Stock (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stock_dimension ADD CONSTRAINT FK_52062774DCD6110 FOREIGN KEY (stock_id) REFERENCES Stock (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stock_dimension ADD CONSTRAINT FK_52062774277428AD FOREIGN KEY (dimension_id) REFERENCES Dimension (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE dimension_stock DROP FOREIGN KEY FK_89A6D89C277428AD');
        $this->addSql('ALTER TABLE stock_dimension DROP FOREIGN KEY FK_52062774277428AD');
        $this->addSql('ALTER TABLE dimension_stock DROP FOREIGN KEY FK_89A6D89CDCD6110');
        $this->addSql('ALTER TABLE stock_dimension DROP FOREIGN KEY FK_52062774DCD6110');
        $this->addSql('DROP TABLE Dimension');
        $this->addSql('DROP TABLE dimension_stock');
        $this->addSql('DROP TABLE Stock');
        $this->addSql('DROP TABLE stock_dimension');
    }
}
