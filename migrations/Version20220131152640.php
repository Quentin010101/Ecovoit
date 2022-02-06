<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220131152640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, user_sender_id INT DEFAULT NULL, user_reciever_id INT DEFAULT NULL, message_report TINYINT(1) NOT NULL, message_sender_delete TINYINT(1) NOT NULL, message_reciever_delete TINYINT(1) NOT NULL, message_date DATE NOT NULL, message_content VARCHAR(255) NOT NULL, INDEX IDX_B6BD307FF6C43E79 (user_sender_id), INDEX IDX_B6BD307FF4475B18 (user_reciever_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF6C43E79 FOREIGN KEY (user_sender_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF4475B18 FOREIGN KEY (user_reciever_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE preference CHANGE pet_allowed pet_allowed TINYINT(1) NOT NULL, CHANGE smoking_allowed smoking_allowed TINYINT(1) NOT NULL, CHANGE music music VARCHAR(255) NOT NULL, CHANGE talking talking VARCHAR(255) NOT NULL, CHANGE theme theme VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE message');
        $this->addSql('ALTER TABLE preference CHANGE pet_allowed pet_allowed TINYINT(1) NOT NULL, CHANGE smoking_allowed smoking_allowed TINYINT(1) NOT NULL, CHANGE music music VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE talking talking VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE theme theme VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
