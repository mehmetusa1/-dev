@echo off
cd /d "%~dp0"
set "BLOG_PHP=php"
if exist "%USERPROFILE%\.config\herd\bin\php84\php.exe" set "BLOG_PHP=%USERPROFILE%\.config\herd\bin\php84\php.exe"
echo Blog adresi: http://127.0.0.1:8000
echo Durdurmak icin Ctrl+C kullanin.
"%BLOG_PHP%" artisan serve --host=127.0.0.1 --port=8000
pause
