<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240402152247 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vouloir (id INT AUTO_INCREMENT NOT NULL, quantite INT NOT NULL, jeu_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_E20BEC078C9E392E (jeu_id), INDEX IDX_E20BEC07A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE vouloir ADD CONSTRAINT FK_E20BEC078C9E392E FOREIGN KEY (jeu_id) REFERENCES jeux (id)');
        $this->addSql('ALTER TABLE vouloir ADD CONSTRAINT FK_E20BEC07A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vouloir DROP FOREIGN KEY FK_E20BEC078C9E392E');
        $this->addSql('ALTER TABLE vouloir DROP FOREIGN KEY FK_E20BEC07A76ED395');
        $this->addSql('DROP TABLE vouloir');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
