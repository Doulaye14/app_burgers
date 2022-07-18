<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220714142104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menus_taille (id INT AUTO_INCREMENT NOT NULL, menu_id INT NOT NULL, taille_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_A961061CCCD7E912 (menu_id), INDEX IDX_A961061CFF25611A (taille_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menus_taille ADD CONSTRAINT FK_A961061CCCD7E912 FOREIGN KEY (menu_id) REFERENCES menus (id)');
        $this->addSql('ALTER TABLE menus_taille ADD CONSTRAINT FK_A961061CFF25611A FOREIGN KEY (taille_id) REFERENCES taille (id)');
        $this->addSql('DROP TABLE menus_boisson');
        $this->addSql('ALTER TABLE boisson DROP taille, DROP variete, DROP stock');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menus_boisson (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, boisson_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_B74B1D11CCD7E912 (menu_id), INDEX IDX_B74B1D11734B8089 (boisson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE menus_boisson ADD CONSTRAINT FK_B74B1D11734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id)');
        $this->addSql('ALTER TABLE menus_boisson ADD CONSTRAINT FK_B74B1D11CCD7E912 FOREIGN KEY (menu_id) REFERENCES menus (id)');
        $this->addSql('DROP TABLE menus_taille');
        $this->addSql('ALTER TABLE boisson ADD taille VARCHAR(255) NOT NULL, ADD variete VARCHAR(255) NOT NULL, ADD stock INT DEFAULT NULL');
    }
}
