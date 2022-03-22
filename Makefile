define mysql_ip
	$$(docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' nfm_mysql_db)
endef

up:
	docker stop $$(docker ps -aq)
	sudo chmod 777 -R database
	docker-compose up -d
up-dev:
	docker-compose -f docker-compose.dev.yml up -d
up-local:
	docker-compose -f docker-compose.local.yml up --build

stop:
	docker-compose stop

build:
	sudo chmod 777 -R database
	sudo rm -rf database/*
	rm -rf runtime/dockerLogs/*
	docker-compose -f docker-compose.yml build
	docker-compose -f docker-compose.yml up
	make init-db

build-dev:
	docker-compose -f docker-compose.dev.yml build
build-local:
	sudo chmod 777 -R database
	sudo rm -rf database/*
	rm -rf runtime/dockerLogs/*
	docker-compose -f docker-compose.local.yml build
	make init-db

init-db:
	docker exec -it nfm_mysql_db bash -c "mysql --user=root -e \"DROP DATABASE IF EXISTS nfm_catalog; CREATE DATABASE nfm_catalog CHARACTER SET utf8 COLLATE utf8_unicode_ci;\""
	docker exec -it nfm_mysql_db bash -c "mysql --user=root -e \"DROP DATABASE IF EXISTS nfm_parser; CREATE DATABASE nfm_parser CHARACTER SET utf8 COLLATE utf8_unicode_ci;\""
	docker exec -it nfm_mysql_db bash -c "mysql --user=root nfm_catalog < /dumps/nfm-catalog.sql"
	docker exec -it nfm_backend bash -c "php yii migrate-eparts --interactive=0"

ip-server:
	sudo ifconfig | grep "inet "

mysql_ip:
	echo $(mysql_ip)