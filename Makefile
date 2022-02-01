up:
	# docker stop $$(docker ps -aq)
	sudo chmod 777 -R database
	docker-compose up
up-dev:
	docker-compose -f docker-compose.dev.yml up -d
up-local:
	docker-compose -f docker-compose.local.yml up --build

build:
	rm -rf runtime/dockerLogs/*
	sudo chmod 777 -R database
	docker-compose -f docker-compose.yml build

build-dev:
	docker-compose -f docker-compose.dev.yml build
build-local:
	docker-compose -f docker-compose.local.yml build

init-db:
	docker exec -it nfm_mysql_db bash -c "mysql --user=root nfm_catalog < /dumps/nfm-catalog.sql"

ip-server:
	sudo ifconfig | grep "inet "