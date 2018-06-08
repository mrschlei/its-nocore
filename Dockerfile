FROM drupal7-cosign:latest

WORKDIR /var/www/html/
COPY . /var/www/html/

# Section that sets up Apache and Cosign to run as non-root user.
EXPOSE 8080
EXPOSE 8443

### change directory owner, as openshift user is in root group.
RUN chown -R root:root /etc/apache2 \
	/etc/ssl/certs /etc/ssl/private \
	/usr/local/etc/php /usr/local/lib/php \
	/var/lib/apache2/module/enabled_by_admin \ 
	/var/lib/apache2/site/enabled_by_admin \
	/usr/local/bin /var/lock/apache2 \
	 /var/log/apache2 /var/run/apache2\
	/var/www/html

### Modify perms for the openshift user, who is not root, but part of root group.
RUN chmod -R g+rw /etc/apache2 \
	/etc/ssl/certs /etc/ssl/private \
	/usr/local/etc/php /usr/local/lib/php \
	/var/lib/apache2/module/enabled_by_admin \ 
	/var/lib/apache2/site/enabled_by_admin \
	/usr/local/bin /var/lock/apache2 \
	/var/log/apache2 /var/run/apache2\
	/var/www/html

RUN chmod g+x /etc/ssl/private

### Oracle instantclient packages and directories
### put this before the others, as it installs gzip, make and zip
RUN apt-get install -y apt-utils autoconf gzip libaio1 libaio-dev make zip mysql-client
RUN mkdir /etc/oracle /opt/oracle /usr/lib/oracle 
RUN chown root.root /etc/oracle /opt/oracle /usr/lib/oracle
RUN chmod -R g+w /etc/oracle /opt/oracle /usr/lib/oracle
COPY instantclient-basic-linux.x64-12.2.0.1.0.zip /opt/oracle
### 

### composer install 
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN alias composer="/usr/local/bin/composer"
###

### drush install
#RUN alias drush="/var/www/html/vendor/drush/drush/drush"
#RUN chmod -R 777 /var/www/html
#RUN chmod -R 777 /
#RUN composer require drush/drush:7.4.0
#RUN alias drush="/var/www/html/vendor/drush/drush/drush"
#RUN unzip drush-7.4.0.zip -d /usr/local/bin
#RUN chown -R root:root /usr/local/bin/drush-7.4.0
#RUN chmod +x /usr/local/bin/drush-7.4.0/drush
#RUN alias drush="/usr/local/bin/drush-7.4.0/drush"
#RUN pear install Console_Table
#RUN mv /secrets/app/settings.php /var/www/html/sites/default/settings.php
#RUN mv /secrets/app/its.webplatformsnonprod.umich.edu.internship.settings.php /var/www/html/sites/its.webplatformsnonprod.umich.edu.internship/settings.php
###


COPY start.sh /usr/local/bin
RUN chmod 755 /usr/local/bin/start.sh
CMD /usr/local/bin/start.sh
