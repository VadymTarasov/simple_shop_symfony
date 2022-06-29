<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220626094859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_cart (id INT AUTO_INCREMENT NOT NULL, shop_item_id INT DEFAULT NULL, session_id VARCHAR(255) NOT NULL, user_identifier VARCHAR(255) DEFAULT NULL, INDEX IDX_CA516ECC115C1274 (shop_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_item (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, price INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_DEE9C36512469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_order (id INT AUTO_INCREMENT NOT NULL, session_id VARCHAR(255) NOT NULL, status INT NOT NULL, user_name VARCHAR(255) DEFAULT NULL, user_email VARCHAR(255) NOT NULL, user_phone INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, user_phone VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shop_cart ADD CONSTRAINT FK_CA516ECC115C1274 FOREIGN KEY (shop_item_id) REFERENCES shop_item (id)');
        $this->addSql('ALTER TABLE shop_item ADD CONSTRAINT FK_DEE9C36512469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shop_item DROP FOREIGN KEY FK_DEE9C36512469DE2');
        $this->addSql('ALTER TABLE shop_cart DROP FOREIGN KEY FK_CA516ECC115C1274');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE shop_cart');
        $this->addSql('DROP TABLE shop_item');
        $this->addSql('DROP TABLE shop_order');
        $this->addSql('DROP TABLE user');
    }
}
