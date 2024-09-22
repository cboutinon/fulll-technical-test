<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240922193429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tables to manage fleets';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE fleet (id CHAR(36) NOT NULL COMMENT \'(DC2Type:fleet_id)\', user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:user_id)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id CHAR(36) NOT NULL COMMENT \'(DC2Type:vehicle_id)\', fleet_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:fleet_id)\', type VARCHAR(255) NOT NULL, plate_number VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, altitude DOUBLE PRECISION DEFAULT NULL, INDEX IDX_1B80E4864B061DF9 (fleet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4864B061DF9 FOREIGN KEY (fleet_id) REFERENCES fleet (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E4864B061DF9');
        $this->addSql('DROP TABLE fleet');
        $this->addSql('DROP TABLE vehicle');
    }
}
