#/bin/bash
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password Big@1'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password Big@1'
sudo apt-get -y install mysql-server mysql-client mysql-workbench libmysqld-dev;
sudo apt-get -y install apache2 php5 libapache2-mod-php5 php5-mcrypt;
sudo service apache2 restart;

sudo apt-get install firewalld
sudo firewall-cmd --permanent --zone=public --add-service=http
sudo firewall-cmd --permanent --zone=public --add-service=https
sudo firewall-cmd --reload

sudo git clone https://github.com/JeenQ/Video_Archive_Web_Service.git

sudo cp -r Video_Archive_Web_Service/archive /var/www/html
sudo cp -r Video_Archive_Web_Service/image /var/www/html
sudo cp -r Video_Archive_Web_Service/resources /var/www/html
sudo cp -r Video_Archive_Web_Service/index.html /var/www/html
sudo cp -r Video_Archive_Web_Service/php.ini /etc/php5/apache2/php.ini
sudo mkdir -p /var/www/html/video
sudo mkdir -p /var/www/html/file
sudo chmod 777 /var/www/html/video
sudo chmod 777 /var/www/html/file

mysql -uroot -pBig@1 -e "DROP DATABASE IF EXISTS archive_db"
mysql -uroot -pBig@1 -e "CREATE DATABASE archive_db"
mysql -uroot -pBig@1 archive_db < Video_Archive_Web_Service/archive_db.sql
sudo rm -rf Video_Archive_Web_Service
