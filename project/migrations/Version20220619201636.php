<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220619201636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shop_cart DROP FOREIGN KEY FK_CA516ECC115C1274');
        $this->addSql('CREATE TABLE shop_item (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, price INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_DEE9C36512469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shop_item ADD CONSTRAINT FK_DEE9C36512469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('DROP TABLE shop_items');
        $this->addSql('ALTER TABLE shop_cart DROP FOREIGN KEY FK_CA516ECC115C1274');
        $this->addSql('ALTER TABLE shop_cart ADD CONSTRAINT FK_CA516ECC115C1274 FOREIGN KEY (shop_item_id) REFERENCES shop_item (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shop_cart DROP FOREIGN KEY FK_CA516ECC115C1274');
        $this->addSql('CREATE TABLE shop_items (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, price INT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_2608B31F12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE shop_items ADD CONSTRAINT FK_2608B31F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE shop_item');
        $this->addSql('ALTER TABLE shop_cart DROP FOREIGN KEY FK_CA516ECC115C1274');
        $this->addSql('ALTER TABLE shop_cart ADD CONSTRAINT FK_CA516ECC115C1274 FOREIGN KEY (shop_item_id) REFERENCES shop_items (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
