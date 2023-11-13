<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231003000258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create_school_year';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE school_year(
                id UUID PRIMARY KEY,
                year VARCHAR(255) NOT NULL UNIQUE,
                start_at DATE NOT NULL,
                end_at DATE NOT NULL,
                created_at TIMESTAMP(0) NULL,
                updated_at TIMESTAMP(0) NULL,
                deleted_at TIMESTAMP(0) NULL
            );
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE school_year');
    }
}
