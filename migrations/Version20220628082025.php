<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628082025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boisson ADD menus_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE boisson ADD CONSTRAINT FK_8B97C84D14041B84 FOREIGN KEY (menus_id) REFERENCES menus (id)');
        $this->addSql('CREATE INDEX IDX_8B97C84D14041B84 ON boisson (menus_id)');
        $this->addSql('ALTER TABLE complement DROP FOREIGN KEY FK_F8A41E3414041B84');
        $this->addSql('DROP INDEX IDX_F8A41E3414041B84 ON complement');
        $this->addSql('ALTER TABLE complement DROP menus_id');
        $this->addSql('ALTER TABLE frites ADD menus_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE frites ADD CONSTRAINT FK_282D392A14041B84 FOREIGN KEY (menus_id) REFERENCES menus (id)');
        $this->addSql('CREATE INDEX IDX_282D392A14041B84 ON frites (menus_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boisson DROP FOREIGN KEY FK_8B97C84D14041B84');
        $this->addSql('DROP INDEX IDX_8B97C84D14041B84 ON boisson');
        $this->addSql('ALTER TABLE boisson DROP menus_id');
        $this->addSql('ALTER TABLE complement ADD menus_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE complement ADD CONSTRAINT FK_F8A41E3414041B84 FOREIGN KEY (menus_id) REFERENCES menus (id)');
        $this->addSql('CREATE INDEX IDX_F8A41E3414041B84 ON complement (menus_id)');
        $this->addSql('ALTER TABLE frites DROP FOREIGN KEY FK_282D392A14041B84');
        $this->addSql('DROP INDEX IDX_282D392A14041B84 ON frites');
        $this->addSql('ALTER TABLE frites DROP menus_id');
    }
}
