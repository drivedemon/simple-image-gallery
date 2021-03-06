# Simple Image Gallery System

![Alt Text](https://media.giphy.com/media/3o6Ztl7oraKm4ZJ9mw/giphy.gif)

## Backend Instructions

Clone project
```
git clone <Repository URL>
```

Setup project for the first time only, otherwise, go to `start development` section
```
cd backend
```
Create `.env` file
```
cp .env.example .env
```
Access `env` file
```
nano .env
```
Change db config to
```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel-simple-image-gallery
DB_USERNAME=admin
DB_PASSWORD=1234
```
Install Dependencies
```
composer install
```
Generate key
```
php artisan key:generate
```
Build docker
```
docker build -t laravel-simple-image-gallery .
```

## Start Development (Backend)

Start all containers
```
docker-compose up -d
```
Access docker container
```
docker exec -it backend_web_1 bash
```
Migrate data ( skip this part if you don't want to drop the whole DB )
```
php artisan migrate:fresh
```
Create storage soft link
```
php artisan storage:link
```
You should see the backend up and running on `localhost:8000`

## Start Development (Frontend)

```
cd frontend
```
Install dependencies
```
yarn install
```
Run a server
```
yarn serve
```
You should see the frontend web up and running on `localhost:8080`
