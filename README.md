# Simple Image Gallery System

![Alt Text](https://media.giphy.com/media/12NUbkX6p4xOO4/giphy.gif)

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
```
cd backend
```
Migrate data ( skip this part if you don't want to drop the whole DB )
```
php artisan migrate:fresh
```
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

When have some update unless controller please clear cache for make sure code already update: 
```
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```
