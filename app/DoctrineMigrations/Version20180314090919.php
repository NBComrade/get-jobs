<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180314090919 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE featured_jobs (id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, company VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE search_settings (id INTEGER NOT NULL, domain VARCHAR(255) NOT NULL, pattern VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, company VARCHAR(255) NOT NULL, date VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F5120B70A7A91E0B ON search_settings (domain)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F5120B70A3BCFC8E ON search_settings (pattern)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE featured_jobs');
        $this->addSql('DROP TABLE search_settings');
    }
}
