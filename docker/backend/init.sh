#!/bin/sh
#cd /app
#cp -f docker/backend/db.php config/db.php
#chmod 777 config/db.php
#cp -f docker/backend/parser.json config/parser.json
#chmod 777 config/parser.json

#composer install --ignore-platform-reqs
#php yii migrate --interactive=0
#php yii init --interactive=0
#
#crontab -l > /var/spool/cron/crontabs/root
#cp /app/docker/backend/crontab /var/spool/cron/crontabs/root
#crontab /var/spool/cron/crontabs/root
#
#cron
apache2-foreground