FROM yiisoftware/yii2-php:7.4-apache
WORKDIR /app

RUN #sed -i -e 's|/app/web|/app/web|g' /etc/apache2/sites-available/000-default.conf
# If ERROR: "service docker restart"
RUN apt-get update && \
    apt-get -y install --reinstall systemd
RUN apt update

RUN apt-get -y install  wget \
    cron \
    xdg-utils \
    nano

RUN #apt --fix-broken -y install
RUN systemctl enable cron

RUN apt-get purge -y g++ \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/* \
    && rm -rf /tmp/*

# Install crome-browser
#RUN wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
#RUN dpkg -i --force-depends google-chrome-stable_current_amd64.deb

COPY ./install-composer.sh / \
    ./init.sh /

RUN sh /install-composer.sh
RUN rm /install-composer.sh

COPY ./init.sh /

RUN chmod +x /init.sh

CMD /init.sh

ENTRYPOINT ["/init.sh"]
#CMD bash -c "cron && php-fpm"



