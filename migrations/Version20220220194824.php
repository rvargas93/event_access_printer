<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220220194824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Insert tickets type';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO ticket_type VALUES (1, "VIP")');
        $this->addSql('INSERT INTO ticket_type VALUES (2, "Preference and general")');
        $this->addSql('INSERT INTO ticket_type VALUES (3, "Limited to 15, 20 and 25 people")');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM ticket_type WHERE id IN (1, 2, 3)');
    }
}
