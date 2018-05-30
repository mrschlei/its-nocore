FROM drupal7-cosign:latest

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
	/var/lock/apache2 /var/log/apache2 /var/run/apache2\
	/var/www/html

### Modify perms for the openshift user, who is not root, but part of root group.
RUN chmod -R g+rw /etc/apache2 \
	/etc/ssl/certs /etc/ssl/private \
	/usr/local/etc/php /usr/local/lib/php \
	/var/lib/apache2/module/enabled_by_admin \ 
	/var/lib/apache2/site/enabled_by_admin \
	/var/lock/apache2 /var/log/apache2 /var/run/apache2\
	/var/www/html

RUN chmod g+x /etc/ssl/private

WORKDIR /var/www/html

### Oracle packages and directories
RUN apt-get install -y apt-utils autoconf gzip libaio1 libaio-dev make zip 
RUN mkdir /etc/oracle /opt/oracle /usr/lib/oracle 
RUN chown root.root /etc/oracle /opt/oracle /usr/lib/oracle /usr/local/lib/php/extensions/no-debug-non-zts-20151012
RUN chmod -R g+w /etc/oracle /opt/oracle /usr/lib/oracle/usr /usr/local/lib/php/extensions/no-debug-non-zts-20151012
COPY instantclient-basic-linux.x64-12.2.0.1.0.zip /opt/oracle
### 

### Drush install
#RUN curl -sS https://getcomposer.org/installer | php
#RUN mv composer.phar /usr/local/bin/composer
#RUN composer require drush/drush:7.4
#RUN export PATH="$HOME/.config/composer/vendor/bin:$PATH" 
#RUN php -r "readfile('https://github.com/drush-ops/drush/archive/7.4.0.zip');" > drush \
#&& chmod +x drush \
#&& mv drush /usr/local/bin

#composer add
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN alias composer="/usr/local/bin/composer"

WORKDIR /var/www/html
RUN unzip drush-7.4.0.zip -d /usr/local/bin
RUN chmod +x /usr/local/bin/drush-7.4.0
RUN ln -sf /usr/local/bin/drush-7.4.0/drush /usr/local/bin/drush

#last composer add
RUN export PATH="$HOME/.config/composer/vendor/bin:$PATH"   

COPY start.sh /usr/local/bin
RUN chmod 755 /usr/local/bin/start.sh
CMD /usr/local/bin/start.sh
