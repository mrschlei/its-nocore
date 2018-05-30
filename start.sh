#!/bin/sh

# Redirect logs to stdout and stderr for docker reasons.
# it seems both sylinks already exist. 
# these commands create unnecessary duplicates
ln -sf /dev/stdout /var/log/apache2/access_log
ln -sf /dev/stderr /var/log/apache2/error_log

# apache and virtual host secrets
ln -sf /secrets/apache2/apache2.conf /etc/apache2/apache2.conf
ln -sf /secrets/apache2/ports.conf /etc/apache2/ports.conf
ln -sf /secrets/apache2/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf
ln -sf /secrets/apache2/cosign.conf /etc/apache2/mods-available/cosign.conf
ln -sf /secrets/apache2/envvars /etc/apache2/envvars

# SSL secrets
ln -sf /secrets/ssl/USERTrustRSACertificationAuthority.pem /etc/ssl/certs/USERTrustRSACertificationAuthority.pem
ln -sf /secrets/ssl/AddTrustExternalCARoot.pem /etc/ssl/certs/AddTrustExternalCARoot.pem
ln -sf /secrets/ssl/sha384-Intermediate-cert.pem /etc/ssl/certs/sha384-Intermediate-cert.pem

#bad ideas
export ORACLE_HOME=/usr/lib/oracle/12.2/client64
export LD_LIBRARY_PATH=/opt/oracle/instantclient

if [ -f /secrets/app/local.start.sh ]
then
  /bin/sh /secrets/app/local.start.sh
fi

## Rehash command needs to be run before starting apache.
c_rehash /etc/ssl/certs >/dev/null

a2enmod ssl
a2enmod include
a2ensite default-ssl 

cd /var/www/html
drush @sites cc all --yes
drush up --no-backup --yes

oc set-env dc/its-nocore ORACLE_HOME=/usr/lib/oracle/12.2/client64
oc set-env dc/its-nocore PATH:=$ORACLE_HOME
oc set-env dc/its-nocore TNS_ADMIN=/etc/oracle
oc set-env dc/its-nocore LD_LIBRARY_PATH:=/opt/oracle/instantclient

/usr/local/bin/apache2-foreground
