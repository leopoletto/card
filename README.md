# Knot API Test

## Setup

Clone the repository: `git clone git@github.com:leopoletto/card.git leopoletto`

Install dependencies: `composer install & npm install`

Clone and rename the `.env.example` file to `.env`

Create the Docker container using Laravel Sail: `./vendor/bin/sail up -d`

Generate Key: `./vendor/bin/sail artisan key:generate`

Run the migration: `./vendor/bin/sail artisan migrate`

Seed the database with merchants: `./vendor/bin/sail artisan db:seed`

## Running the API

> Import the `Insomnia.json` file to Insomnia app which contains all the endpoints in the correct order.

###  Register user 

```CURL
curl --request POST \
  --url http://localhost/api/users \
  --header 'Accept: application/json' \
  --header 'Content-Type: application/json' \
  --header 'User-Agent: insomnia/2023.5.8' \
  --data '{
	"email": "acme@example.com",
	"password": "password"
}'
```
### Login user
> Use the e-mail and password (It automatically fills the token value for the next requests)

```CURL
curl --request POST \
  --url http://localhost/api/login \
  --header 'Accept: application/json' \
  --header 'Content-Type: application/json' \
  --header 'User-Agent: insomnia/2023.5.8' \
  --data '{
	"email": "acme@example.com",
	"password": "password"
}'
```

###  Create a card
> Save the card id for future use
> 
```CURL
curl --request POST \
  --url 'http://localhost/api/cards?=' \
  --header 'Accept: Application/Json' \
  --header 'Authorization: Bearer 444|O6vfeTEyg6NT8xFB2TsSAqsElj5lPPBC47fWKUqhb51bdc8b' \
  --header 'Content-Type: application/json' \
  --header 'User-Agent: insomnia/2023.5.8' \
  --data '{
	"number": "4491662671878085",
	"expiration_year": "2023",
	"expiration_month": "12",
	"cvv": "974"
}'
```

### Get merchants 
> Save one id future use

```CURL
curl --request GET \
  --url 'http://localhost/api/merchants?cursor=eyJtZXJjaGFudHMuaWQiOjIsIl9wb2ludHNUb05leHRJdGVtcyI6dHJ1ZX0' \
  --header 'Accept: Application/Json' \
  --header 'Authorization: Bearer 444|O6vfeTEyg6NT8xFB2TsSAqsElj5lPPBC47fWKUqhb51bdc8b' \
  --header 'User-Agent: insomnia/2023.5.8'
```

### Create a card switcher task

```CURL
curl --request POST \
   --url 'http://localhost/api/card-switcher-tasks?=' \
   --header 'Accept: Application/Json' \
   --header 'Authorization: Bearer 444|O6vfeTEyg6NT8xFB2TsSAqsElj5lPPBC47fWKUqhb51bdc8b' \
   --header 'Content-Type: application/json' \
   --header 'User-Agent: insomnia/2023.5.8' \
   --data '{
       "card_id": 4,
       "merchant_id": 2
   }
```
### Update the card switcher task status to `finished`

```CURL
curl --request PATCH \
--url 'http://localhost/api/card-switcher-tasks/17/finalize?=' \
--header 'Accept: Application/Json' \
--header 'Authorization: Bearer 444|O6vfeTEyg6NT8xFB2TsSAqsElj5lPPBC47fWKUqhb51bdc8b' \
--header 'User-Agent: insomnia/2023.5.8'
```

### Update the card switcher task status to `failed`

```CURL
curl --request PATCH \
  --url 'http://localhost/api/card-switcher-tasks/17/fail?=' \
  --header 'Accept: Application/Json' \
  --header 'Authorization: Bearer 444|O6vfeTEyg6NT8xFB2TsSAqsElj5lPPBC47fWKUqhb51bdc8b' \
  --header 'User-Agent: insomnia/2023.5.8'
```

### Get the latest finished card switcher task by card and merchant 

```CURL
curl --request GET \
  --url http://localhost/api/latest-card-switcher-tasks \
  --header 'Accept: Application/Json' \
  --header 'Authorization: Bearer 444|O6vfeTEyg6NT8xFB2TsSAqsElj5lPPBC47fWKUqhb51bdc8b' \
  --header 'User-Agent: insomnia/2023.5.8'
```




