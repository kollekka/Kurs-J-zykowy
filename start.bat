@echo off
setlocal enabledelayedexpansion

:: ====================================================================================
:: SKRYPT v4 - NAJPIERW BAZA DANYCH, POTEM APLIKACJA PHP
:: ====================================================================================
::
:: KOLEJNOSC DZIALANIA:
:: CZESC 1: Tworzenie i konfiguracja bazy danych w PostgreSQL.
:: CZESC 2: Instalacja zaleznosci, konfiguracja .env i uruchomienie aplikacji Laravel.
::

REM ----------------- KONFIGURACJA -----------------
:: Sciezka do narzedzi PostgreSQL
set "PG_BIN_PATH=E:\PostgreSQL\bin"

:: Dane administratora PostgreSQL do TWORZENIA bazy
set "PG_ADMIN_USER=postgres"
set "PG_ADMIN_PASS=student"

:: Nazwa bazy danych, ktora zostanie utworzona i wpisana do .env
set "DB_NAME=Kursy"

:: Dane uzytkownika bazy danych, ktore zostana wpisane do .env
set "DB_USER=postgres"
set "DB_PASS=student"

:: Adres serwera Laravel
set "LARAVEL_URL=http://127.0.0.1:8000"
REM ----------------- KONIEC KONFIGURACJI -----------------

cls
echo ==========================================================
echo  START PROJEKTU: NAJPIERW BAZA, POTEM LARAVEL
echo ==========================================================
echo.

:: ##################################################################
:: # CZESC 1: OPERACJE NA BAZIE DANYCH
:: ##################################################################
echo.
echo [CZESC 1 z 2] Operacje na bazie danych...
echo ----------------------------------------------------------

:: Ustawienie zmiennych srodowiskowych dla PostgreSQL
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

:: ##################################################################
:: # CZESC 2: KONFIGURACJA APLIKACJI PHP/LARAVEL
:: ##################################################################
echo.
echo [CZESC 2 z 2] Konfiguracja aplikacji PHP/Laravel...
echo ----------------------------------------------------------

echo Krok 1/5: Instalowanie zaleznosci (composer install)...
if not exist "vendor" (
    composer install
    if errorlevel 1 (echo BLAD: Composer install zakonczyl sie niepowodzeniem. & goto :blad)
) else (
    echo Folder vendor juz istnieje, pomijam composer install.
)
echo.

echo Krok 2/5: Tworzenie pliku .env...
if not exist .env.example (echo BLAD: Brak pliku .env.example! & goto :blad)
copy .env.example .env 
echo.

echo Krok 3/5: Generowanie klucza aplikacji (APP_KEY)...
php artisan key:generate
if errorlevel 1 (echo BLAD: Nie udalo sie wygenerowac klucza aplikacji. Sprawdz uprawnienia! & goto :blad)
echo SUKCES: Klucz aplikacji wygenerowany.
echo.

echo Krok 4/5: Aktualizacja danych bazy w .env...
powershell -Command "(gc .env) -replace 'DB_CONNECTION=.*', 'DB_CONNECTION=pgsql' | sc .env"
powershell -Command "(gc .env) -replace 'DB_HOST=.*', 'DB_HOST=127.0.0.1' | sc .env"
powershell -Command "(gc .env) -replace 'DB_PORT=.*', 'DB_PORT=5432' | sc .env"
powershell -Command "(gc .env) -replace 'DB_DATABASE=.*', 'DB_DATABASE=%DB_NAME%' | sc .env"
powershell -Command "(gc .env) -replace 'DB_USERNAME=.*', 'DB_USERNAME=%DB_USER%' | sc .env"
powershell -Command "(gc .env) -replace 'DB_PASSWORD=.*', 'DB_PASSWORD=%DB_PASS%' | sc .env"
echo SUKCES: Plik .env zaktualizowany.
echo.

echo Krok 5/5: Uruchamianie migracji i seedow...
php artisan migrate --seed --force
if errorlevel 1 (echo BLAD: Migracje lub seedy zakonczyly sie niepowodzeniem. & goto :blad)
echo SUKCES: Migracje i seedy zakonczone.
echo.

:: --- URUCHOMIENIE APLIKACJI ---
echo ==========================================================
echo WSZYSTKO GOTOWE! Uruchamianie serwera...
echo Aplikacja bedzie dostepna pod adresem: %LARAVEL_URL%
echo ==========================================================
echo.
start "" "%LARAVEL_URL%"
php artisan serve

goto :koniec

:blad
echo.
echo #######################################################
echo #  WYSTAPIL KRYTYCZNY BLAD. PRZERWANO DZIALANIE.   #
echo #######################################################

:koniec
endlocal
echo.
pause