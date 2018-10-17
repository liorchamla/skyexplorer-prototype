<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181017210601 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE flight CHANGE flight_time flight_time DOUBLE PRECISION NOT NULL, CHANGE floor_time floor_time DOUBLE PRECISION NOT NULL, CHANGE escale escale TINYINT(1) NOT NULL, CHANGE is_flight_book is_flight_book TINYINT(1) NOT NULL, CHANGE is_lpe is_lpe TINYINT(1) NOT NULL, CHANGE payment_type payment_type VARCHAR(255) NOT NULL, CHANGE is_paid is_paid TINYINT(1) NOT NULL, CHANGE escale_location escale_location VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE flight CHANGE flight_time flight_time DOUBLE PRECISION DEFAULT NULL, CHANGE floor_time floor_time DOUBLE PRECISION DEFAULT NULL, CHANGE escale escale TINYINT(1) DEFAULT NULL, CHANGE is_flight_book is_flight_book TINYINT(1) DEFAULT NULL, CHANGE is_lpe is_lpe TINYINT(1) DEFAULT NULL, CHANGE payment_type payment_type VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE is_paid is_paid TINYINT(1) DEFAULT NULL, CHANGE escale_location escale_location VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
