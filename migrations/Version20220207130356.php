<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220207130356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE characters ADD identifier VARCHAR(40) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE characters DROP identifier, CHANGE name name VARCHAR(16) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE surname surname VARCHAR(64) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE caste caste VARCHAR(16) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE knowledge knowledge VARCHAR(16) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(128) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE kind kind VARCHAR(16) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
