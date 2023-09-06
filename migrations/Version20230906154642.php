<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230906154642 extends AbstractMigration
{

    public function getDescription(): string
    {
        return '';
    }


    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(80) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, trick_id INT NOT NULL, user_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9474526CB281BE2E (trick_id), INDEX IDX_9474526CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(80) NOT NULL, slug VARCHAR(80) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_D8F0A91E5E237E06 (name), UNIQUE INDEX UNIQ_D8F0A91E989D9B62 (slug), INDEX IDX_D8F0A91E12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick_picture (id INT AUTO_INCREMENT NOT NULL, trick_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL, INDEX IDX_758636D1B281BE2E (trick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick_video (id INT AUTO_INCREMENT NOT NULL, trick_id INT NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_B7E8DA93B281BE2E (trick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(80) NOT NULL, email VARCHAR(255) NOT NULL, media VARCHAR(80) NOT NULL, password VARCHAR(255) NOT NULL, token VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_registered TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE trick_picture ADD CONSTRAINT FK_758636D1B281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('ALTER TABLE trick_video ADD CONSTRAINT FK_B7E8DA93B281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
    }


    public function postUp(Schema $schema): void
    {
//        $trickData = [
//            [
//                'name' => 'mute',
//                'slug' => 'mute',
//                'description' => 'saisie de la carre frontside de la planche entre les deux pieds avec la main avant.'
//            ],
//            [
//                'name' => 'sad',
//                'slug' => 'sad',
//                'description' => 'saisie de la carre backside de la planche, entre les deux pieds, avec la main avant.'
//            ],
//            [
//                'name' => 'indy',
//                'slug' => 'indy',
//                'description' => 'saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière.'
//            ],
//            [
//                'name' => 'stalefish',
//                'slug' => 'stalefish',
//                'description' => 'saisie de la carre backside de la planche entre les deux pieds avec la main arrière.'
//            ],
//            [
//                'name' => 'tail grab',
//                'slug' => 'tail-grab',
//                'description' => 'saisie de la partie arrière de la planche, avec la main arrière.'
//            ],
//            [
//                'name' => 'nose grab',
//                'slug' => 'nose-grab',
//                'description' => 'saisie de la partie avant de la planche, avec la main avant'
//            ],
//            [
//                'name' => 'japan',
//                'slug' => 'japan',
//                'description' => 'saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside'
//            ],
//            [
//                'name' => 'seat belt',
//                'slug' => 'seat-belt',
//                'description' => 'saisie du carre frontside à l\'arrière avec la main avant.'
//            ],
//            [
//                'name' => 'truck driver',
//                'slug' => 'truck-driver',
//                'description' => 'saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture)'
//            ],
//            [
//                'name' => '270',
//                'slug' => '270',
//                'description' => 'trois quarts de tours'
//            ],
//            [
//                'name' => '360',
//                'slug' => '360',
//                'description' => 'trois six pour un tour complet'
//            ],
//            [
//                'name' => '540',
//                'slug' => '540',
//                'description' => 'cinq quatre pour un tour et demi'
//            ],
//            [
//                'name' => '630',
//                'slug' => '630',
//                'description' => 'un tour trois quarts'
//            ],
//            [
//                'name' => '720',
//                'slug' => '720',
//                'description' => 'sept deux pour deux tours complets'
//            ],
//            14 => [
//                'name' => '1080',
//                'slug' => '1080',
//                'description' => 'big foot pour trois tours'
//            ],
//            15 => [
//                'name' => 'front flips',
//                'slug' => 'front-flips',
//                'description' => 'rotations en avant'
//            ],
//            16 => [
//                'name' => 'back flips',
//                'slug' => 'back-flips',
//                'description' => 'rotations en arrière'
//            ],
//            17 => [
//                'name' => 'Mac Twist',
//                'slug' => 'Mac-Twist',
//                'description' => 'flips agrémentés d\'une vrille'
//            ],
//            18 => [
//                'name' => 'nose slide',
//                'slug' => 'nose-slide',
//                'description' => 'c\'est-à-dire slider avec l\'avant de la planche sur la barre'
//            ],
//            19 => [
//                'name' => 'tail slide',
//                'slug' => 'tail-slide',
//                'description' => 'c\'est-à-dire slider avec l\'arrière de la planche sur la barre'
//            ],
//        ];

        $names = ['Grab', 'Rotation', 'Flip', 'Slide'];
        foreach ($names as $label) {
            $this->connection->insert('category', [
                'label' => $label
            ]);
        }

//        foreach ($trickData as $item) {
//            $this->connection->insert('trick',$item);
//        }
        parent::postUp($schema); // TODO: Change the autogenerated stub
    }


    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CB281BE2E');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91E12469DE2');
        $this->addSql('ALTER TABLE trick_picture DROP FOREIGN KEY FK_758636D1B281BE2E');
        $this->addSql('ALTER TABLE trick_video DROP FOREIGN KEY FK_B7E8DA93B281BE2E');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE trick');
        $this->addSql('DROP TABLE trick_picture');
        $this->addSql('DROP TABLE trick_video');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }


}
