<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180509093524 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE directory (id INT AUTO_INCREMENT NOT NULL, parent_directory_id INT DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_467844DA8EB396CD (full_path), INDEX IDX_467844DA7CFA5BB1 (parent_directory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, parent_directory_id INT DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, INDEX IDX_C53D045F7CFA5BB1 (parent_directory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE directory ADD CONSTRAINT FK_467844DA7CFA5BB1 FOREIGN KEY (parent_directory_id) REFERENCES directory (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F7CFA5BB1 FOREIGN KEY (parent_directory_id) REFERENCES directory (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE directory DROP FOREIGN KEY FK_467844DA7CFA5BB1');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F7CFA5BB1');
        $this->addSql('DROP TABLE directory');
        $this->addSql('DROP TABLE image');
    }
}
