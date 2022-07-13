<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220713111537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menus_taille (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, taille_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_A961061CCCD7E912 (menu_id), INDEX IDX_A961061CFF25611A (taille_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menus_taille ADD CONSTRAINT FK_A961061CCCD7E912 FOREIGN KEY (menu_id) REFERENCES menus (id)');
        $this->addSql('ALTER TABLE menus_taille ADD CONSTRAINT FK_A961061CFF25611A FOREIGN KEY (taille_id) REFERENCES taille (id)');
        $this->addSql('DROP TABLE menus_taille_boisson');
        $this->addSql('ALTER TABLE burger ADD prix DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE portion_frites ADD prix DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE produit DROP prix');
        $this->addSql('ALTER TABLE taille_boisson MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE taille_boisson DROP FOREIGN KEY FK_59FAC268FF25611A');
        $this->addSql('ALTER TABLE taille_boisson DROP FOREIGN KEY FK_59FAC268734B8089');
        $this->addSql('ALTER TABLE taille_boisson DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE taille_boisson DROP id, CHANGE boisson_id boisson_id INT NOT NULL');
        $this->addSql('ALTER TABLE taille_boisson ADD CONSTRAINT FK_59FAC268FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taille_boisson ADD CONSTRAINT FK_59FAC268734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taille_boisson ADD PRIMARY KEY (taille_id, boisson_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menus_taille_boisson (id INT AUTO_INCREMENT NOT NULL, taille_id INT NOT NULL, menus_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_9841976FF25611A (taille_id), INDEX IDX_984197614041B84 (menus_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE menus_taille_boisson ADD CONSTRAINT FK_9841976FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id)');
        $this->addSql('ALTER TABLE menus_taille_boisson ADD CONSTRAINT FK_984197614041B84 FOREIGN KEY (menus_id) REFERENCES menus (id)');
        $this->addSql('DROP TABLE menus_taille');
        $this->addSql('ALTER TABLE burger DROP prix');
        $this->addSql('ALTER TABLE portion_frites DROP prix');
        $this->addSql('ALTER TABLE produit ADD prix DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE taille_boisson DROP FOREIGN KEY FK_59FAC268FF25611A');
        $this->addSql('ALTER TABLE taille_boisson DROP FOREIGN KEY FK_59FAC268734B8089');
        $this->addSql('ALTER TABLE taille_boisson ADD id INT AUTO_INCREMENT NOT NULL, CHANGE boisson_id boisson_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE taille_boisson ADD CONSTRAINT FK_59FAC268FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id)');
        $this->addSql('ALTER TABLE taille_boisson ADD CONSTRAINT FK_59FAC268734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id)');
    }
}
