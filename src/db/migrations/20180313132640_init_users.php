<?php


use Phinx\Migration\AbstractMigration;

class InitUsers extends AbstractMigration
{
    public function up()
    {
        $this->execute(file_get_contents('https://raw.githubusercontent.com/delight-im/PHP-Auth/master/Database/MySQL.sql'));
    }

    public function down()
    {
        $this->dropTable('users');
        $this->dropTable('users_confirmations');
        $this->dropTable('users_remembered');
        $this->dropTable('users_resets');
        $this->dropTable('users_throttling');
    }
}
