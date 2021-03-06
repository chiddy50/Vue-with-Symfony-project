<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191211135933 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE student_attendance DROP FOREIGN KEY FK_803CE070CB944F1A');
        $this->addSql('DROP INDEX IDX_803CE070CB944F1A ON student_attendance');
        $this->addSql('ALTER TABLE student_attendance DROP student_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE student_attendance ADD student_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE student_attendance ADD CONSTRAINT FK_803CE070CB944F1A FOREIGN KEY (student_id) REFERENCES student_info (id)');
        $this->addSql('CREATE INDEX IDX_803CE070CB944F1A ON student_attendance (student_id)');
    }
}
