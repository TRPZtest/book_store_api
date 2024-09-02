# Makefile for Docker and Symfony commands

# Start Docker services
up:
	docker compose up -d

# Stop Docker services
stop:
	docker compose down

# Access the Symfony container's shell
shell:
	docker compose exec symfony bash

# Run migrations inside the Symfony container
migrate:
	docker compose exec symfony php bin/console doctrine:migrations:make
	docker compose exec symfony php bin/console doctrine:migrations:migrate --no-interaction

# Run migrations inside the Symfony container
migrate locally:
	php bin/console make:migration
	php bin/console doctrine:migrations:migrate --no-interaction

# Load fixtures inside the Symfony container
fixtures:
	docker compose exec symfony php bin/console doctrine:fixtures:load --no-interaction

# Combination of migrate and fixtures
setup: migrate fixtures

# Restart services (stop and start)
restart: stop up

# View logs from all services
logs:
	docker compose logs -f