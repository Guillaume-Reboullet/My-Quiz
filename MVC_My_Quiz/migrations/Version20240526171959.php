<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240526171959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique DROP save_datetime, DROP id_user');
        $this->addSql('ALTER TABLE resultat DROP save_datetime');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique ADD save_datetime DATETIME NOT NULL, ADD id_user INT NOT NULL');
        $this->addSql('ALTER TABLE resultat ADD save_datetime DATETIME NOT NULL');
    }
}
