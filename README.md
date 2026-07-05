# SCARA ALFA - Installation Guide

This project is a Laravel 13 + Filament application.

## Requirements

- Linux server (Ubuntu 24.04 recommended)
- PHP 8.3+
- Composer 2+
- MySQL 8+
- Node.js 22+ and npm
- Nginx

Required PHP extensions:

- mbstring
- xml
- curl
- zip
- bcmath
- gd
- intl
- pdo_mysql
- redis (recommended)

## 1. Install System Packages (Ubuntu)

```bash
sudo apt update
sudo apt install -y nginx mysql-server git unzip curl

sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y \
  php8.3-fpm php8.3-cli php8.3-mysql php8.3-mbstring php8.3-xml \
  php8.3-curl php8.3-zip php8.3-bcmath php8.3-gd php8.3-intl php8.3-redis

curl -fsSL https://deb.nodesource.com/setup_22.x | sudo -E bash -
sudo apt install -y nodejs

curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

## 2. Clone Project

```bash
cd /var/www
sudo git clone <YOUR_REPOSITORY_URL> scara-alfa
sudo chown -R $USER:$USER /var/www/scara-alfa
cd /var/www/scara-alfa
```

## 3. Install Project Dependencies

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

## 4. Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=scra_classroom
DB_USERNAME=scara_user
DB_PASSWORD=your_strong_password
```

## 5. Create Database

```bash
sudo mysql
```

Run in MySQL shell:

```sql
CREATE DATABASE scra_classroom CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'scara_user'@'127.0.0.1' IDENTIFIED BY 'your_strong_password';
GRANT ALL PRIVILEGES ON scra_classroom.* TO 'scara_user'@'127.0.0.1';
FLUSH PRIVILEGES;
EXIT;
```

## 6. Migrate and Optimize

```bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 7. Set Folder Permissions

```bash
sudo chown -R www-data:www-data /var/www/scara-alfa
sudo find /var/www/scara-alfa/storage -type d -exec chmod 775 {} \;
sudo find /var/www/scara-alfa/bootstrap/cache -type d -exec chmod 775 {} \;
```

## 8. Configure Nginx

Create `/etc/nginx/sites-available/scara-alfa`:

```nginx
server {
	listen 80;
	server_name your-domain.com www.your-domain.com;
	root /var/www/scara-alfa/public;

	index index.php index.html;
	charset utf-8;

	location / {
		try_files $uri $uri/ /index.php?$query_string;
	}

	location = /favicon.ico { access_log off; log_not_found off; }
	location = /robots.txt  { access_log off; log_not_found off; }

	error_page 404 /index.php;

	location ~ \.php$ {
		include snippets/fastcgi-php.conf;
		fastcgi_pass unix:/run/php/php8.3-fpm.sock;
	}

	location ~ /\.(?!well-known).* {
		deny all;
	}
}
```

Enable site:

```bash
sudo ln -s /etc/nginx/sites-available/scara-alfa /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

## 9. Run Queue Worker (systemd)

This app uses `QUEUE_CONNECTION=database`, so queue worker should run continuously.

Create `/etc/systemd/system/scara-queue.service`:

```ini
[Unit]
Description=Scara Laravel Queue Worker
After=network.target

[Service]
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php /var/www/scara-alfa/artisan queue:work --sleep=3 --tries=3 --max-time=3600
WorkingDirectory=/var/www/scara-alfa

[Install]
WantedBy=multi-user.target
```

Enable service:

```bash
sudo systemctl daemon-reload
sudo systemctl enable --now scara-queue
```

## 10. Add Laravel Scheduler Cron

```bash
sudo crontab -e
```

Add this line:

```cron
* * * * * cd /var/www/scara-alfa && php artisan schedule:run >> /dev/null 2>&1
```

## 11. Optional: Enable HTTPS

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d your-domain.com -d www.your-domain.com
```

## Local Development

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run dev
php artisan serve
```

## Useful Commands

```bash
# Check queue worker
sudo systemctl status scara-queue

# Restart queue worker after deploy
sudo systemctl restart scara-queue

# Laravel cache reset
php artisan optimize:clear
```

## Notes

- If you deploy updates, run: `git pull`, `composer install --no-dev`, `npm run build`, `php artisan migrate --force`.
- If using Filament admin, ensure your first admin user exists in database.
