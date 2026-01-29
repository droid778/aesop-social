FROM friendica:latest

COPY overlay/config/aesop.config.php /var/www/html/config/aesop.config.php
COPY overlay/static/logo.svg /var/www/html/images/logo.svg
COPY overlay/apache-proxy.conf /etc/apache2/conf-available/proxy.conf
COPY overlay/install-friendica.sh /usr/local/bin/install-friendica.sh

RUN a2enmod remoteip setenvif && a2enconf proxy && \
    chmod +x /usr/local/bin/install-friendica.sh && \
    apt-get update && apt-get install -y mariadb-client && rm -rf /var/lib/apt/lists/*

LABEL org.opencontainers.image.title="Aesop Social"
LABEL org.opencontainers.image.description="Aesop Social: a federated social network based on Friendica"
LABEL org.opencontainers.image.licenses="AGPL-3.0"
