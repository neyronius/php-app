<?php

error_reporting(-1);
ini_set('display_errors', '1');

define('APP_NAME', 'php-app');

define('URL', APP_NAME . '.vm');
define('ADMIN_EMAIL', 'webmaster@localhost');
define('VHOST_PATH', '/var/www/' . APP_NAME);

define('VHOST_DOCUMENT_ROOT', VHOST_PATH . '/src/public');
define('VHOST_FILE_NAME', '/etc/apache2/sites-available/' . APP_NAME . '.vm.conf');

define('DBNAME', 'phpapp');

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

if (!file_exists(VHOST_DOCUMENT_ROOT)
    && !mkdir(VHOST_DOCUMENT_ROOT, 0766, true)
    && !is_dir(VHOST_DOCUMENT_ROOT)) {
    die("Can't create directory " . VHOST_DOCUMENT_ROOT);
}

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