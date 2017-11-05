@echo off
REM git clone
call git clone https://github.com/JeenQ/Video_Archive_Web_Service.git

REM 비트나미 설치
powershell "(new-object Net.WebClient).DownloadFile('https://bitnami.com/redirect/to/163357/bitnami-wampstack-7.1.10-1-windows-x64-installer.exe?with_popup_skip_signin=1', 'Video_Archive_Web_Service/bitnami-wampstack-7.1.10-1-windows-x64-installer.exe')"
Video_Archive_Web_Service\bitnami-wampstack-7.1.10-1-windows-x64-installer.exe

REM Open TCP Port 80 inbound and outbound
netsh advfirewall firewall add rule name="Zoo TCP Port 80" dir=in action=allow protocol=TCP localport=80
netsh advfirewall firewall add rule name="Zoo TCP Port 80" dir=out action=allow protocol=TCP localport=80

REM 파일 경로 설정
mkdir C:\Bitnami\wampstack-7.1.10-1\apache2\htdocs\archive
xcopy Video_Archive_Web_Service\archive C:\Bitnami\wampstack-7.1.10-1\apache2\htdocs\archive /e /h /k
mkdir C:\Bitnami\wampstack-7.1.10-1\apache2\htdocs\image
xcopy Video_Archive_Web_Service\image C:\Bitnami\wampstack-7.1.10-1\apache2\htdocs\image /e /h /k
mkdir C:\Bitnami\wampstack-7.1.10-1\apache2\htdocs\resources
xcopy Video_Archive_Web_Service\resources C:\Bitnami\wampstack-7.1.10-1\apache2\htdocs\resources /e /h /k
copy Video_Archive_Web_Service\index.html C:\Bitnami\wampstack-7.1.10-1\apache2\htdocs\index.html
copy Video_Archive_Web_Service\php.ini C:\Bitnami\wampstack-7.1.10-1\php\php.ini
mkdir C:\Bitnami\wampstack-7.1.10-1\apache2\htdocs\video
mkdir C:\Bitnami\wampstack-7.1.10-1\apache2\htdocs\file

REM DB 초기화
set path=%path%;C:\Bitnami\wampstack-7.1.10-1\mysql\bin;
mysql -uroot -pBig@1 -e "update mysql.user set authentication_string=password('Big@1') where user='root'"
mysql -uroot -pBig@1 -e "DROP DATABASE IF EXISTS archive_db"
mysql -uroot -pBig@1 -e "CREATE DATABASE archive_db"
mysql -uroot -pBig@1 archive_db < Video_Archive_Web_Service/archive_db.sql

REM 소스 폴더 삭제
rd /s /q Video_Archive_Web_Service

pause