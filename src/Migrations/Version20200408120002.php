<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200408120002 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE recipy_ingradients_ingradients (recipy_ingradients_id INT NOT NULL, ingradients_id INT NOT NULL, INDEX IDX_D5CCF74D39959271 (recipy_ingradients_id), INDEX IDX_D5CCF74DA07EDB4 (ingradients_id), PRIMARY KEY(recipy_ingradients_id, ingradients_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipy_ingradients_ingradients ADD CONSTRAINT FK_D5CCF74D39959271 FOREIGN KEY (recipy_ingradients_id) REFERENCES recipy_ingradients (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipy_ingradients_ingradients ADD CONSTRAINT FK_D5CCF74DA07EDB4 FOREIGN KEY (ingradients_id) REFERENCES ingradients (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipy_ingradients DROP FOREIGN KEY FK_45606419CED3B180');
        $this->addSql('DROP INDEX IDX_45606419CED3B180 ON recipy_ingradients');
        $this->addSql('ALTER TABLE recipy_ingradients DROP ingradient_id, CHANGE recipe_id recipe_id INT DEFAULT NULL, CHANGE measurment measurment DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE first_name first_name VARCHAR(50) DEFAULT NULL, CHANGE last_name last_name VARCHAR(50) DEFAULT NULL, CHANGE email_hash email_hash VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE recipy_ingradients_ingradients');
        $this->addSql('ALTER TABLE recipy_ingradients ADD ingradient_id INT DEFAULT NULL, CHANGE recipe_id recipe_id INT DEFAULT NULL, CHANGE measurment measurment DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE recipy_ingradients ADD CONSTRAINT FK_45606419CED3B180 FOREIGN KEY (ingradient_id) REFERENCES ingradients (id)');
        $this->addSql('CREATE INDEX IDX_45606419CED3B180 ON recipy_ingradients (ingradient_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE first_name first_name VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE last_name last_name VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE email_hash email_hash VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
