@echo off
echo Starting Motor Rental Application...
echo.
start cmd /k "cd /d %~dp0 && php artisan serve"
start cmd /k "cd /d %~dp0 && python app/forecasting_api.py"
echo Laravel  : http://127.0.0.1:8000
echo Flask API : http://127.0.0.1:5000
echo.
pause
