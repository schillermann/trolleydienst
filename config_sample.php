<?php
/**
 * This is an example file.
 * Copy this file to "config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 */

/**
 * MySQL settings
 */
define('DATABASE_HOST', 'localhost');
define('DATABASE_NAME', 'database_name_here');
define('DATABASE_USER', 'username_here');
define('DATABASE_PASSWORD', 'password_here');

/**
 * E-Mail
 */
define('EMAIL_FROM_ADDRESS', 'example@adresse');
define('EMAIL_SUPPORT', 'example@adresse');

/**
 * General settings
 */
define('APPLICATION_NAME', 'Öffentliches Zeugnisgeben');
define('TEAM_NAME', 'Trolley Team');
define('CONGREGATION_NAME', 'congregation_name_here');
define('PARTICIPANTS_PER_SHIFT', 2);

/**
 * Server settings
 */
define('UPLOAD_SIZE_MAX_IN_MEGABYTE', '3');
ini_set("error_log", 'logs/php_errors.log');