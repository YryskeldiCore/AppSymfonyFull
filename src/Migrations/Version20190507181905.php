<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190507181905 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE privileges ADD bid_list TINYINT(1) NOT NULL, ADD bid_get_waiting TINYINT(1) NOT NULL, ADD bid_get_accepted TINYINT(1) NOT NULL, ADD bid_get_called TINYINT(1) NOT NULL, ADD bid_get_rejected TINYINT(1) NOT NULL, ADD bid_get_confirmed TINYINT(1) NOT NULL, ADD bid_get_postponed TINYINT(1) NOT NULL, ADD bid_create TINYINT(1) NOT NULL, ADD bid_call TINYINT(1) NOT NULL, ADD bid_accept TINYINT(1) NOT NULL, ADD bid_reject TINYINT(1) NOT NULL, ADD bid_postponed TINYINT(1) NOT NULL, ADD bid_confirm TINYINT(1) NOT NULL, DROP login_to_dashboard, DROP call_bid, DROP reject_bid, DROP accept_bid, DROP postpone_bid, DROP confirm_bid');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE privileges ADD login_to_dashboard TINYINT(1) NOT NULL, ADD call_bid TINYINT(1) NOT NULL, ADD reject_bid TINYINT(1) NOT NULL, ADD accept_bid TINYINT(1) NOT NULL, ADD postpone_bid TINYINT(1) NOT NULL, ADD confirm_bid TINYINT(1) NOT NULL, DROP bid_list, DROP bid_get_waiting, DROP bid_get_accepted, DROP bid_get_called, DROP bid_get_rejected, DROP bid_get_confirmed, DROP bid_get_postponed, DROP bid_create, DROP bid_call, DROP bid_accept, DROP bid_reject, DROP bid_postponed, DROP bid_confirm');
    }
}
