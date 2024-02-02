## Challenge Geo - Torneo de tenis

![CI workflow](https://github.com/unicolas/challenge-geop/actions/workflows/ci.yml/badge.svg)

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
$ docker compose build --no-cache --pull
$ docker compose up --wait
```

```sh
# test
$ docker compose exec php sh
$ bin/console doctrine:database:create --env=test
$ bin/console doctrine:migrations:migrate --env=test
$ bin/phpunit --testdox
```
