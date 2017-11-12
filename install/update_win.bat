@echo off

echo update start
echo.

echo a | xcopy archive C:\Bitnami\wampstack-5.6.32-0\apache2\htdocs\archive /e /h /k
copy index.html C:\Bitnami\wampstack-5.6.32-0\apache2\htdocs\index.html

echo update complete
ipconfig
echo.
echo IPv4_address/index.html
echo.
pause