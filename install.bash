# Before running this installation command please:
# 1. Create a new .env file from .env.example
# 2. Setup a new database and add details to .env

echo "Installing Lumen Coding Challenge";
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
