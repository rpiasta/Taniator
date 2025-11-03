# PHP REST API Skeleton with Docker and Swagger UI

## Wymagania
- Docker
- Docker Compose

## Uruchomienie

1. **Zbuduj i uruchom kontenery:**

```bash
docker-compose up --build
```

2. **Wykonaj na kontenerze:**

```bash
docker compose exec app composer install
```

3**Wykonaj migracje:**

```bash
docker compose exec app php vendor/bin/doctrine-migrations migrate
```

4**Aplikacja jest dostępna na:**

```bash
http://localhost:8000
```

5**Swagger UI dostępny jest pod:**

```bash
http://localhost:8080
```

6**Admner dostępny jest pod:**

```bash
http://localhost:5050

Użytkownik: app_user
Hasło: app_pass
Baza danych: app_db
```

**ZMANY NA BAZIE**
```
docker compose exec app php vendor/bin/doctrine-migrations diff
```
```
docker compose exec app php vendor/bin/doctrine-migrations migrate
```

**Dodawanie nowych endpointów**
Dodaj nową metodę w kontrolerze (np. ApiController lub stwórz nowy).

Dodaj nową trasę w public/index.php:

```
$router->add('GET', '/api/nowy-endpoint', [$apiController, 'nowaMetoda']);
```

Zaktualizuj swagger.yaml, aby opisać nowy endpoint.

Restartuj kontenery jeśli potrzeba.

CURL
```
curl -H "XDEBUG_TRIGGER=1" http://localhost:8000/api/example
```

**REBUILD OBRAZOW**
```
docker system prune -a --volumes -f
```
```
docker compose build --no-cache
```
```
docker compose up -d
```
```
docker compose exec app composer install
```


## USTAWIENIE DEBUGGERA

```
settings -> php -> CLI interpreter -> from docker-composer
```
```
dodać w konfiguracji PHP remote Debug na serwer localhost IDE key PHPSTORM
przy dodawaniu localhost ustawic host na localhost i port na 8000  zaznaczyć user path mapping,
ustawić Absolute path on the server na /app
```
```
ustawić w settings ->php -> debugg port na 9003
```