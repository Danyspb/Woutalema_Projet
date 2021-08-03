<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210803202009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, lieu_boutique VARCHAR(255) NOT NULL, nom_boutique VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discussion (id INT AUTO_INCREMENT NOT NULL, text VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE domaine (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livreur (id INT AUTO_INCREMENT NOT NULL, numero_permis VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moto (id INT AUTO_INCREMENT NOT NULL, livreur_id INT DEFAULT NULL, marque VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, matricule VARCHAR(255) NOT NULL, assurance VARCHAR(255) NOT NULL, num_carte_grise VARCHAR(255) NOT NULL, INDEX IDX_3DDDBCE4F8646701 (livreur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestataire (id INT AUTO_INCREMENT NOT NULL, niveau_etude VARCHAR(255) NOT NULL, diplome VARCHAR(255) DEFAULT NULL, lieu_atelier VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, type_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, description TINYTEXT NOT NULL, prix DOUBLE PRECISION NOT NULL, lieu VARCHAR(255) NOT NULL, contact INT NOT NULL, INDEX IDX_29A5EC2719EB6921 (client_id), INDEX IDX_29A5EC27C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publication (id INT AUTO_INCREMENT NOT NULL, etat_id INT DEFAULT NULL, discussion_id INT DEFAULT NULL, date_publication DATE NOT NULL, INDEX IDX_AF3C6779D5E86FF (etat_id), INDEX IDX_AF3C67791ADED311 (discussion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, domaine_id INT DEFAULT NULL, prestataire_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, tarifs DOUBLE PRECISION NOT NULL, realisation VARCHAR(255) NOT NULL, lieu VARCHAR(255) NOT NULL, contact INT NOT NULL, INDEX IDX_E19D9AD24272FC9F (domaine_id), INDEX IDX_E19D9AD2BE3DB2B7 (prestataire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE types (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, prestataire_id INT DEFAULT NULL, livreur_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, telephone INT NOT NULL, email VARCHAR(255) NOT NULL, numero_cni INT NOT NULL, adresse VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D64919EB6921 (client_id), UNIQUE INDEX UNIQ_8D93D649BE3DB2B7 (prestataire_id), UNIQUE INDEX UNIQ_8D93D649F8646701 (livreur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone (id INT AUTO_INCREMENT NOT NULL, livreur_id INT DEFAULT NULL, region VARCHAR(255) NOT NULL, commune VARCHAR(255) NOT NULL, horraire_debut TIME NOT NULL, horraire_fin TIME NOT NULL, contact INT NOT NULL, INDEX IDX_A0EBC007F8646701 (livreur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE moto ADD CONSTRAINT FK_3DDDBCE4F8646701 FOREIGN KEY (livreur_id) REFERENCES livreur (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2719EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27C54C8C93 FOREIGN KEY (type_id) REFERENCES types (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67791ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD24272FC9F FOREIGN KEY (domaine_id) REFERENCES domaine (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2BE3DB2B7 FOREIGN KEY (prestataire_id) REFERENCES prestataire (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BE3DB2B7 FOREIGN KEY (prestataire_id) REFERENCES prestataire (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F8646701 FOREIGN KEY (livreur_id) REFERENCES livreur (id)');
        $this->addSql('ALTER TABLE zone ADD CONSTRAINT FK_A0EBC007F8646701 FOREIGN KEY (livreur_id) REFERENCES livreur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC2719EB6921');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64919EB6921');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67791ADED311');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD24272FC9F');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779D5E86FF');
        $this->addSql('ALTER TABLE moto DROP FOREIGN KEY FK_3DDDBCE4F8646701');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F8646701');
        $this->addSql('ALTER TABLE zone DROP FOREIGN KEY FK_A0EBC007F8646701');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2BE3DB2B7');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BE3DB2B7');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27C54C8C93');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('DROP TABLE domaine');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE livreur');
        $this->addSql('DROP TABLE moto');
        $this->addSql('DROP TABLE prestataire');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE publication');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE types');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE zone');
    }
}
