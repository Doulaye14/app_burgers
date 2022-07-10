<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220707153736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menus_taille_boisson DROP FOREIGN KEY FK_9841976CCD7E912');
        $this->addSql('DROP INDEX IDX_9841976CCD7E912 ON menus_taille_boisson');
        $this->addSql('ALTER TABLE menus_taille_boisson ADD menus_id INT NOT NULL, DROP menu_id, DROP quantity');
        $this->addSql('ALTER TABLE menus_taille_boisson ADD CONSTRAINT FK_984197614041B84 FOREIGN KEY (menus_id) REFERENCES menus (id)');
        $this->addSql('CREATE INDEX IDX_984197614041B84 ON menus_taille_boisson (menus_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menus_taille_boisson DROP FOREIGN KEY FK_984197614041B84');
        $this->addSql('DROP INDEX IDX_984197614041B84 ON menus_taille_boisson');
        $this->addSql('ALTER TABLE menus_taille_boisson ADD quantity INT NOT NULL, CHANGE menus_id menu_id INT NOT NULL');
        $this->addSql('ALTER TABLE menus_taille_boisson ADD CONSTRAINT FK_9841976CCD7E912 FOREIGN KEY (menu_id) REFERENCES menus (id)');
        $this->addSql('CREATE INDEX IDX_9841976CCD7E912 ON menus_taille_boisson (menu_id)');
    }
}
