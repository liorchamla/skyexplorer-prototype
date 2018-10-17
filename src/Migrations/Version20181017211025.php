<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181017211025 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, flight_time DOUBLE PRECISION NOT NULL, floor_time DOUBLE PRECISION NOT NULL, briefing_time DOUBLE PRECISION NOT NULL, price DOUBLE PRECISION NOT NULL, flight_hour_price DOUBLE PRECISION NOT NULL, floor_hour_price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flight (id INT AUTO_INCREMENT NOT NULL, plane_id INT DEFAULT NULL, teacher_id INT DEFAULT NULL, student_id INT DEFAULT NULL, course_id INT DEFAULT NULL, flight_time DOUBLE PRECISION DEFAULT NULL, floor_time DOUBLE PRECISION DEFAULT NULL, escale TINYINT(1) DEFAULT NULL, is_flight_book TINYINT(1) DEFAULT NULL, is_lpe TINYINT(1) DEFAULT NULL, payment_type VARCHAR(255) DEFAULT NULL, is_paid TINYINT(1) DEFAULT NULL, escale_location VARCHAR(255) DEFAULT NULL, start_at TIME NOT NULL, end_at TIME NOT NULL, day DATE NOT NULL, fuel DOUBLE PRECISION DEFAULT NULL, INDEX IDX_C257E60EF53666A8 (plane_id), INDEX IDX_C257E60E41807E1D (teacher_id), INDEX IDX_C257E60ECB944F1A (student_id), INDEX IDX_C257E60E591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plane (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, rental_price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plane_course (plane_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_451F8F87F53666A8 (plane_id), INDEX IDX_451F8F87591CC992 (course_id), PRIMARY KEY(plane_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, debit DOUBLE PRECISION NOT NULL, credit DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_plane (user_id INT NOT NULL, plane_id INT NOT NULL, INDEX IDX_2371D6D8A76ED395 (user_id), INDEX IDX_2371D6D8F53666A8 (plane_id), PRIMARY KEY(user_id, plane_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_courses (id INT AUTO_INCREMENT NOT NULL, student_id INT DEFAULT NULL, course_id INT DEFAULT NULL, INDEX IDX_F1A84446CB944F1A (student_id), INDEX IDX_F1A84446591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60EF53666A8 FOREIGN KEY (plane_id) REFERENCES plane (id)');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60E41807E1D FOREIGN KEY (teacher_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60ECB944F1A FOREIGN KEY (student_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60E591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE plane_course ADD CONSTRAINT FK_451F8F87F53666A8 FOREIGN KEY (plane_id) REFERENCES plane (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plane_course ADD CONSTRAINT FK_451F8F87591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_plane ADD CONSTRAINT FK_2371D6D8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_plane ADD CONSTRAINT FK_2371D6D8F53666A8 FOREIGN KEY (plane_id) REFERENCES plane (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_courses ADD CONSTRAINT FK_F1A84446CB944F1A FOREIGN KEY (student_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_courses ADD CONSTRAINT FK_F1A84446591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE flight DROP FOREIGN KEY FK_C257E60E591CC992');
        $this->addSql('ALTER TABLE plane_course DROP FOREIGN KEY FK_451F8F87591CC992');
        $this->addSql('ALTER TABLE user_courses DROP FOREIGN KEY FK_F1A84446591CC992');
        $this->addSql('ALTER TABLE flight DROP FOREIGN KEY FK_C257E60EF53666A8');
        $this->addSql('ALTER TABLE plane_course DROP FOREIGN KEY FK_451F8F87F53666A8');
        $this->addSql('ALTER TABLE user_plane DROP FOREIGN KEY FK_2371D6D8F53666A8');
        $this->addSql('ALTER TABLE flight DROP FOREIGN KEY FK_C257E60E41807E1D');
        $this->addSql('ALTER TABLE flight DROP FOREIGN KEY FK_C257E60ECB944F1A');
        $this->addSql('ALTER TABLE user_plane DROP FOREIGN KEY FK_2371D6D8A76ED395');
        $this->addSql('ALTER TABLE user_courses DROP FOREIGN KEY FK_F1A84446CB944F1A');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE flight');
        $this->addSql('DROP TABLE plane');
        $this->addSql('DROP TABLE plane_course');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_plane');
        $this->addSql('DROP TABLE user_courses');
    }
}
