<?php


use Phinx\Migration\AbstractMigration;

class InitUsers extends AbstractMigration
{
    public function up()
    {
        $this->execute("        
			CREATE TABLE `users` (
			  `id` int(11) NOT NULL,
			  `username` varchar(128) NOT NULL,
			  `pass_hash` varchar(128) NOT NULL,
			  `email` varchar(512) NOT NULL,
			  `reset_hash` varchar(40) DEFAULT NULL,
			  `reset_hash_date` datetime DEFAULT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
			
			ALTER TABLE `users`
			  ADD PRIMARY KEY (`id`),
			  ADD UNIQUE KEY `username` (`username`),
			  ADD UNIQUE KEY `email` (`email`);      
        ");
    }

    public function down()
    {
        $this->dropTable('users');
    }
}
