up:
	docker-compose up
up-dev:
	docker-compose -f docker-compose.dev.yml up -d
up-local:
	docker-compose -f docker-compose.local.yml up --build

build:
	rm -rf runtime/dockerLogs/*
	docker-compose -f docker-compose.yml build

build-dev:
	docker-compose -f docker-compose.dev.yml build
build-local:
	docker-compose -f docker-compose.local.yml build