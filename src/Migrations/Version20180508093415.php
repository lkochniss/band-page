<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180508093415 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, type VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_item (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, menu_id INT DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, position INT NOT NULL, UNIQUE INDEX UNIQ_D754D550C4663E4 (page_id), INDEX IDX_D754D550CCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_item ADD CONSTRAINT FK_D754D550C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE menu_item ADD CONSTRAINT FK_D754D550CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE menu_item DROP FOREIGN KEY FK_D754D550CCD7E912');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_item');
    }
}
