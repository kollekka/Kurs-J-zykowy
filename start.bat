
composer install

php artisan storage:link

copy .env.example .env
php artisan key:generate

powershell -Command "(Get-Content .env) -replace 'DB_CONNECTION=sqlite', 'DB_CONNECTION=pgsql' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '# DB_HOST=127.0.0.1', 'DB_HOST=127.0.0.1' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '# DB_PORT=3306', 'DB_PORT=5432' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '# DB_DATABASE=laravel', 'DB_DATABASE=Kursy' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '# DB_USERNAME=root', 'DB_USERNAME=postgres' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '# DB_PASSWORD=', 'DB_PASSWORD=student' | Set-Content .env"

php artisan migrate

php artisan db:seed

php artisan serve

endlocal
:eof