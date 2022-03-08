<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220308121803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE characters ADD gls_name VARCHAR(16) NOT NULL, ADD gls_caste VARCHAR(16) DEFAULT NULL, ADD gls_knowledge VARCHAR(16) DEFAULT NULL, ADD gls_intelligence INT DEFAULT NULL, ADD gls_life INT DEFAULT NULL, ADD gls_kind VARCHAR(16) NOT NULL, ADD gls_creation DATETIME NOT NULL, ADD gls_modification DATETIME NOT NULL, DROP name, DROP caste, DROP knowledge, DROP intelligence, DROP life, DROP kind, DROP creation, DROP modification, CHANGE surname gls_surname VARCHAR(64) NOT NULL, CHANGE image gls_image VARCHAR(128) DEFAULT NULL, CHANGE identifier gls_identifier VARCHAR(40) NOT NULL');
        $this->addSql('ALTER TABLE player CHANGE identifier gls_modification VARCHAR(40) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE characters ADD name VARCHAR(16) NOT NULL, ADD caste VARCHAR(16) DEFAULT NULL, ADD knowledge VARCHAR(16) DEFAULT NULL, ADD intelligence INT DEFAULT NULL, ADD life INT DEFAULT NULL, ADD kind VARCHAR(16) NOT NULL, ADD creation DATETIME NOT NULL, ADD modification DATETIME NOT NULL, DROP gls_name, DROP gls_caste, DROP gls_knowledge, DROP gls_intelligence, DROP gls_life, DROP gls_kind, DROP gls_creation, DROP gls_modification, CHANGE gls_surname surname VARCHAR(64) NOT NULL, CHANGE gls_image image VARCHAR(128) DEFAULT NULL, CHANGE gls_identifier identifier VARCHAR(40) NOT NULL');
        $this->addSql('ALTER TABLE player CHANGE gls_modification identifier VARCHAR(40) NOT NULL');
    }
}
