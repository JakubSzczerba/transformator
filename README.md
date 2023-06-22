# Transformator
> Application for transforming source to messages

## Technologies
* PHP - version 8.2.7
* Symfony - version 6.3.0
* MariaDB - version 10.5

## Local Setup
```
docker compose up -d
```
```
docker compose exec php composer install
```
```
docker compose exec php bin/console transform:collection src/Data/Input/collection.json
```
```
docker compose exec php php bin/phpunit
```

## Contact
* [GitHub](https://github.com/JakubSzczerba) 
* [LinkedIn](https://www.linkedin.com/in/jakub-szczerba-3492751b4/)