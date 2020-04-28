<?php
$api = "websites.json";
$return = file_get_contents($api);
$domains = json_decode($return);

// Regular Domain
// --------------
$template = <<<TEMPLATE
<VirtualHost *:80>
ServerAdmin owen@bnbowners.com
DocumentRoot "/var/www/html/{folder}/public_html"
ServerName {domain}
ServerAlias www.{domain}
ErrorLog "/var/www/html/{folder}/logs/error_log"
CustomLog "/var/www/html/{folder}/logs/access_log" common
# AddType application/x-httpd-php .html
# php_flag log_errors on
# php_flag display_errors off
# php_value error_reporting 2147483647
# php_value error_log /var/www/html/{folder}/public_html/php.error.log
</VirtualHost>
TEMPLATE;

foreach($domains->domains AS $domain) {
  $replace = [
    '{domain}' => $domain->name,
    '{folder}' => $domain->folder
  ];
  echo strtr($template, $replace);
  echo chr(10).chr(10);
}

// Generate mkdor commands for easy copy and paste
// foreach($domains->domains AS $domain) {
//   $folder = "/var/www/html/{$domain->name}";
//   echo "mkdir {$folder} {$folder}/public_html {$folder}/logs";
//   echo chr(10);
// }