<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220707152757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menus_protion_frites DROP FOREIGN KEY FK_8204D8CACCD7E912');
        $this->addSql('DROP INDEX IDX_8204D8CACCD7E912 ON menus_protion_frites');
        $this->addSql('ALTER TABLE menus_protion_frites ADD quantity INT NOT NULL, CHANGE menu_id menus_id INT NOT NULL');
        $this->addSql('ALTER TABLE menus_protion_frites ADD CONSTRAINT FK_8204D8CA14041B84 FOREIGN KEY (menus_id) REFERENCES menus (id)');
        $this->addSql('CREATE INDEX IDX_8204D8CA14041B84 ON menus_protion_frites (menus_id)');
        $this->addSql('ALTER TABLE menus_taille_boisson DROP FOREIGN KEY FK_98419768421F13F');
        $this->addSql('DROP INDEX IDX_98419768421F13F ON menus_taille_boisson');
        $this->addSql('ALTER TABLE menus_taille_boisson ADD quantity INT NOT NULL, CHANGE taille_boisson_id taille_id INT NOT NULL');
        $this->addSql('ALTER TABLE menus_taille_boisson ADD CONSTRAINT FK_9841976FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id)');
        $this->addSql('CREATE INDEX IDX_9841976FF25611A ON menus_taille_boisson (taille_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menus_protion_frites DROP FOREIGN KEY FK_8204D8CA14041B84');
        $this->addSql('DROP INDEX IDX_8204D8CA14041B84 ON menus_protion_frites');
        $this->addSql('ALTER TABLE menus_protion_frites ADD menu_id INT NOT NULL, DROP menus_id, DROP quantity');
        $this->addSql('ALTER TABLE menus_protion_frites ADD CONSTRAINT FK_8204D8CACCD7E912 FOREIGN KEY (menu_id) REFERENCES menus (id)');
        $this->addSql('CREATE INDEX IDX_8204D8CACCD7E912 ON menus_protion_frites (menu_id)');
        $this->addSql('ALTER TABLE menus_taille_boisson DROP FOREIGN KEY FK_9841976FF25611A');
        $this->addSql('DROP INDEX IDX_9841976FF25611A ON menus_taille_boisson');
        $this->addSql('ALTER TABLE menus_taille_boisson ADD taille_boisson_id INT NOT NULL, DROP taille_id, DROP quantity');
        $this->addSql('ALTER TABLE menus_taille_boisson ADD CONSTRAINT FK_98419768421F13F FOREIGN KEY (taille_boisson_id) REFERENCES taille_boisson (id)');
        $this->addSql('CREATE INDEX IDX_98419768421F13F ON menus_taille_boisson (taille_boisson_id)');
    }
}
