<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231120181844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_category DROP FOREIGN KEY FK_B1369DBA4987E587');
        $this->addSql('ALTER TABLE category_category DROP FOREIGN KEY FK_B1369DBA5062B508');
        $this->addSql('DROP TABLE category_category');
        $this->addSql('ALTER TABLE media_files CHANGE extension mime_type VARCHAR(10) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_category (category_source BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', category_target BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_B1369DBA5062B508 (category_source), INDEX IDX_B1369DBA4987E587 (category_target), PRIMARY KEY(category_source, category_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE category_category ADD CONSTRAINT FK_B1369DBA4987E587 FOREIGN KEY (category_target) REFERENCES categories (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_category ADD CONSTRAINT FK_B1369DBA5062B508 FOREIGN KEY (category_source) REFERENCES categories (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_files CHANGE mime_type extension VARCHAR(10) NOT NULL');
    }
}
