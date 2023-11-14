<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231114143607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE brand ADD CONSTRAINT FK_1C52F9583DA5256D FOREIGN KEY (image_id) REFERENCES media_file (id)');
        $this->addSql('CREATE INDEX IDX_1C52F9583DA5256D ON brand (image_id)');
        $this->addSql('ALTER TABLE category ADD cover_image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1E5A0E336 FOREIGN KEY (cover_image_id) REFERENCES media_file (id)');
        $this->addSql('CREATE INDEX IDX_64C19C1E5A0E336 ON category (cover_image_id)');
        $this->addSql('ALTER TABLE partenary ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partenary ADD CONSTRAINT FK_1641F27D3DA5256D FOREIGN KEY (image_id) REFERENCES media_file (id)');
        $this->addSql('CREATE INDEX IDX_1641F27D3DA5256D ON partenary (image_id)');
        $this->addSql('ALTER TABLE type ADD cover_image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type ADD CONSTRAINT FK_8CDE5729E5A0E336 FOREIGN KEY (cover_image_id) REFERENCES media_file (id)');
        $this->addSql('CREATE INDEX IDX_8CDE5729E5A0E336 ON type (cover_image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand DROP FOREIGN KEY FK_1C52F9583DA5256D');
        $this->addSql('DROP INDEX IDX_1C52F9583DA5256D ON brand');
        $this->addSql('ALTER TABLE brand DROP image_id');
        $this->addSql('ALTER TABLE partenary DROP FOREIGN KEY FK_1641F27D3DA5256D');
        $this->addSql('DROP INDEX IDX_1641F27D3DA5256D ON partenary');
        $this->addSql('ALTER TABLE partenary DROP image_id');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1E5A0E336');
        $this->addSql('DROP INDEX IDX_64C19C1E5A0E336 ON category');
        $this->addSql('ALTER TABLE category DROP cover_image_id');
        $this->addSql('ALTER TABLE type DROP FOREIGN KEY FK_8CDE5729E5A0E336');
        $this->addSql('DROP INDEX IDX_8CDE5729E5A0E336 ON type');
        $this->addSql('ALTER TABLE type DROP cover_image_id');
    }
}
