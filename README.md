## _EVENT ACCESS PRINTER_

#### Requisites:
Docker and docker-compose installed in your device

#### Instructions:
##### Build and up containers:
- ```docker-commpose up -d --build```

##### Install dependencies:
- ```docker-compose exec php composer install```
- ```docker-compose exec node npm install```

##### Compile statics:
- ```docker-compose exec node run dev```

##### Run migrations:
- ```docker-compose exec php bin/console doctrine:migrations:migrate```

#### Tests:
##### Create test database and run migrations:
- ```docker-compose exec php bin/console doctrine:database:create --env=test```
- ```docker-compose exec php bin/console doctrine:migrations:migrate --env=test```

##### Run Tests:
- ```docker-compose exec php vendor/bin/phpunit```1~
