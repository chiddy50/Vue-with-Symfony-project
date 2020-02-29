<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191211140937 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE student_attendance ADD students_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE student_attendance ADD CONSTRAINT FK_803CE0701AD8D010 FOREIGN KEY (students_id) REFERENCES student_info (id)');
        $this->addSql('CREATE INDEX IDX_803CE0701AD8D010 ON student_attendance (students_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE student_attendance DROP FOREIGN KEY FK_803CE0701AD8D010');
        $this->addSql('DROP INDEX IDX_803CE0701AD8D010 ON student_attendance');
        $this->addSql('ALTER TABLE student_attendance DROP students_id');
    }
}
