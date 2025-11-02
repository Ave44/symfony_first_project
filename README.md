### Starting server

1. docker-compose up -d
1. docker-compose ps _(optional to check if database is running)_
1. symfony serve

### Migration

1. symfony console make:migration
1. symfony console doctrine:migrations:migrate
1. symfony console doctrine:fixtures:load
1. symfony console dbal:run-sql "SELECT \* FROM TABLE" _(shop_item for example)_
