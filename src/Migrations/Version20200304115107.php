<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200304115107 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE exam_result (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, grade_id INT NOT NULL, subject_id INT NOT NULL, session_id INT NOT NULL, term_id INT NOT NULL, first_ca INT DEFAULT NULL, second_ca INT DEFAULT NULL, exam INT NOT NULL, total INT NOT NULL, date DATE NOT NULL, INDEX IDX_D8599799CB944F1A (student_id), INDEX IDX_D8599799FE19A1A8 (grade_id), INDEX IDX_D859979923EDC87 (subject_id), INDEX IDX_D8599799613FECDF (session_id), INDEX IDX_D8599799E2C35FC (term_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exam_result ADD CONSTRAINT FK_D8599799CB944F1A FOREIGN KEY (student_id) REFERENCES student_info (id)');
        $this->addSql('ALTER TABLE exam_result ADD CONSTRAINT FK_D8599799FE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id)');
        $this->addSql('ALTER TABLE exam_result ADD CONSTRAINT FK_D859979923EDC87 FOREIGN KEY (subject_id) REFERENCES subjects (id)');
        $this->addSql('ALTER TABLE exam_result ADD CONSTRAINT FK_D8599799613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE exam_result ADD CONSTRAINT FK_D8599799E2C35FC FOREIGN KEY (term_id) REFERENCES term (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE exam_result');
    }
}
