<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200311132738 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE avatar (id INT AUTO_INCREMENT NOT NULL, image LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE backpack (id INT AUTO_INCREMENT NOT NULL, under_rubric_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, enable TINYINT(1) NOT NULL, content LONGTEXT DEFAULT NULL, dir1 VARCHAR(100) DEFAULT NULL, dir2 VARCHAR(100) DEFAULT NULL, dir3 VARCHAR(100) DEFAULT NULL, dir4 VARCHAR(100) DEFAULT NULL, dir5 VARCHAR(100) DEFAULT NULL, archiving TINYINT(1) NOT NULL, update_at DATETIME NOT NULL, INDEX IDX_C3585697133F41C (under_rubric_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE corbeille (id INT AUTO_INCREMENT NOT NULL, organisme_id INT NOT NULL, name VARCHAR(40) NOT NULL, enable TINYINT(1) NOT NULL, content LONGTEXT DEFAULT NULL, show_read TINYINT(1) NOT NULL, show_write TINYINT(1) NOT NULL, INDEX IDX_1646B7075DDD38F5 (organisme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE corbeille_user (corbeille_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_8ABC48C457350F79 (corbeille_id), INDEX IDX_8ABC48C4A76ED395 (user_id), PRIMARY KEY(corbeille_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL, content JSON NOT NULL, INDEX IDX_27BA704BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organisme (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, ref VARCHAR(5) NOT NULL, content LONGTEXT DEFAULT NULL, enable TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organisme_user (organisme_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A53730645DDD38F5 (organisme_id), INDEX IDX_A5373064A76ED395 (user_id), PRIMARY KEY(organisme_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, enable TINYINT(1) NOT NULL, file_name VARCHAR(255) NOT NULL, update_at DATETIME DEFAULT NULL, file_extension VARCHAR(10) NOT NULL, content LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rubric (id INT AUTO_INCREMENT NOT NULL, thematic_id INT NOT NULL, picture_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, enable TINYINT(1) NOT NULL, content LONGTEXT DEFAULT NULL, show_order INT NOT NULL, show_all TINYINT(1) NOT NULL, INDEX IDX_60C4016C2395FCED (thematic_id), INDEX IDX_60C4016CEE45BDBF (picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rubricreader_corbeille (rubric_id INT NOT NULL, corbeille_id INT NOT NULL, INDEX IDX_46BEBE67A29EC0FC (rubric_id), INDEX IDX_46BEBE6757350F79 (corbeille_id), PRIMARY KEY(rubric_id, corbeille_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rubricwriter_corbeille (rubric_id INT NOT NULL, corbeille_id INT NOT NULL, INDEX IDX_64DA4BC8A29EC0FC (rubric_id), INDEX IDX_64DA4BC857350F79 (corbeille_id), PRIMARY KEY(rubric_id, corbeille_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thematic (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, enable TINYINT(1) NOT NULL, content LONGTEXT DEFAULT NULL, show_order INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE under_rubric (id INT AUTO_INCREMENT NOT NULL, rubric_id INT NOT NULL, picture_id INT DEFAULT NULL, under_thematic_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, enable TINYINT(1) NOT NULL, content LONGTEXT DEFAULT NULL, show_order INT NOT NULL, INDEX IDX_E1884228A29EC0FC (rubric_id), INDEX IDX_E1884228EE45BDBF (picture_id), INDEX IDX_E18842285C5F2819 (under_thematic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE under_thematic (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, enable TINYINT(1) NOT NULL, content LONGTEXT DEFAULT NULL, show_order INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, avatar_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(100) NOT NULL, email_validated TINYINT(1) NOT NULL, email_validated_token VARCHAR(255) DEFAULT NULL, forget_token VARCHAR(50) DEFAULT NULL, login_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, modified_at DATETIME DEFAULT NULL, enable TINYINT(1) NOT NULL, content LONGTEXT DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D64986383B10 (avatar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE backpack ADD CONSTRAINT FK_C3585697133F41C FOREIGN KEY (under_rubric_id) REFERENCES under_rubric (id)');
        $this->addSql('ALTER TABLE corbeille ADD CONSTRAINT FK_1646B7075DDD38F5 FOREIGN KEY (organisme_id) REFERENCES organisme (id)');
        $this->addSql('ALTER TABLE corbeille_user ADD CONSTRAINT FK_8ABC48C457350F79 FOREIGN KEY (corbeille_id) REFERENCES corbeille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE corbeille_user ADD CONSTRAINT FK_8ABC48C4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE organisme_user ADD CONSTRAINT FK_A53730645DDD38F5 FOREIGN KEY (organisme_id) REFERENCES organisme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organisme_user ADD CONSTRAINT FK_A5373064A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rubric ADD CONSTRAINT FK_60C4016C2395FCED FOREIGN KEY (thematic_id) REFERENCES thematic (id)');
        $this->addSql('ALTER TABLE rubric ADD CONSTRAINT FK_60C4016CEE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id)');
        $this->addSql('ALTER TABLE rubricreader_corbeille ADD CONSTRAINT FK_46BEBE67A29EC0FC FOREIGN KEY (rubric_id) REFERENCES rubric (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rubricreader_corbeille ADD CONSTRAINT FK_46BEBE6757350F79 FOREIGN KEY (corbeille_id) REFERENCES corbeille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rubricwriter_corbeille ADD CONSTRAINT FK_64DA4BC8A29EC0FC FOREIGN KEY (rubric_id) REFERENCES rubric (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rubricwriter_corbeille ADD CONSTRAINT FK_64DA4BC857350F79 FOREIGN KEY (corbeille_id) REFERENCES corbeille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE under_rubric ADD CONSTRAINT FK_E1884228A29EC0FC FOREIGN KEY (rubric_id) REFERENCES rubric (id)');
        $this->addSql('ALTER TABLE under_rubric ADD CONSTRAINT FK_E1884228EE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id)');
        $this->addSql('ALTER TABLE under_rubric ADD CONSTRAINT FK_E18842285C5F2819 FOREIGN KEY (under_thematic_id) REFERENCES under_thematic (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64986383B10 FOREIGN KEY (avatar_id) REFERENCES avatar (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64986383B10');
        $this->addSql('ALTER TABLE corbeille_user DROP FOREIGN KEY FK_8ABC48C457350F79');
        $this->addSql('ALTER TABLE rubricreader_corbeille DROP FOREIGN KEY FK_46BEBE6757350F79');
        $this->addSql('ALTER TABLE rubricwriter_corbeille DROP FOREIGN KEY FK_64DA4BC857350F79');
        $this->addSql('ALTER TABLE corbeille DROP FOREIGN KEY FK_1646B7075DDD38F5');
        $this->addSql('ALTER TABLE organisme_user DROP FOREIGN KEY FK_A53730645DDD38F5');
        $this->addSql('ALTER TABLE rubric DROP FOREIGN KEY FK_60C4016CEE45BDBF');
        $this->addSql('ALTER TABLE under_rubric DROP FOREIGN KEY FK_E1884228EE45BDBF');
        $this->addSql('ALTER TABLE rubricreader_corbeille DROP FOREIGN KEY FK_46BEBE67A29EC0FC');
        $this->addSql('ALTER TABLE rubricwriter_corbeille DROP FOREIGN KEY FK_64DA4BC8A29EC0FC');
        $this->addSql('ALTER TABLE under_rubric DROP FOREIGN KEY FK_E1884228A29EC0FC');
        $this->addSql('ALTER TABLE rubric DROP FOREIGN KEY FK_60C4016C2395FCED');
        $this->addSql('ALTER TABLE backpack DROP FOREIGN KEY FK_C3585697133F41C');
        $this->addSql('ALTER TABLE under_rubric DROP FOREIGN KEY FK_E18842285C5F2819');
        $this->addSql('ALTER TABLE corbeille_user DROP FOREIGN KEY FK_8ABC48C4A76ED395');
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704BA76ED395');
        $this->addSql('ALTER TABLE organisme_user DROP FOREIGN KEY FK_A5373064A76ED395');
        $this->addSql('DROP TABLE avatar');
        $this->addSql('DROP TABLE backpack');
        $this->addSql('DROP TABLE corbeille');
        $this->addSql('DROP TABLE corbeille_user');
        $this->addSql('DROP TABLE history');
        $this->addSql('DROP TABLE organisme');
        $this->addSql('DROP TABLE organisme_user');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE rubric');
        $this->addSql('DROP TABLE rubricreader_corbeille');
        $this->addSql('DROP TABLE rubricwriter_corbeille');
        $this->addSql('DROP TABLE thematic');
        $this->addSql('DROP TABLE under_rubric');
        $this->addSql('DROP TABLE under_thematic');
        $this->addSql('DROP TABLE user');
    }
}
