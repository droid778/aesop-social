FROM friendica:latest

COPY overlay/theme/aesop /var/www/html/view/theme/aesop
COPY overlay/static/logo.svg /var/www/html/images/logo.svg
COPY overlay/config/aesop.config.php /var/www/html/config/aesop.config.php
COPY overlay/addons/* /var/www/html/addon/custom/
COPY overlay/apache-proxy.conf /etc/apache2/conf-available/proxy.conf

RUN a2enmod remoteip setenvif && a2enconf proxy

LABEL org.opencontainers.image.title="Aesop Social"
LABEL org.opencontainers.image.description="Aesop Social: a federated social network based on Friendica"
LABEL org.opencontainers.image.licenses="AGPL-3.0"
