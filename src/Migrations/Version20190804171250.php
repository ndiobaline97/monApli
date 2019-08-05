<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190804171250 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64998DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64998DE13AC ON user (partenaire_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649CCFA12B8 ON user (profile_id)');
        $this->addSql('ALTER TABLE depot ADD date_depot DATETIME NOT NULL');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBCF2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBCF2C56620');
        $this->addSql('ALTER TABLE depot DROP date_depot');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64998DE13AC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CCFA12B8');
        $this->addSql('DROP INDEX IDX_8D93D64998DE13AC ON user');
        $this->addSql('DROP INDEX IDX_8D93D649CCFA12B8 ON user');
    }
}
