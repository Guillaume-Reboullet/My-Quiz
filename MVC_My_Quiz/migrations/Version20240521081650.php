<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521081650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EBA934BCD');
        // $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, id_categorie INT NOT NULL, id_question INT NOT NULL, resultat INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resultat (id INT AUTO_INCREMENT NOT NULL, id_categorie INT NOT NULL, id_question INT NOT NULL, reponse INT NOT NULL, id_user INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('ALTER TABLE quizz DROP FOREIGN KEY FK_7C77973DBCF5E72D');
        // $this->addSql('DROP TABLE quizz');
        // $this->addSql('DROP INDEX IDX_B6F7494EBA934BCD ON question');
        // $this->addSql('ALTER TABLE question ADD id_categorie INT NOT NULL, DROP quizz_id');
        // $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC71E27F6BF');
        // $this->addSql('DROP INDEX IDX_5FB6DEC71E27F6BF ON reponse');
        // $this->addSql('ALTER TABLE reponse ADD id_question INT NOT NULL, DROP question_id, CHANGE reponse_expected reponse_expected INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quizz (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_7C77973DBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE quizz ADD CONSTRAINT FK_7C77973DBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE resultat');
        $this->addSql('ALTER TABLE reponse ADD question_id INT DEFAULT NULL, DROP id_question, CHANGE reponse_expected reponse_expected TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC71E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5FB6DEC71E27F6BF ON reponse (question_id)');
        $this->addSql('ALTER TABLE question ADD quizz_id INT DEFAULT NULL, DROP id_categorie');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B6F7494EBA934BCD ON question (quizz_id)');
    }
}
