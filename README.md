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

##DNS on Mac OSX

```
  brew install dnsmasq
  cp /usr/local/opt/dnsmasq/dnsmasq.conf.example /usr/local/etc/dnsmasq.conf
  sudo cp -fv /usr/local/opt/dnsmasq/*.plist /Library/LaunchDaemons
  (^OR)
  ln -sfv /usr/local/opt/dnsmasq/*.plist /Library/LaunchDaemons
  cp /usr/local/opt/dnsmasq/dnsmasq.conf.example /usr/local/etc/dnsmasq.conf
  nano /usr/local/etc/dnsmasq.conf
```
add the following

```
  address=/.luxblox.dev/127.0.0.1
  address=/.lux.local/127.0.0.1
```

create the following

```
 sudo nano /etc/resolver/luxblox.dev
```

with the contents

```
   sudo tee /etc/resolver/luxblox.dev >/dev/null <<EOF
   nameserver 127.0.0.1
   EOF
```

**DNS Control** using the following ( from [this guide](http://asciithoughts.com/posts/2014/02/23/setting-up-a-wildcard-dns-domain-on-mac-os-x/) )

```
  sudo launchctl unload /Library/LaunchDaemons/homebrew.mxcl.dnsmasq.plist
  sudo launchctl load /Library/LaunchDaemons/homebrew.mxcl.dnsmasq.plist  
```

I found this works for .htaccess file at top-level (redirects plagued me until I removed the line that added a forward-slash to wp-admin)

```
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} -f [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^ - [L]
RewriteRule ^(wp-(admin|includes|snapshots).*) wp/$1 [L]
RewriteRule ^(.*\.php)$ wp/$1 [L]
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
```

## Relocating the site

Use this in wp-config.php when relocating the site, see https://codex.wordpress.org/Changing_The_Site_URL

```
  define('RELOCATE',true);
```

When doing the above and changing the URLs directly in the database, you will come across instances of the URL being located in the "guid" column in the wp_posts tables.

**It is critical that you do NOT change the contents of this field.**

Generate and install an API key for X theme under a new domain here
https://theme.co/community/users/ceekayel/licenses/

## Defining the home page

https://developer.wordpress.org/themes/basics/template-hierarchy/