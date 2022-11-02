# Application Top Category Positions

Разработано на Laravel 9

### Развертывание
* При помощи Composer в папке с проектом выполнить: ```composer install --ignore-platform-reqs```
* Если отсутствует Composer, то в папке с проектом выполнить: 
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
* Поднять проект при помощи Sail: ```./vendor/bin/sail up```
* Выполнить миграции: ```sail artisan migrate```
