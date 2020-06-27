<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200524102043 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_config (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_config_recipes (user_config_id INT NOT NULL, recipes_id INT NOT NULL, INDEX IDX_BDF0FF1C243B8B67 (user_config_id), INDEX IDX_BDF0FF1CFDF2B1FA (recipes_id), PRIMARY KEY(user_config_id, recipes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_config_recipes ADD CONSTRAINT FK_BDF0FF1C243B8B67 FOREIGN KEY (user_config_id) REFERENCES user_config (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_config_recipes ADD CONSTRAINT FK_BDF0FF1CFDF2B1FA FOREIGN KEY (recipes_id) REFERENCES recipes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipes ADD image_file_name VARCHAR(255) DEFAULT NULL, CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tags CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE first_name first_name VARCHAR(50) DEFAULT NULL, CHANGE last_name last_name VARCHAR(50) DEFAULT NULL, CHANGE email_hash email_hash VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE recipy_ingradients CHANGE recipe_id recipe_id INT DEFAULT NULL, CHANGE ingradient_id ingradient_id INT DEFAULT NULL, CHANGE measurment_unit_id measurment_unit_id INT DEFAULT NULL, CHANGE measurment measurment DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_config_recipes DROP FOREIGN KEY FK_BDF0FF1C243B8B67');
        $this->addSql('DROP TABLE user_config');
        $this->addSql('DROP TABLE user_config_recipes');
        $this->addSql('ALTER TABLE recipes DROP image_file_name, CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recipy_ingradients CHANGE ingradient_id ingradient_id INT DEFAULT NULL, CHANGE recipe_id recipe_id INT DEFAULT NULL, CHANGE measurment_unit_id measurment_unit_id INT DEFAULT NULL, CHANGE measurment measurment DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE tags CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE first_name first_name VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE last_name last_name VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE email_hash email_hash VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
