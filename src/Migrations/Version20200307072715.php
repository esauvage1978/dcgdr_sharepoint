<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200307072715 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE backpack (id INT AUTO_INCREMENT NOT NULL, under_rubric_id INT NOT NULL, name VARCHAR(255) NOT NULL, enable TINYINT(1) NOT NULL, content LONGTEXT DEFAULT NULL, dir1 VARCHAR(50) DEFAULT NULL, dir2 VARCHAR(50) DEFAULT NULL, dir3 VARCHAR(50) DEFAULT NULL, dir4 VARCHAR(50) DEFAULT NULL, dir5 VARCHAR(50) DEFAULT NULL, INDEX IDX_C3585697133F41C (under_rubric_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE backpack ADD CONSTRAINT FK_C3585697133F41C FOREIGN KEY (under_rubric_id) REFERENCES under_rubric (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE backpack');
    }
}
