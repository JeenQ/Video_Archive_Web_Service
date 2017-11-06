@echo off
REM git clone
REM call git clone https://github.com/JeenQ/Video_Archive_Web_Service.git

REM install bitnami
powershell "(new-object Net.WebClient).DownloadFile('https://bitnami.com/redirect/to/163844/bitnami-wampstack-5.6.32-0-windows-x64-installer.exe', 'bitnami-wampstack-5.6.32-0-windows-x64-installer.exe')"
bitnami-wampstack-5.6.32-0-windows-x64-installer.exe

REM Open TCP Port 80 inbound and outbound
netsh advfirewall firewall add rule name="Zoo TCP Port 80" dir=in action=allow protocol=TCP localport=80
netsh advfirewall firewall add rule name="Zoo TCP Port 80" dir=out action=allow protocol=TCP localport=80

REM set file directory
mkdir C:\Bitnami\wampstack-5.6.32-0\apache2\htdocs\archive
xcopy archive C:\Bitnami\wampstack-5.6.32-0\apache2\htdocs\archive /e /h /k
mkdir C:\Bitnami\wampstack-5.6.32-0\apache2\htdocs\image
xcopy image C:\Bitnami\wampstack-5.6.32-0\apache2\htdocs\image /e /h /k
mkdir C:\Bitnami\wampstack-5.6.32-0\apache2\htdocs\resources
xcopy resources C:\Bitnami\wampstack-5.6.32-0\apache2\htdocs\resources /e /h /k
copy index.html C:\Bitnami\wampstack-5.6.32-0\apache2\htdocs\index.html
copy php.ini C:\Bitnami\wampstack-5.6.32-0\php\php.ini
mkdir C:\Bitnami\wampstack-5.6.32-0\apache2\htdocs\video
mkdir C:\Bitnami\wampstack-5.6.32-0\apache2\htdocs\file

REM DB initialization
set path=%path%;C:\Bitnami\wampstack-5.6.32-0\mysql\bin;
mysqladmin -uroot -p123456 password Big@1
net stop wampstackMySQL
net start wampstackMySQL
mysql -uroot -pBig@1 -e "DROP DATABASE IF EXISTS archive_db"
mysql -uroot -pBig@1 -e "CREATE DATABASE archive_db"
mysql -uroot -pBig@1 archive_db < archive_db.sql

REM src remove
REM rd /s /q Video_Archive_Web_Service

pause
