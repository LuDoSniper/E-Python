<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241022215535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE example ADD exercise_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE example ADD CONSTRAINT FK_6EEC9B9F5A726995 FOREIGN KEY (exercise_id_id) REFERENCES exercise (id)');
        $this->addSql('CREATE INDEX IDX_6EEC9B9F5A726995 ON example (exercise_id_id)');
        $this->addSql('ALTER TABLE exercise DROP FOREIGN KEY FK_AEDAD51CB3CE90D4');
        $this->addSql('DROP INDEX FK_AEDAD51CB3CE90D4 ON exercise');
        $this->addSql('ALTER TABLE exercise DROP example_ids_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE example DROP FOREIGN KEY FK_6EEC9B9F5A726995');
        $this->addSql('DROP INDEX IDX_6EEC9B9F5A726995 ON example');
        $this->addSql('ALTER TABLE example DROP exercise_id_id');
        $this->addSql('ALTER TABLE exercise ADD example_ids_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exercise ADD CONSTRAINT FK_AEDAD51CB3CE90D4 FOREIGN KEY (example_ids_id) REFERENCES example (id)');
        $this->addSql('CREATE INDEX FK_AEDAD51CB3CE90D4 ON exercise (example_ids_id)');
    }
}
