<?php

error_reporting(-1);
ini_set('display_errors', '1');

define('APP_NAME', 'php-app');

define('URL', APP_NAME . '.vm');
define('ADMIN_EMAIL', 'webmaster@localhost');
define('VHOST_PATH', '/var/www/' . APP_NAME);

define('VHOST_DOCUMENT_ROOT', VHOST_PATH . '/src/public');
define('VHOST_FILE_NAME', '/etc/apache2/sites-available/' . APP_NAME . '.vm.conf');
define('GIT_URL', 'https://github.com/neyronius/php-app.git');
define('COMPOSER_PATH', VHOST_PATH . '/src');

define('DBNAME', 'phpapp');

/**
 * Setup project
 */
function create()
{
    ob_start(); ?>
    <VirtualHost *:80>
        ServerName <?= URL ?>

        ServerAdmin <?= ADMIN_EMAIL ?>

        DocumentRoot <?= VHOST_DOCUMENT_ROOT ?>

        <Directory <?= VHOST_DOCUMENT_ROOT ?>/>
        AllowOverride All
        </Directory>

        ErrorLog <?= VHOST_PATH ?>/errors.log

        SetEnv PHP_VALUE "error_reporting=-1"
        SetEnv PHP_VALUE "display_errors=On"

        #<FilesMatch ".+\.ph(ar|p|tml)$">
        # SetHandler "proxy:unix:/run/php/php7.2-fpm.sock|fcgi://localhost"
        #</FilesMatch>

    </VirtualHost>
    <?php $vhost_content = ob_get_clean();

    echo "Creating virtual host directory" . PHP_EOL;

    echo shell_exec("sudo mkdir -p " . VHOST_DOCUMENT_ROOT);
    echo shell_exec("sudo chown vagrant:vagrant -R " . VHOST_PATH);

    echo shell_exec("find " . VHOST_PATH . " -type d -exec chmod 755 {} \;");
    echo shell_exec("find " . VHOST_PATH . " -type f -exec chmod 644 {} \;");

    echo 'Done' . PHP_EOL .  PHP_EOL;

    echo "Creating virtual host config file" . PHP_EOL;
    if (!file_put_contents(VHOST_FILE_NAME, $vhost_content)) {
        die("Can't create apache vhost");
    }
    echo 'Done' . PHP_EOL .  PHP_EOL;

    echo "Enabling website" . PHP_EOL;
    echo shell_exec('sudo a2ensite ' . basename(VHOST_FILE_NAME));
    echo 'Done' . PHP_EOL .  PHP_EOL;

    echo "Restart Apache" . PHP_EOL;
    echo shell_exec('sudo /etc/init.d/apache2 restart');
    echo 'Done' . PHP_EOL .  PHP_EOL;

    echo "Create database" . PHP_EOL;
    echo shell_exec('mysql --login-path=local -e "CREATE DATABASE IF NOT EXISTS ' . DBNAME . ' DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"');
    echo 'Done' . PHP_EOL .  PHP_EOL;


    echo "Cloning repo" . PHP_EOL;
    chdir(VHOST_PATH);
    echo shell_exec("git clone " . GIT_URL . ' .');
    echo 'Done' . PHP_EOL .  PHP_EOL;

    echo "Install dependencies" . PHP_EOL;
    chdir(COMPOSER_PATH);
    echo shell_exec("composer install");
    echo 'Done' . PHP_EOL .  PHP_EOL;
}

/**
 * Destroy project
 */
function destroy()
{
    echo "Disabling website" . PHP_EOL;
    echo shell_exec('sudo a2dissite ' . basename(VHOST_FILE_NAME));
    echo shell_exec("sudo rm -rf " . VHOST_FILE_NAME);
    echo 'Done' . PHP_EOL .  PHP_EOL;

    echo "Remove folder" . PHP_EOL;
    echo shell_exec("sudo rm -rf " . VHOST_PATH);
    echo 'Done' . PHP_EOL .  PHP_EOL;

    echo "Drop database" . PHP_EOL;
    echo shell_exec('mysql --login-path=local -e "DROP DATABASE  ' . DBNAME . ';"');
    echo 'Done' . PHP_EOL .  PHP_EOL;
}

if($argc > 1){
    $mode = $argv[1];

    if(!in_array($mode, ['create', 'destroy'])){
        die("Invalid command");
    }

    $mode();
}else{
    die("Using: sudo php setup.php command" . PHP_EOL . "Command: create or destroy" . PHP_EOL);
}