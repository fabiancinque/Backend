# Backend REST API 

Api to get data from SWAPI

## Install

    PHP 8
    Laravel 8
    MySQL
## Install

    git clone <URL del repositorio>

    composer install

## Configuring the .env file

1. Rename the `.env.example` file to `.env` in the root directory of the project.
2. Update the `.env` file with your database configuration details, including the `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` values.
3. Save the `.env` file.

## Generate app key

    php artisan key:generate

## Run migrations && fill user table
The default password it generates is "password"

    php artisan migrate --seed

## Generate JWT Token

    php artisan jwt:secret

# REST API

    The REST API documentation: /api/docs

## Authenticate

### Request

`POST /api/v1/auth/login`

    curl --location '/api/v1/auth/login' --header 'Content-Type: application/json' --data-raw '{"email": "USER_OF_TABLE", "password": "password"}'

### Response

    {"access_token":"your_access_token","token_type":"bearer","expires_in":3600}

### Error
    {
        "error": "Unauthorized"
    }

## Get all OF people / planets / vehicles resources

### Request

`GET /people/` `GET /planets/` `GET /vehicles/`

    curl --location 'http://backend.test/api/v1/people?limit=5&offset=0' --header 'Accept: application/json' --header 'Authorization: Bearer your_access_token'

### Response

    {
        "0": {
            "name": "Luke Skywalker",
            "height": "172",
            "mass": "77",
            "hair_color": "blond",
            "skin_color": "fair",
            "eye_color": "blue",
            "birth_year": "19BBY",
            "gender": "male",
            "homeworld": "https://swapi.dev/api/planets/1/",
            "films": [
                "https://swapi.dev/api/films/1/",
                "https://swapi.dev/api/films/2/",
                "https://swapi.dev/api/films/3/",
                "https://swapi.dev/api/films/6/"
            ],
            "species": [],
            "vehicles": [
                "https://swapi.dev/api/vehicles/14/",
                "https://swapi.dev/api/vehicles/30/"
            ],
            "starships": [
                "https://swapi.dev/api/starships/12/",
                "https://swapi.dev/api/starships/22/"
            ],
            "created": "2014-12-09T13:50:51.644000Z",
            "edited": "2014-12-20T21:17:56.891000Z",
            "url": "https://swapi.dev/api/people/1/"
        },
        "1": {...},
        "2": {...},
        "3": {...},
        "4": {...},
    }


## Get a specific people / planet / vehicle resource

### Request

`GET /people/{id}` `GET /planets/{id}` `GET /vehicles/{id}`

    curl --location 'http://backend.test/api/v1/people/3' --header 'Accept: application/json' --header 'Authorization: Bearer your_access_token'

### Response

    {
        "name": "R2-D2",
        "height": "96",
        "mass": "32",
        "hair_color": "n/a",
        "skin_color": "white, blue",
        "eye_color": "red",
        "birth_year": "33BBY",
        "gender": "n/a",
        "homeworld": "https://swapi.dev/api/planets/8/",
        "films": [
            "https://swapi.dev/api/films/1/",
            "https://swapi.dev/api/films/2/",
            "https://swapi.dev/api/films/3/",
            "https://swapi.dev/api/films/4/",
            "https://swapi.dev/api/films/5/",
            "https://swapi.dev/api/films/6/"
        ],
        "species": [
            "https://swapi.dev/api/species/2/"
        ],
        "vehicles": [],
        "starships": [],
        "created": "2014-12-10T15:11:50.376000Z",
        "edited": "2014-12-20T21:17:50.311000Z",
        "url": "https://swapi.dev/api/people/3/"
    }