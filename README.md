# PKT-Backend

PKT backend for user management

## Installation
```bash
git clone https://github.com/Sachio-haise/Tall-Stack-Starter-Kit
```

## Usage
file copy
```bash
copy .env-example to .env
```
install library
```bash
composer install   
```
generate key
```bash
php artisan key:generate
```
for style running
```bash
npm install
```
```bash
npm run dev 
```
if you want to use docker install [Sail](https://laravel.com/docs/10.x/sail)
```bash
./vendor/bin/sail up -d
```

for migration
```bash
php artisan migrate:fresh --seed 
```

PHP storage link
```bash
php artisan storage:link
```
