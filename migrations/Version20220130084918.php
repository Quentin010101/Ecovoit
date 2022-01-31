<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220130084918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE preference CHANGE avatar avatar VARCHAR(255) NOT NULL, CHANGE pet_allowed pet_allowed TINYINT(1) NOT NULL, CHANGE smoking_allowed smoking_allowed TINYINT(1) NOT NULL, CHANGE music music VARCHAR(255) NOT NULL, CHANGE talking talking VARCHAR(255) NOT NULL, CHANGE theme theme VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE road_trip ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE road_trip ADD CONSTRAINT FK_626235CAA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_626235CAA76ED395 ON road_trip (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE preference CHANGE avatar avatar VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE pet_allowed pet_allowed TINYINT(1) NOT NULL, CHANGE smoking_allowed smoking_allowed TINYINT(1) NOT NULL, CHANGE music music VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE talking talking VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE theme theme VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE road_trip DROP FOREIGN KEY FK_626235CAA76ED395');
        $this->addSql('DROP INDEX IDX_626235CAA76ED395 ON road_trip');
        $this->addSql('ALTER TABLE road_trip DROP user_id');
    }
}
