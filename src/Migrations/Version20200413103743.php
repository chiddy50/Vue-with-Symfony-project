<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200413103743 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE api_token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, token VARCHAR(255) NOT NULL, expires_at DATETIME DEFAULT NULL, INDEX IDX_7BA2F5EBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE class_attendance (id INT AUTO_INCREMENT NOT NULL, month_id INT DEFAULT NULL, session_id INT DEFAULT NULL, student_id INT DEFAULT NULL, subject_id INT NOT NULL, present TINYINT(1) NOT NULL, entry_by INT DEFAULT NULL, entry_date DATETIME DEFAULT NULL, date DATETIME DEFAULT NULL, INDEX IDX_DBEEFF33A0CBDE4 (month_id), INDEX IDX_DBEEFF33613FECDF (session_id), INDEX IDX_DBEEFF33CB944F1A (student_id), INDEX IDX_DBEEFF3323EDC87 (subject_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classes (id INT AUTO_INCREMENT NOT NULL, class_name VARCHAR(20) NOT NULL, class_code VARCHAR(5) NOT NULL, entry_by INT DEFAULT NULL, entry_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classes_subjects (classes_id INT NOT NULL, subjects_id INT NOT NULL, INDEX IDX_E1D07F0E9E225B24 (classes_id), INDEX IDX_E1D07F0E94AF957A (subjects_id), PRIMARY KEY(classes_id, subjects_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE designation (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(30) NOT NULL, salary NUMERIC(10, 2) NOT NULL, entry_by INT DEFAULT NULL, entry_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exam (id INT AUTO_INCREMENT NOT NULL, subject_id INT DEFAULT NULL, student_group_id INT DEFAULT NULL, classes_id INT DEFAULT NULL, section_id INT DEFAULT NULL, session_id INT DEFAULT NULL, term_id INT DEFAULT NULL, exam_name VARCHAR(50) NOT NULL, time VARCHAR(25) DEFAULT NULL, date DATE DEFAULT NULL, INDEX IDX_38BBA6C623EDC87 (subject_id), INDEX IDX_38BBA6C64DDF95DC (student_group_id), INDEX IDX_38BBA6C69E225B24 (classes_id), INDEX IDX_38BBA6C6D823E37A (section_id), INDEX IDX_38BBA6C6613FECDF (session_id), INDEX IDX_38BBA6C6E2C35FC (term_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exam_result (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, grade_id INT NOT NULL, subject_id INT NOT NULL, session_id INT NOT NULL, term_id INT NOT NULL, class_id INT NOT NULL, section_id INT NOT NULL, first_ca INT NOT NULL, second_ca INT NOT NULL, exam INT NOT NULL, total INT NOT NULL, date DATE NOT NULL, INDEX IDX_D8599799CB944F1A (student_id), INDEX IDX_D8599799FE19A1A8 (grade_id), INDEX IDX_D859979923EDC87 (subject_id), INDEX IDX_D8599799613FECDF (session_id), INDEX IDX_D8599799E2C35FC (term_id), INDEX IDX_D8599799EA000B10 (class_id), INDEX IDX_D8599799D823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gender (id INT AUTO_INCREMENT NOT NULL, gender VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grade (id INT AUTO_INCREMENT NOT NULL, grade VARCHAR(20) NOT NULL, percent_from INT NOT NULL, percent_upto INT NOT NULL, comment VARCHAR(100) DEFAULT NULL, description VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE month (id INT AUTO_INCREMENT NOT NULL, month VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parents (id INT AUTO_INCREMENT NOT NULL, fullname VARCHAR(50) NOT NULL, email VARCHAR(30) DEFAULT NULL, gender VARCHAR(9) NOT NULL, address LONGTEXT NOT NULL, phone VARCHAR(20) NOT NULL, entry_by INT DEFAULT NULL, entry_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, section_name VARCHAR(10) NOT NULL, section_code VARCHAR(7) NOT NULL, entry_by INT DEFAULT NULL, entry_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, session VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE staff_info (id INT AUTO_INCREMENT NOT NULL, designation_id INT NOT NULL, staff_type_id INT NOT NULL, staff_status_id INT NOT NULL, staff_no INT NOT NULL, fullname VARCHAR(50) NOT NULL, address LONGTEXT DEFAULT NULL, gender VARCHAR(9) NOT NULL, phone VARCHAR(11) NOT NULL, marital_status VARCHAR(10) NOT NULL, email VARCHAR(30) NOT NULL, date_of_employment DATETIME NOT NULL, termination_date DATETIME DEFAULT NULL, entry_by INT DEFAULT NULL, entry_date DATETIME DEFAULT NULL, INDEX IDX_29BF47D8FAC7D83F (designation_id), INDEX IDX_29BF47D899FA9B25 (staff_type_id), INDEX IDX_29BF47D85ABBD0F2 (staff_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE staff_status (id INT AUTO_INCREMENT NOT NULL, staff_status VARCHAR(10) NOT NULL, entry_by INT DEFAULT NULL, entry_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE staff_type (id INT AUTO_INCREMENT NOT NULL, staff_type VARCHAR(30) NOT NULL, entry_by INT DEFAULT NULL, entry_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_attendance (id INT AUTO_INCREMENT NOT NULL, month_id INT DEFAULT NULL, session_id INT DEFAULT NULL, students_id INT DEFAULT NULL, date DATETIME NOT NULL, present TINYINT(1) NOT NULL, entry_by INT DEFAULT NULL, entry_date DATE DEFAULT NULL, INDEX IDX_803CE070A0CBDE4 (month_id), INDEX IDX_803CE070613FECDF (session_id), INDEX IDX_803CE0701AD8D010 (students_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_group (id INT AUTO_INCREMENT NOT NULL, group_name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject_group (student_group_id INT NOT NULL, subject_id INT NOT NULL, INDEX IDX_7C53851D4DDF95DC (student_group_id), INDEX IDX_7C53851D23EDC87 (subject_id), PRIMARY KEY(student_group_id, subject_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_info (id INT AUTO_INCREMENT NOT NULL, classes_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, student_group_id INT DEFAULT NULL, section_id INT NOT NULL, gender_id INT NOT NULL, roll_no VARCHAR(10) NOT NULL, firstname VARCHAR(20) NOT NULL, lastname VARCHAR(10) NOT NULL, admission_date DATETIME NOT NULL, dob DATETIME NOT NULL, email VARCHAR(30) DEFAULT NULL, entry_by INT DEFAULT NULL, entry_date DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_F4AA4A8F73982269 (roll_no), INDEX IDX_F4AA4A8F9E225B24 (classes_id), INDEX IDX_F4AA4A8F727ACA70 (parent_id), INDEX IDX_F4AA4A8F4DDF95DC (student_group_id), INDEX IDX_F4AA4A8FD823E37A (section_id), INDEX IDX_F4AA4A8F708A0E0 (gender_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject_result (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, grade_id INT DEFAULT NULL, subject_id INT NOT NULL, session_id INT NOT NULL, term_id INT NOT NULL, date DATE DEFAULT NULL, score INT NOT NULL, INDEX IDX_9B730834CB944F1A (student_id), INDEX IDX_9B730834FE19A1A8 (grade_id), INDEX IDX_9B73083423EDC87 (subject_id), INDEX IDX_9B730834613FECDF (session_id), INDEX IDX_9B730834E2C35FC (term_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subjects (id INT AUTO_INCREMENT NOT NULL, subject_type_id INT DEFAULT NULL, subject VARCHAR(30) NOT NULL, subject_code VARCHAR(15) NOT NULL, entry_by INT DEFAULT NULL, enty_date DATETIME DEFAULT NULL, INDEX IDX_AB25991760CE2031 (subject_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject_type (id INT AUTO_INCREMENT NOT NULL, subject_type VARCHAR(30) NOT NULL, entry_by INT DEFAULT NULL, entry_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE term (id INT AUTO_INCREMENT NOT NULL, term_code VARCHAR(30) NOT NULL, term_description VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE api_token ADD CONSTRAINT FK_7BA2F5EBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE class_attendance ADD CONSTRAINT FK_DBEEFF33A0CBDE4 FOREIGN KEY (month_id) REFERENCES month (id)');
        $this->addSql('ALTER TABLE class_attendance ADD CONSTRAINT FK_DBEEFF33613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE class_attendance ADD CONSTRAINT FK_DBEEFF33CB944F1A FOREIGN KEY (student_id) REFERENCES student_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE class_attendance ADD CONSTRAINT FK_DBEEFF3323EDC87 FOREIGN KEY (subject_id) REFERENCES subjects (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classes_subjects ADD CONSTRAINT FK_E1D07F0E9E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classes_subjects ADD CONSTRAINT FK_E1D07F0E94AF957A FOREIGN KEY (subjects_id) REFERENCES subjects (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exam ADD CONSTRAINT FK_38BBA6C623EDC87 FOREIGN KEY (subject_id) REFERENCES subjects (id)');
        $this->addSql('ALTER TABLE exam ADD CONSTRAINT FK_38BBA6C64DDF95DC FOREIGN KEY (student_group_id) REFERENCES student_group (id)');
        $this->addSql('ALTER TABLE exam ADD CONSTRAINT FK_38BBA6C69E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id)');
        $this->addSql('ALTER TABLE exam ADD CONSTRAINT FK_38BBA6C6D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE exam ADD CONSTRAINT FK_38BBA6C6613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE exam ADD CONSTRAINT FK_38BBA6C6E2C35FC FOREIGN KEY (term_id) REFERENCES term (id)');
        $this->addSql('ALTER TABLE exam_result ADD CONSTRAINT FK_D8599799CB944F1A FOREIGN KEY (student_id) REFERENCES student_info (id)');
        $this->addSql('ALTER TABLE exam_result ADD CONSTRAINT FK_D8599799FE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id)');
        $this->addSql('ALTER TABLE exam_result ADD CONSTRAINT FK_D859979923EDC87 FOREIGN KEY (subject_id) REFERENCES subjects (id)');
        $this->addSql('ALTER TABLE exam_result ADD CONSTRAINT FK_D8599799613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE exam_result ADD CONSTRAINT FK_D8599799E2C35FC FOREIGN KEY (term_id) REFERENCES term (id)');
        $this->addSql('ALTER TABLE exam_result ADD CONSTRAINT FK_D8599799EA000B10 FOREIGN KEY (class_id) REFERENCES classes (id)');
        $this->addSql('ALTER TABLE exam_result ADD CONSTRAINT FK_D8599799D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE staff_info ADD CONSTRAINT FK_29BF47D8FAC7D83F FOREIGN KEY (designation_id) REFERENCES designation (id)');
        $this->addSql('ALTER TABLE staff_info ADD CONSTRAINT FK_29BF47D899FA9B25 FOREIGN KEY (staff_type_id) REFERENCES staff_type (id)');
        $this->addSql('ALTER TABLE staff_info ADD CONSTRAINT FK_29BF47D85ABBD0F2 FOREIGN KEY (staff_status_id) REFERENCES staff_status (id)');
        $this->addSql('ALTER TABLE student_attendance ADD CONSTRAINT FK_803CE070A0CBDE4 FOREIGN KEY (month_id) REFERENCES month (id)');
        $this->addSql('ALTER TABLE student_attendance ADD CONSTRAINT FK_803CE070613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE student_attendance ADD CONSTRAINT FK_803CE0701AD8D010 FOREIGN KEY (students_id) REFERENCES student_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subject_group ADD CONSTRAINT FK_7C53851D4DDF95DC FOREIGN KEY (student_group_id) REFERENCES student_group (id)');
        $this->addSql('ALTER TABLE subject_group ADD CONSTRAINT FK_7C53851D23EDC87 FOREIGN KEY (subject_id) REFERENCES subjects (id)');
        $this->addSql('ALTER TABLE student_info ADD CONSTRAINT FK_F4AA4A8F9E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id)');
        $this->addSql('ALTER TABLE student_info ADD CONSTRAINT FK_F4AA4A8F727ACA70 FOREIGN KEY (parent_id) REFERENCES parents (id)');
        $this->addSql('ALTER TABLE student_info ADD CONSTRAINT FK_F4AA4A8F4DDF95DC FOREIGN KEY (student_group_id) REFERENCES student_group (id)');
        $this->addSql('ALTER TABLE student_info ADD CONSTRAINT FK_F4AA4A8FD823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE student_info ADD CONSTRAINT FK_F4AA4A8F708A0E0 FOREIGN KEY (gender_id) REFERENCES gender (id)');
        $this->addSql('ALTER TABLE subject_result ADD CONSTRAINT FK_9B730834CB944F1A FOREIGN KEY (student_id) REFERENCES student_info (id)');
        $this->addSql('ALTER TABLE subject_result ADD CONSTRAINT FK_9B730834FE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id)');
        $this->addSql('ALTER TABLE subject_result ADD CONSTRAINT FK_9B73083423EDC87 FOREIGN KEY (subject_id) REFERENCES subjects (id)');
        $this->addSql('ALTER TABLE subject_result ADD CONSTRAINT FK_9B730834613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE subject_result ADD CONSTRAINT FK_9B730834E2C35FC FOREIGN KEY (term_id) REFERENCES term (id)');
        $this->addSql('ALTER TABLE subjects ADD CONSTRAINT FK_AB25991760CE2031 FOREIGN KEY (subject_type_id) REFERENCES subject_type (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE classes_subjects DROP FOREIGN KEY FK_E1D07F0E9E225B24');
        $this->addSql('ALTER TABLE exam DROP FOREIGN KEY FK_38BBA6C69E225B24');
        $this->addSql('ALTER TABLE exam_result DROP FOREIGN KEY FK_D8599799EA000B10');
        $this->addSql('ALTER TABLE student_info DROP FOREIGN KEY FK_F4AA4A8F9E225B24');
        $this->addSql('ALTER TABLE staff_info DROP FOREIGN KEY FK_29BF47D8FAC7D83F');
        $this->addSql('ALTER TABLE student_info DROP FOREIGN KEY FK_F4AA4A8F708A0E0');
        $this->addSql('ALTER TABLE exam_result DROP FOREIGN KEY FK_D8599799FE19A1A8');
        $this->addSql('ALTER TABLE subject_result DROP FOREIGN KEY FK_9B730834FE19A1A8');
        $this->addSql('ALTER TABLE class_attendance DROP FOREIGN KEY FK_DBEEFF33A0CBDE4');
        $this->addSql('ALTER TABLE student_attendance DROP FOREIGN KEY FK_803CE070A0CBDE4');
        $this->addSql('ALTER TABLE student_info DROP FOREIGN KEY FK_F4AA4A8F727ACA70');
        $this->addSql('ALTER TABLE exam DROP FOREIGN KEY FK_38BBA6C6D823E37A');
        $this->addSql('ALTER TABLE exam_result DROP FOREIGN KEY FK_D8599799D823E37A');
        $this->addSql('ALTER TABLE student_info DROP FOREIGN KEY FK_F4AA4A8FD823E37A');
        $this->addSql('ALTER TABLE class_attendance DROP FOREIGN KEY FK_DBEEFF33613FECDF');
        $this->addSql('ALTER TABLE exam DROP FOREIGN KEY FK_38BBA6C6613FECDF');
        $this->addSql('ALTER TABLE exam_result DROP FOREIGN KEY FK_D8599799613FECDF');
        $this->addSql('ALTER TABLE student_attendance DROP FOREIGN KEY FK_803CE070613FECDF');
        $this->addSql('ALTER TABLE subject_result DROP FOREIGN KEY FK_9B730834613FECDF');
        $this->addSql('ALTER TABLE staff_info DROP FOREIGN KEY FK_29BF47D85ABBD0F2');
        $this->addSql('ALTER TABLE staff_info DROP FOREIGN KEY FK_29BF47D899FA9B25');
        $this->addSql('ALTER TABLE exam DROP FOREIGN KEY FK_38BBA6C64DDF95DC');
        $this->addSql('ALTER TABLE subject_group DROP FOREIGN KEY FK_7C53851D4DDF95DC');
        $this->addSql('ALTER TABLE student_info DROP FOREIGN KEY FK_F4AA4A8F4DDF95DC');
        $this->addSql('ALTER TABLE class_attendance DROP FOREIGN KEY FK_DBEEFF33CB944F1A');
        $this->addSql('ALTER TABLE exam_result DROP FOREIGN KEY FK_D8599799CB944F1A');
        $this->addSql('ALTER TABLE student_attendance DROP FOREIGN KEY FK_803CE0701AD8D010');
        $this->addSql('ALTER TABLE subject_result DROP FOREIGN KEY FK_9B730834CB944F1A');
        $this->addSql('ALTER TABLE class_attendance DROP FOREIGN KEY FK_DBEEFF3323EDC87');
        $this->addSql('ALTER TABLE classes_subjects DROP FOREIGN KEY FK_E1D07F0E94AF957A');
        $this->addSql('ALTER TABLE exam DROP FOREIGN KEY FK_38BBA6C623EDC87');
        $this->addSql('ALTER TABLE exam_result DROP FOREIGN KEY FK_D859979923EDC87');
        $this->addSql('ALTER TABLE subject_group DROP FOREIGN KEY FK_7C53851D23EDC87');
        $this->addSql('ALTER TABLE subject_result DROP FOREIGN KEY FK_9B73083423EDC87');
        $this->addSql('ALTER TABLE subjects DROP FOREIGN KEY FK_AB25991760CE2031');
        $this->addSql('ALTER TABLE exam DROP FOREIGN KEY FK_38BBA6C6E2C35FC');
        $this->addSql('ALTER TABLE exam_result DROP FOREIGN KEY FK_D8599799E2C35FC');
        $this->addSql('ALTER TABLE subject_result DROP FOREIGN KEY FK_9B730834E2C35FC');
        $this->addSql('ALTER TABLE api_token DROP FOREIGN KEY FK_7BA2F5EBA76ED395');
        $this->addSql('DROP TABLE api_token');
        $this->addSql('DROP TABLE class_attendance');
        $this->addSql('DROP TABLE classes');
        $this->addSql('DROP TABLE classes_subjects');
        $this->addSql('DROP TABLE designation');
        $this->addSql('DROP TABLE exam');
        $this->addSql('DROP TABLE exam_result');
        $this->addSql('DROP TABLE gender');
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE month');
        $this->addSql('DROP TABLE parents');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE staff_info');
        $this->addSql('DROP TABLE staff_status');
        $this->addSql('DROP TABLE staff_type');
        $this->addSql('DROP TABLE student_attendance');
        $this->addSql('DROP TABLE student_group');
        $this->addSql('DROP TABLE subject_group');
        $this->addSql('DROP TABLE student_info');
        $this->addSql('DROP TABLE subject_result');
        $this->addSql('DROP TABLE subjects');
        $this->addSql('DROP TABLE subject_type');
        $this->addSql('DROP TABLE term');
        $this->addSql('DROP TABLE user');
    }
}
