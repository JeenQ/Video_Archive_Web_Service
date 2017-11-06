@echo off

REM Open TCP Port 80 inbound and outbound
netsh advfirewall firewall add rule name="Zoo TCP Port 80" dir=in action=allow protocol=TCP localport=80
netsh advfirewall firewall add rule name="Zoo TCP Port 80" dir=out action=allow protocol=TCP localport=80

REM DB initialization
set path=%path%;C:\Bitnami\wampstack-5.6.32-0\mysql\bin;
mysqladmin -uroot -p123456 password Big@1
net stop wampstackMySQL
net start wampstackMySQL