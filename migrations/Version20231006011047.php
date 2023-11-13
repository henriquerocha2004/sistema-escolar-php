<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231006011047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create_room_table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE rooms (
                id UUID PRIMARY KEY,
                code VARCHAR(255) NOT NULL,
                description VARCHAR(255) NOT NULL,
                capacity INTEGER NOT NULL,
                created_at TIMESTAMP(0) NULL,
                updated_at TIMESTAMP(0) NULL,
                deleted_at TIMESTAMP(0) NULL
            );
        ');

        $this->addSql("CREATE INDEX idx_code ON rooms(code)");
        $this->addSql("CREATE INDEX idx_description ON rooms(description)");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE rooms;');
    }
}
