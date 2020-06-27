<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200523175843 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE recipes_tags (recipes_id INT NOT NULL, tags_id INT NOT NULL, INDEX IDX_54E4F56FFDF2B1FA (recipes_id), INDEX IDX_54E4F56F8D7B4FB4 (tags_id), PRIMARY KEY(recipes_id, tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipes_tags ADD CONSTRAINT FK_54E4F56FFDF2B1FA FOREIGN KEY (recipes_id) REFERENCES recipes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipes_tags ADD CONSTRAINT FK_54E4F56F8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipes CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tags CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE first_name first_name VARCHAR(50) DEFAULT NULL, CHANGE last_name last_name VARCHAR(50) DEFAULT NULL, CHANGE email_hash email_hash VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE recipy_ingradients CHANGE recipe_id recipe_id INT DEFAULT NULL, CHANGE ingradient_id ingradient_id INT DEFAULT NULL, CHANGE measurment_unit_id measurment_unit_id INT DEFAULT NULL, CHANGE measurment measurment DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE recipes_tags');
        $this->addSql('ALTER TABLE recipes CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recipy_ingradients CHANGE ingradient_id ingradient_id INT DEFAULT NULL, CHANGE recipe_id recipe_id INT DEFAULT NULL, CHANGE measurment_unit_id measurment_unit_id INT DEFAULT NULL, CHANGE measurment measurment DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE tags CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE first_name first_name VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE last_name last_name VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE email_hash email_hash VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
