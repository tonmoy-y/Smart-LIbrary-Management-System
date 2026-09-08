<?php
// Dev-only router for `php -S`, mirroring the app's .htaccess RewriteRule:
//   RewriteRule ^([a-zA-Z0-9_-]+)$ $1.php [L]
// so local testing matches how Apache serves clean URLs in production.
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . '/../' . ltrim($path, '/');

if ($path !== '/' && !is_file($file) && !is_dir($file)) {
    if (preg_match('#^/([a-zA-Z0-9_/-]+)$#', rtrim($path, '/'), $m)) {
        $candidate = realpath(__DIR__ . '/../' . $m[1] . '.php');
        if ($candidate) {
            // Apache/mod_php chdir()s to the script's own directory before running it,
            // which is what makes this app's "../whatever.php" relative includes work.
            // php -S does not do that on its own, so replicate it here.
            chdir(dirname($candidate));
            require $candidate;
            return true;
        }
    }
}

return false;
