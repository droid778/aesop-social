FROM friendica:latest

COPY overlay/config/aesop.config.php /var/www/html/config/aesop.config.php
COPY overlay/static/logo.svg /var/www/html/images/logo.svg
COPY overlay/apache-proxy.conf /etc/apache2/conf-available/proxy.conf
COPY overlay/install-friendica.sh /usr/local/bin/install-friendica.sh
COPY overlay/smarty-register-functions.php /var/www/html/smarty-register-functions.php

RUN a2enmod remoteip setenvif && a2enconf proxy && \
    echo "ServerName aesop-social.uk" > /etc/apache2/conf-available/servername.conf && \
    a2enconf servername && \
    chmod +x /usr/local/bin/install-friendica.sh && \
    apt-get update && apt-get install -y mariadb-client && rm -rf /var/lib/apt/lists/*

# Create entrypoint script to handle Smarty registration at runtime
RUN echo '#!/bin/bash\n\
if [ ! -f /var/www/html/index.php ]; then\n\
  /docker-entrypoint.sh &\n\
  sleep 5\n\
  wait\n\
fi\n\
if [ -f /var/www/html/index.php ] && [ -f /var/www/html/smarty-register-functions.php ]; then\n\
  (echo "<?php require '\''/var/www/html/smarty-register-functions.php'\''; ?>"; cat /var/www/html/index.php) > /tmp/index.php && mv /tmp/index.php /var/www/html/index.php\n\
fi\n\
exec "$@"' > /usr/local/bin/aesop-entrypoint.sh && \
    chmod +x /usr/local/bin/aesop-entrypoint.sh

ENTRYPOINT ["/usr/local/bin/aesop-entrypoint.sh"]
CMD ["apache2-foreground"]

LABEL org.opencontainers.image.title="Aesop Social"
LABEL org.opencontainers.image.description="Aesop Social: a federated social network based on Friendica"
LABEL org.opencontainers.image.licenses="AGPL-3.0"
