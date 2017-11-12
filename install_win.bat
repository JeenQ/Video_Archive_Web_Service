@echo off

REM install bitnami
echo install start
echo install bitnami
powershell "(new-object Net.WebClient).DownloadFile('https://bitnami.com/redirect/to/163844/bitnami-wampstack-5.6.32-0-windows-x64-installer.exe', 'install\bitnami-wampstack-5.6.32-0-windows-x64-installer.exe')"
install\bitnami-wampstack-5.6.32-0-windows-x64-installer.exe

REM set file directory
mkdir C:\Bitnami\wampstack-5.6.32-0\apache2\htdocs\archive
xcopy archive C:\Bitnami\wampstack-5.6.32-0\apache2\htdocs\archive /e /h /k
mkdir C:\Bitnami\wampstack-5.6.32-0\apache2\htdocs\image
xcopy image C:\Bitnami\wampstack-5.6.32-0\apache2\htdocs\image /e /h /k
mkdir C:\Bitnami\wampstack-5.6.32-0\apache2\htdocs\resources
xcopy resources C:\Bitnami\wampstack-5.6.32-0\apache2\htdocs\resources /e /h /k
copy index.html C:\Bitnami\wampstack-5.6.32-0\apache2\htdocs\index.html
copy install\php.ini C:\Bitnami\wampstack-5.6.32-0\php\php.ini
copy install\httpd.conf C:\Bitnami\wampstack-5.6.32-0\apache2\conf\httpd.conf
echo d | xcopy video C:\Bitnami\wampstack-5.6.32-0\apache2\htdocs\video /e /h /k
echo d | xcopy file C:\Bitnami\wampstack-5.6.32-0\apache2\htdocs\file /e /h /k

REM DB initialization
set path=%path%;C:\Bitnami\wampstack-5.6.32-0\mysql\bin;
mysqladmin -uroot -p123456 password Big@1

REM admin mode configuration
"install\install_win_admin.bat_.lnk"

REM create DB table
mysql -uroot -pBig@1 -e "DROP DATABASE IF EXISTS archive_db"
mysql -uroot -pBig@1 -e "CREATE DATABASE archive_db"
mysql -uroot -pBig@1 archive_db < install\archive_db.sql

echo install finish
pause