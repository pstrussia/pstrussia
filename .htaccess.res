Options -Indexes 
ErrorDocument 404 /404.php

<IfModule mod_php5.c>
  php_flag session.use_trans_sid off
  #php_value display_errors 1
  #php_value mbstring.internal_encoding UTF-8
  php_value register_globals off
  php_value max_input_vars 10000
  #php_value error_reporting E_ALL
</IfModule>

<IfModule mod_rewrite.c>
  Options +FollowSymLinks
  RewriteEngine On
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-l
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteCond %{REQUEST_FILENAME} !/bitrix/urlrewrite.php$
  RewriteRule ^(.*)$ /bitrix/urlrewrite.php [L]
  RewriteRule .* - [E=REMOTE_USER:%{HTTP:Authorization}]
</IfModule>

<IfModule mod_dir.c>
  DirectoryIndex index.php index.html
</IfModule>

<IfModule mod_expires.c>
  ExpiresActive on
  ExpiresByType image/jpeg "access plus 3 day"
  ExpiresByType image/gif "access plus 3 day"
  ExpiresByType image/png "access plus 3 day"
  ExpiresByType text/css "access plus 3 day"
  ExpiresByType application/javascript "access plus 3 day"  
</IfModule>
