<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200313134751 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE backpack_file (id INT AUTO_INCREMENT NOT NULL, backpack_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, update_at DATETIME DEFAULT NULL, file_extension VARCHAR(10) NOT NULL, nbr_view INT NOT NULL, title VARCHAR(50) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_110A7D4931009DBE (backpack_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE backpack_link (id INT AUTO_INCREMENT NOT NULL, backpack_id INT NOT NULL, title VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_AB39D2A831009DBE (backpack_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE backpack_file ADD CONSTRAINT FK_110A7D4931009DBE FOREIGN KEY (backpack_id) REFERENCES backpack (id)');
        $this->addSql('ALTER TABLE backpack_link ADD CONSTRAINT FK_AB39D2A831009DBE FOREIGN KEY (backpack_id) REFERENCES backpack (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE backpack_file');
        $this->addSql('DROP TABLE backpack_link');
    }
}
