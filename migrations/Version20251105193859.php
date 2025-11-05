<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251105193859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE products (uuid CHAR(36) NOT NULL, barcode VARCHAR(20) NOT NULL, store VARCHAR(50) NOT NULL, data JSON NOT NULL, createdAt DATETIME NOT NULL, PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE users (uuid CHAR(36) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, createdAt DATETIME NOT NULL, status VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('DROP TABLE product');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (uuid CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, barcode VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, store VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, data JSON NOT NULL, createdAt DATETIME NOT NULL, PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE users');
    }
}
