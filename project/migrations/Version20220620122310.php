<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620122310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shop_cart ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE shop_cart ADD CONSTRAINT FK_CA516ECC115C1274 FOREIGN KEY (shop_item_id) REFERENCES shop_item (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shop_cart DROP FOREIGN KEY FK_CA516ECC115C1274');
        $this->addSql('ALTER TABLE shop_cart DROP user_id');
    }
}
