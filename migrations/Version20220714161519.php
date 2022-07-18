<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220714161519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ligne_taille (id INT AUTO_INCREMENT NOT NULL, ligne_de_commande_id INT NOT NULL, taille_boisson_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_508A177ECA2A78B2 (ligne_de_commande_id), INDEX IDX_508A177E8421F13F (taille_boisson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ligne_taille ADD CONSTRAINT FK_508A177ECA2A78B2 FOREIGN KEY (ligne_de_commande_id) REFERENCES ligne_de_commande (id)');
        $this->addSql('ALTER TABLE ligne_taille ADD CONSTRAINT FK_508A177E8421F13F FOREIGN KEY (taille_boisson_id) REFERENCES taille_boisson (id)');
        $this->addSql('ALTER TABLE ligne_de_commande DROP FOREIGN KEY FK_7982ACE68421F13F');
        $this->addSql('DROP INDEX IDX_7982ACE68421F13F ON ligne_de_commande');
        $this->addSql('ALTER TABLE ligne_de_commande DROP taille_boisson_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ligne_taille');
        $this->addSql('ALTER TABLE ligne_de_commande ADD taille_boisson_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne_de_commande ADD CONSTRAINT FK_7982ACE68421F13F FOREIGN KEY (taille_boisson_id) REFERENCES taille_boisson (id)');
        $this->addSql('CREATE INDEX IDX_7982ACE68421F13F ON ligne_de_commande (taille_boisson_id)');
    }
}
