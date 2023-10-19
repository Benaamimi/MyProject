<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231019174826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blogpost ADD CONSTRAINT FK_1284FB7DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCC2E869AB FOREIGN KEY (peinture_id) REFERENCES peinture (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC27F5416E FOREIGN KEY (blogpost_id) REFERENCES blogpost (id)');
        $this->addSql('ALTER TABLE peinture ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE peinture ADD CONSTRAINT FK_8FB3A9D6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8FB3A9D6A76ED395 ON peinture (user_id)');
        $this->addSql('ALTER TABLE peinture_categorie ADD CONSTRAINT FK_38CEF7CFBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blogpost DROP FOREIGN KEY FK_1284FB7DA76ED395');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCC2E869AB');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC27F5416E');
        $this->addSql('ALTER TABLE peinture DROP FOREIGN KEY FK_8FB3A9D6A76ED395');
        $this->addSql('DROP INDEX IDX_8FB3A9D6A76ED395 ON peinture');
        $this->addSql('ALTER TABLE peinture DROP user_id');
        $this->addSql('ALTER TABLE peinture_categorie DROP FOREIGN KEY FK_38CEF7CFBCF5E72D');
    }
}
