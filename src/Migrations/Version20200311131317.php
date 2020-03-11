<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200311131317 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE rubricreader_corbeille (rubric_id INT NOT NULL, corbeille_id INT NOT NULL, INDEX IDX_46BEBE67A29EC0FC (rubric_id), INDEX IDX_46BEBE6757350F79 (corbeille_id), PRIMARY KEY(rubric_id, corbeille_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rubricwriter_corbeille (rubric_id INT NOT NULL, corbeille_id INT NOT NULL, INDEX IDX_64DA4BC8A29EC0FC (rubric_id), INDEX IDX_64DA4BC857350F79 (corbeille_id), PRIMARY KEY(rubric_id, corbeille_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rubricreader_corbeille ADD CONSTRAINT FK_46BEBE67A29EC0FC FOREIGN KEY (rubric_id) REFERENCES rubric (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rubricreader_corbeille ADD CONSTRAINT FK_46BEBE6757350F79 FOREIGN KEY (corbeille_id) REFERENCES corbeille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rubricwriter_corbeille ADD CONSTRAINT FK_64DA4BC8A29EC0FC FOREIGN KEY (rubric_id) REFERENCES rubric (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rubricwriter_corbeille ADD CONSTRAINT FK_64DA4BC857350F79 FOREIGN KEY (corbeille_id) REFERENCES corbeille (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE rubricreader_corbeille');
        $this->addSql('DROP TABLE rubricwriter_corbeille');
    }
}
