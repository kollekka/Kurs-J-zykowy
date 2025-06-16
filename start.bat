@echo off

cd /d "%~dp0"

if not exist ".env" (
    copy ".env.example" ".env"
)

composer install --no-interaction --prefer-dist --optimize-autoloader
if %errorlevel% neq 0 (
    echo [BLAD] Instalacja Composer nie powiodla sie. Sprawdz bledy i czy Composer jest poprawnie zainstalowany.
    pause
    goto :eof
)

php artisan key:generate
if %errorlevel% neq 0 (
    echo [BLAD] Generowanie klucza aplikacji nie powiodlo sie. Sprawdz plik .env i konfiguracje PHP.
    pause
    goto :eof
)

php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear


php artisan migrate --force
if %errorlevel% neq 0 (
    echo [BLAD] Migracje bazy danych nie powiodly sie.
    pause
    goto :eof
)


php artisan db:seed --force
if %errorlevel% neq 0 (
    echo [OSTRZEZENIE] Zasilanie bazy danych (seeding) nie powiodlo sie. Moze to byc w porzadku, jesli nie masz seederow lub sa opcjonalne.
    pause
)

php artisan config:cache
php artisan route:cache
php artisan view:cache

echo  Konfiguracja Projektu Laravel Zakonczona Pomyslnie!
pause
:eof