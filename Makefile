# Makefile for Docker and Symfony commands

# Start Docker services
start:
	docker compose up -d

# Stop Docker services
stop:
	docker compose down

# Access the Symfony container's shell
shell:
	docker compose exec symfony bash

# Run migrations inside the Symfony container
migrate:
	docker compose exec symfony php bin/console make:migration --no-interaction
	docker compose exec symfony php bin/console doctrine:migrations:migrate --no-interaction

# Load fixtures inside the Symfony container
fixtures:
	docker compose exec symfony php bin/console doctrine:fixtures:load --no-interaction

install:
	composer install --no-interaction --prefer-dist --optimize-autoloader

# Combination of migrate and fixtures
setup: install migrate fixtures

# Restart services (stop and start)
restart: stop start

# View logs from all services
logs:
	docker compose logs -f