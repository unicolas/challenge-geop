## Challenge Geo - Torneo de tenis

API Platform + Doctrine/PostgreSQL + PHPUnit

- La solución a la simulación de torneos se expone a partir del servicio `src\Service\ServiceTournamentPlayerService` y a través de las definiciones en `src\Domain`.
- Unit test correspondiente en `tests\Service`.
- Lo restante implementa persistencia y recursos para la API. Se publican 3 endpoints: 
  - `GET /tournaments` para consultar torneos.
  - `POST /tournaments/mens` para simular un torneo masculino.
  - `POST /tournaments/womens` para simular un toreno femenino.
- Test correspondiente en `tests\Service`.
- Swagger/OpenAPI se genera en `/docs/`.


```sh
$ docker compose build --no-cache
$ docker compose up -d
```

```sh
$ docker compose exec php sh
# dev
$ composer install
$ bin/console doctrine:migrations:migrate
# test
$ bin/console doctrine:database:create --env=test
$ bin/console doctrine:migrations:migrate --env=test
$ bin/phpunit --testdox
```
