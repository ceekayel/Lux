## General Overview

This is the Lux Blox website project which includes wordpress and 
several themes and plugins

The main page 'X theme' requires the following plugin: Cornerstone

and it recommends the following plugins: 
  * Content Dock
  * Custom 404 Disqus Comments
  * Email Forms (MailChimp)
  * Facebook Comments
  * Google Analytics
  * Olark Integration
  * Smooth Scroll
  * Terms of Use
  * Under Construction
  * Video Lock
  * Visual Composer
  * White Label
  
The following plugin needs to be updated to its latest version to ensure maximum 
compatibility with this theme: Soliloquy

##Database

```
CREATE USER 'lux'@'localhost' IDENTIFIED BY PASSWORD '*665ADFA36435490D997F17246EF5B4D3D78BA5B2'; 
GRANT USAGE ON *.* TO 'lux'@'localhost' IDENTIFIED BY PASSWORD '*665ADFA36435490D997F17246EF5B4D3D78BA5B2' REQUIRE NONE; 
GRANT ALL PRIVILEGES ON `wp_lux`.* TO 'lux'@'localhost' WITH GRANT OPTION;
GRANT USAGE ON *.* TO 'lux'@'lux.local' IDENTIFIED BY PASSWORD '*665ADFA36435490D997F17246EF5B4D3D78BA5B2';
GRANT ALL PRIVILEGES ON `wp_lux`.* TO 'lux'@'lux.local' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON `wp_lux`.* TO 'lux'@'%' WITH GRANT OPTION;
```

##Debugging

```
wget https://phar.phpunit.de/phpunit.phar
chmod +x phpunit.phar
sudo mv phpunit.phar /usr/local/bin/PHHPUnit
```

then add /usr/local/bin/PHPUnit to include_path in /Applications/MAMP/bin/php/php5.6.10/conf/php.ini

Current version is 4.8.5 (note there is an older version of phpunit (lowercase) in MAMP)
