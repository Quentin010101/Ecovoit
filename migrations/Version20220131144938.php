<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220131144938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE preference CHANGE pet_allowed pet_allowed TINYINT(1) NOT NULL, CHANGE smoking_allowed smoking_allowed TINYINT(1) NOT NULL, CHANGE music music int(11) NOT NULL, CHANGE talking talking int(11) NOT NULL, CHANGE theme theme tinyint(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE preference CHANGE pet_allowed pet_allowed TINYINT(1) NOT NULL, CHANGE smoking_allowed smoking_allowed TINYINT(1) NOT NULL, CHANGE music music int(11) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE talking talking int(11) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE theme theme tinyint(1) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
