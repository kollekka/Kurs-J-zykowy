@echo off
setlocal enabledelayedexpansion



REM 

set "PG_BIN_PATH=C:\Program Files\PostgreSQL\17\bin"
set "PG_ADMIN_USER=postgres"
set "PG_ADMIN_PASS=postgres"
set "DB_NAME=Kursy"
set "DB_USER=postgres"
set "DB_PASS=postgres"

set "LARAVEL_URL=http://127.0.0.1:8000/main"

cls
echo.

set "PATH=%PG_BIN_PATH%;%PATH%"
set "PGPASSWORD=%PG_ADMIN_PASS%"

echo Sprawdzanie narzedzi PostgreSQL...
if not exist "%PG_BIN_PATH%\createdb.exe" (
    echo BLAD: Nie znaleziono narzedzi PostgreSQL w sciezce: %PG_BIN_PATH%
    goto :blad
)

echo Tworzenie bazy danych '%DB_NAME%' (usuwanie, jesli istnieje)...
dropdb.exe --host=localhost --port=5432 --username=%PG_ADMIN_USER% --if-exists "%DB_NAME%" >nul 2>&1
createdb.exe --host=localhost --port=5432 --username=%PG_ADMIN_USER% --owner=%DB_USER% --encoding=UTF8 "%DB_NAME%"

if errorlevel 1 (
    echo BLAD: Wystapil problem podczas tworzenia bazy danych.
    echo Sprawdz haslo uzytkownika '%PG_ADMIN_USER%' i logi serwera PostgreSQL.
    goto :blad
)

echo SUKCES: Baza danych '%DB_NAME%' zostala przygotowana.
echo.

echo.
echo [CZESC 2 z 2] Konfiguracja aplikacji PHP/Laravel...
echo ----------------------------------------------------------

if not exist "vendor" (
    composer update
    if errorlevel 1 (echo BLAD: Composer install zakonczyl sie niepowodzeniem. & goto :blad)
) else (
    echo Folder vendor juz istnieje, pomijam composer install.
)
echo.


if not exist .env.example (echo BLAD: Brak pliku .env.example! & goto :blad)
copy .env.example .env 
echo.


php artisan key:generate
IF ERRORLEVEL 1 (
    ECHO BŁĄD: Generowanie klucza nie powiodło się
    pause
    GOTO EndScript
)
ECHO OK: Klucz aplikacji wygenerowany


powershell -Command "(gc .env) -replace 'DB_CONNECTION=.*', 'DB_CONNECTION=pgsql' | sc .env"
powershell -Command "(gc .env) -replace '# DB_HOST=.*', 'DB_HOST=127.0.0.1' | sc .env"
powershell -Command "(gc .env) -replace '# DB_PORT=.*', 'DB_PORT=5432' | sc .env"
powershell -Command "(gc .env) -replace '# DB_DATABASE=.*', 'DB_DATABASE=%DB_NAME%' | sc .env"
powershell -Command "(gc .env) -replace '# DB_USERNAME=.*', 'DB_USERNAME=%DB_USER%' | sc .env"
powershell -Command "(gc .env) -replace '# DB_PASSWORD=.*', 'DB_PASSWORD=%DB_PASS%' | sc .env"
echo SUKCES: Plik .env zaktualizowany.
echo.

php artisan migrate:fresh --seed --force
if errorlevel 1 (echo BLAD: Migracje lub seedy zakonczyly sie niepowodzeniem. & goto :blad)
echo SUKCES: Migracje i seedy zakonczone.
echo.

echo.
start "" "%LARAVEL_URL%"
php artisan serve

goto :koniec

:blad

echo #  WYSTAPIL KRYTYCZNY BLAD. PRZERWANO DZIALANIE.   #

:koniec
endlocal
echo.
pause