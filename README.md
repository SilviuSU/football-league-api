# Football League Rest Api

## Install with Composer
make install

## Create database
bin/console doctrine:database:create

## Create database tables
bin/console doctrine:schema:update --force

## Generate the SSH keys

```
	$ mkdir var/jwt
	$ openssl genrsa -out var/jwt/private.pem -aes256 4096
	$ openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem
```

## Start the app
bin/console server:run

## Create user
```
$ curl -d '{"email" : "email@example.com","password" : "Pass123","role" : "ROLE_CLIENT"}' -H 'content-type: application/json' -v POST http://127.0.0.1:8000/user/
```

## Generate Token Authentication with Curl

```
Tokens have 1 hour expiration
$ curl -d '{"email" : "email@example.com","password" : "Pass123"}' -H 'content-type: application/json' -v -X  POST http://127.0.0.1:8000/user/token/

```

## Create League

```
$ curl -d '{"name" : "BPL"}' -H 'content-type: application/json' -v -X  POST http://127.0.0.1:8000/league/ -H 'Authorization: Bearer tokenGoesHere'
```

## Create Team in League #1

```
$ curl -d '{"name" : "Man Utd","stripe" : "Red and yellow"}' -H 'content-type: application/json' -v -X  POST http://127.0.0.1:8000/league/1/team -H 'Authorization: Bearer tokenGoesHere'
```

## Get League #1 details

```
$ curl -H 'content-type: application/json' -v GET http://127.0.0.1:8000/league/1 -H 'Authorization: Bearer token'
```

## Tests

```
make test
```

## Or

### PHP Unit
```
make phpunit
```

## Coding standards

PSR-2

```
make phpcs
```

or
```
make fix
```

#### Parallel Lint

```
make lint
```
#### Test Coverage

```
make coverage
```