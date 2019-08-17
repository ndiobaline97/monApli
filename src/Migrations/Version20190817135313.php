<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190817135313 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD statut VARCHAR(255) NOT NULL, ADD image_name VARCHAR(255) NOT NULL, ADD updated_at DATETIME NOT NULL, CHANGE profile_id profile_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE depot ADD compte_id INT NOT NULL, ADD caissier_id INT NOT NULL, ADD date_depot DATETIME NOT NULL');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBCF2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBCB514973B FOREIGN KEY (caissier_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_47948BBCF2C56620 ON depot (compte_id)');
        $this->addSql('CREATE INDEX IDX_47948BBCB514973B ON depot (caissier_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBCF2C56620');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBCB514973B');
        $this->addSql('DROP INDEX IDX_47948BBCF2C56620 ON depot');
        $this->addSql('DROP INDEX IDX_47948BBCB514973B ON depot');
        $this->addSql('ALTER TABLE depot DROP compte_id, DROP caissier_id, DROP date_depot');
        $this->addSql('ALTER TABLE user DROP statut, DROP image_name, DROP updated_at, CHANGE profile_id profile_id INT NOT NULL');
    }
}
