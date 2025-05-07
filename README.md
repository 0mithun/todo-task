
## Requirements
- docker, docker-compose



## Installation Instructions

- Run `docker compose run php composer install`
- Run `cp .env.example .env`
- Set DB_HOST=db in .env
- Run `docker compose run php php artisan key:generate`
- Run `docker compose run php php artisan migrate`
- Run `docker compose run node npm install`
- Run `docker compose up -d`


## Run Application
- Run `docker compose up -d`
- Open http://127.0.0.1:8000/
