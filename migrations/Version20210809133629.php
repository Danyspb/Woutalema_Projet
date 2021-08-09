<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210809133629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publication ADD service_id INT DEFAULT NULL, ADD produit_id INT DEFAULT NULL, ADD zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67799F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('CREATE INDEX IDX_AF3C6779ED5CA9E6 ON publication (service_id)');
        $this->addSql('CREATE INDEX IDX_AF3C6779F347EFB ON publication (produit_id)');
        $this->addSql('CREATE INDEX IDX_AF3C67799F2C3FAB ON publication (zone_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779ED5CA9E6');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779F347EFB');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67799F2C3FAB');
        $this->addSql('DROP INDEX IDX_AF3C6779ED5CA9E6 ON publication');
        $this->addSql('DROP INDEX IDX_AF3C6779F347EFB ON publication');
        $this->addSql('DROP INDEX IDX_AF3C67799F2C3FAB ON publication');
        $this->addSql('ALTER TABLE publication DROP service_id, DROP produit_id, DROP zone_id');
    }
}
