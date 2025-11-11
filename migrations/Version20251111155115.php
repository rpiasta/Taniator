<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251111155115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_history (uuid CHAR(36) NOT NULL, barcode VARCHAR(20) NOT NULL, createdAt DATETIME NOT NULL, user_id CHAR(36) NOT NULL, INDEX IDX_F6636BFBA76ED395 (user_id), PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE product_history ADD CONSTRAINT FK_F6636BFBA76ED395 FOREIGN KEY (user_id) REFERENCES users (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_history DROP FOREIGN KEY FK_F6636BFBA76ED395');
        $this->addSql('DROP TABLE product_history');
    }
}
