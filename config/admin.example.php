<?php
// config/admin.example.php
// TEMPLATE — copy to config/admin.php and fill in your values.
// Never commit config/admin.php to git.
//
// To generate a password hash, run in PHP:
//   echo password_hash('your_password_here', PASSWORD_BCRYPT);

define('ADMIN_USERNAME', 'your_username_here');
define('ADMIN_PASSWORD_HASH', 'your_bcrypt_hash_here');
define('ADMIN_SESSION_LIFETIME', 86400);