#!/bin/bash

# Ensure the script is run with superuser privileges
if [[ "$EUID" -ne 0 ]]; then
  echo "Please run as root or use sudo"
  exit 1
fi

# Function to pause for a specified duration
pause() {
    sleep $1
}

# Update package lists
apt update

# Install Apache
apt install -y apache2
pause 3
systemctl enable apache2.service
pause 3
systemctl status apache2 || { echo "Failed to get Apache status"; exit 1; }
pause 3

# Configure UFW
ufw enable
pause 3
ufw allow from 10.0.0.0/8 to any port 3306
pause 3
ufw allow in on eth0 to any port 80
pause 3
ufw allow 'Apache Full'
pause 3
ufw allow 'OpenSSH'
pause 3
ufw allow from any to any port 20,21,10000:10100 proto tcp
pause 3

# Install PHP
apt install -y php
pause 3
apt install -y libapache2-mod-php
pause 3
apt install -y php-mysql
pause 3
apt-cache search libapache2*
pause 3

# Install OpenSSH server
apt install -y openssh-server
pause 3
nano /etc/ssh/sshd_config
pause 3

# Install MariaDB
apt install -y mariadb-server
pause 3
systemctl start mariadb.service
pause 3
mysql_secure_installation
pause 3

# Secure MariaDB and create user/database
mysql <<EOF
ALTER USER 'root'@'localhost' IDENTIFIED WITH caching_sha2_password BY 'IMKuben1337!';
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'IMKuben1337!';
SELECT user,authentication_string,plugin,host FROM mysql.user;
CREATE USER 'alfmorten'@'localhost' IDENTIFIED WITH caching_sha2_password BY 'IMKuben1337!';
GRANT CREATE, ALTER, DROP, INSERT, UPDATE, DELETE, SELECT, REFERENCES, RELOAD on *.* TO 'alfmorten'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;
EOF
pause 3

# Check MySQL status
systemctl status mysql.service || { echo "Failed to get MySQL status"; exit 1; }
pause 3

# Create database
mysql -u alfmorten -p'IMKuben1337!' <<EOF
CREATE DATABASE chat_system CHARACTER SET utf8;
exit
EOF

echo "LAMP installation and configuration complete."
