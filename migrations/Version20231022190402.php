<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231022190402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create_table_schedules';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE class_schedule (
                id UUID PRIMARY KEY,
                description VARCHAR(255) NOT NULL,
                schedule VARCHAR(255) NOT NULL,
                school_year_id UUID NOT NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL,
                deleted_at TIMESTAMP NULL
            );
        ');

        $this->addSql("CREATE INDEX idx_school_year_id ON class_schedule(school_year_id)");
        $this->addSql("CREATE INDEX idx_schedule ON class_schedule(schedule)");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE class_schedule;');
    }
}
