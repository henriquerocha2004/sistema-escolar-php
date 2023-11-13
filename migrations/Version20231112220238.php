<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231112220238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create_class_room_class';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE class_room (
                id UUID PRIMARY KEY,
                active BOOLEAN NOT NULL DEFAULT false,
                status VARCHAR(255) NOT NULL,
                identification VARCHAR(255) NOT NULL,
                type VARCHAR(255) NOT NULL,
                vacancies INTEGER NOT NULL,
                vacancies_occupied INTEGER NOT NULL,
                shift VARCHAR(255) NOT NULL,
                level VARCHAR(255) NOT NULL,
                localization VARCHAR(255),
                open_date TIMESTAMP NOT NULL,
                school_year_id UUID NOT NULL,
                room_id UUID,
                schedule_id UUID NOT NULL,
                created_at TIMESTAMP,
                updated_at TIMESTAMP,
                deleted_at TIMESTAMP
            );
       ');

        $this->addSql('CREATE INDEX idx_status ON class_room(status)');
        $this->addSql('CREATE INDEX idx_shift ON class_room(shift)');
        $this->addSql('CREATE INDEX idx_class_room_school_year_id ON class_room(school_year_id)');
        $this->addSql('CREATE INDEX idx_room_id ON class_room(room_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE class_room;');
    }
}
