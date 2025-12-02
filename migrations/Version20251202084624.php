<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Remove artist_id column from project table
 */
final class Version20251202084624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove artist_id foreign key and column from project table, and drop artist and user tables';
    }

    public function up(Schema $schema): void
    {
        // Drop foreign key constraint and artist_id column from project table
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEB7970CF8');
        $this->addSql('DROP INDEX IDX_2FB3D0EEB7970CF8 ON project');
        $this->addSql('ALTER TABLE project DROP artist_id');

        // Drop artist and user tables
        $this->addSql('DROP TABLE IF EXISTS artist');
        $this->addSql('DROP TABLE IF EXISTS user');
    }

    public function down(Schema $schema): void
    {
        // Recreate artist and user tables
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, biography LONGTEXT DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, profile_image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Re-add artist_id column to project table
        $this->addSql('ALTER TABLE project ADD artist_id INT NOT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEB7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEB7970CF8 ON project (artist_id)');
    }
}
