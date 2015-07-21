<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150708180030 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE besoin DROP INDEX UNIQ_86B4ED27DCD6110, ADD INDEX IDX_86B4ED27DCD6110 (stock_id)');
        $this->addSql('ALTER TABLE besoin DROP INDEX UNIQ_86B4ED27277428AD, ADD INDEX IDX_86B4ED27277428AD (dimension_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Besoin DROP INDEX IDX_86B4ED27DCD6110, ADD UNIQUE INDEX UNIQ_86B4ED27DCD6110 (stock_id)');
        $this->addSql('ALTER TABLE Besoin DROP INDEX IDX_86B4ED27277428AD, ADD UNIQUE INDEX UNIQ_86B4ED27277428AD (dimension_id)');
    }
}
