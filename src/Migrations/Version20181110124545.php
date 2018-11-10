<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181110124545 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE mycharacter (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, health INT DEFAULT NULL, max_health INT DEFAULT NULL, str INT NOT NULL, wis INT NOT NULL, dex INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scenario (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(1023) DEFAULT NULL, gm VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scenario_mycharacter (scenario_id INT NOT NULL, mycharacter_id INT NOT NULL, INDEX IDX_EEF8B66E04E49DF (scenario_id), INDEX IDX_EEF8B66BD1E88C3 (mycharacter_id), PRIMARY KEY(scenario_id, mycharacter_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weapon (id INT AUTO_INCREMENT NOT NULL, fk_mycharacter_id INT DEFAULT NULL, name VARCHAR(64) NOT NULL, damage INT DEFAULT NULL, INDEX IDX_6933A7E6C810612A (fk_mycharacter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE scenario_mycharacter ADD CONSTRAINT FK_EEF8B66E04E49DF FOREIGN KEY (scenario_id) REFERENCES scenario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE scenario_mycharacter ADD CONSTRAINT FK_EEF8B66BD1E88C3 FOREIGN KEY (mycharacter_id) REFERENCES mycharacter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE weapon ADD CONSTRAINT FK_6933A7E6C810612A FOREIGN KEY (fk_mycharacter_id) REFERENCES mycharacter (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE scenario_mycharacter DROP FOREIGN KEY FK_EEF8B66BD1E88C3');
        $this->addSql('ALTER TABLE weapon DROP FOREIGN KEY FK_6933A7E6C810612A');
        $this->addSql('ALTER TABLE scenario_mycharacter DROP FOREIGN KEY FK_EEF8B66E04E49DF');
        $this->addSql('DROP TABLE mycharacter');
        $this->addSql('DROP TABLE scenario');
        $this->addSql('DROP TABLE scenario_mycharacter');
        $this->addSql('DROP TABLE weapon');
    }
}
