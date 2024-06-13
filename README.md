# Hotel Booking API

## Requirements:
- Composer (https://getcomposer.org/)
- Docker (https://www.docker.com/products/docker-desktop/)
- Mailtrap registration (https://mailtrap.io/)
  - Once registered you will need to copy the `mailtrap_username` and `mailtrap_password`:
    - Form the sidebar navigate to Email Testing and click the Action settings button
    - A page with SMPT Integration will open
    - Copy the `Username` and the `Password` and later paste them in the `.env` file
- Postman (https://www.postman.com/downloads/)

## Project Set Up:

### Clone the project from

    https://github.com/unsta/hotel-booking

### Create an `.env` file from `.env.example`

### From the project directory run

    composer install

### To start the Docker containers in the background run

    ./vendor/bin/sail up -d

Note: Make sure that all the containers are started successfully and there are no port conflicts

### To generate an APP_KEY run

    ./vendor/bin/sail artisan key:generate

### Run the migrations

    ./vendor/bin/sail artisan migrate

### Run the seeders

    ./vendor/bin/sail artisan db:seed

### Run code quality checks (Check the `app/Makefile`)

    make pipeline

### Run the Feature tests (Docker provides a testing db)

    make test-feature

# Rest APIs

The REST APIs to the hotel-booking app are described below.

Note: Assuming you are accessing the application via `localhost`.

## #Get list of Rooms

### Request

`GET /api/list-rooms`

```bash
curl --location 'localhost/api/list-rooms' \
--header 'Accept: application/json' \
--header 'Cookie: XDEBUG_SESSION=docker'
```

### Response

`HTTP 200 OK`

```json
{
    "data": [
        {
            "id": 1,
            "number": "A11",
            "type": "single room",
            "price_per_night": 5000,
            "status": "occupied",
            "created_at": "2024-06-13 12:10:57",
            "updated_at": null
        },
        {
            "id": 2,
            "number": "A12",
            "type": "triple room",
            "price_per_night": 10000,
            "status": "vacant",
            "created_at": "2024-06-13 12:10:57",
            "updated_at": null
        },
        {
            "id": 3,
            "number": "A13",
            "type": "double room",
            "price_per_night": 7500,
            "status": "occupied",
            "created_at": "2024-06-13 12:10:57",
            "updated_at": null
        },
        {
            "id": 4,
            "number": "A21",
            "type": "king room",
            "price_per_night": 25000,
            "status": "vacant",
            "created_at": "2024-06-13 12:10:57",
            "updated_at": null
        }
    ]
}
```

## #Get list of Bookings

### Request

`GET /api/list-bookings`

```bash
curl --location 'localhost/api/list-bookings' \
--header 'Accept: application/json'
```

### Response

`HTTP 200 OK`

```json
{
    "data": [
        {
            "id": 1,
            "room_id": 1,
            "customer_id": 1,
            "check_in_date": "2024-06-12",
            "check_out_date": "2024-06-20",
            "total_price": 45000,
            "created_at": "2024-06-13 12:10:57",
            "updated_at": null
        },
        {
            "id": 2,
            "room_id": 3,
            "customer_id": 1,
            "check_in_date": "2024-08-01",
            "check_out_date": "2024-08-05",
            "total_price": 30000,
            "created_at": "2024-06-13 12:10:57",
            "updated_at": null
        }
    ]
}
```

## #Show Room

### Request

`GET /api/show-room/1`

```bash
curl --location 'localhost/api/show-room/1' \
--header 'Accept: application/json'
```

### Response

`HTTP 200 OK`

```json
{
    "data": {
        "number": "A11",
        "type": "single room",
        "price_per_night": 5000,
        "status": "occupied",
        "bookings": [
            {
                "id": 1,
                "check_in_date": "2024-06-12",
                "check_out_date": "2024-06-20",
                "total_price": 45000
            }
        ]
    }
}
```


## #Show Customer

`GET /api/show-customer/1`

```bash
curl --location 'localhost/api/show-customer/1' \
--header 'Accept: application/json'
```

### Response

`HTTP 200 OK`

```json
{
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "johndoe@example.com",
        "phone_number": "**********345",
        "bookings": [
            {
                "id": 1,
                "room_id": 1,
                "customer_id": 1,
                "check_in_date": "2024-06-12",
                "check_out_date": "2024-06-20",
                "total_price": 45000,
                "created_at": "2024-06-13 12:10:57",
                "updated_at": null
            },
            {
                "id": 2,
                "room_id": 3,
                "customer_id": 1,
                "check_in_date": "2024-08-01",
                "check_out_date": "2024-08-05",
                "total_price": 30000,
                "created_at": "2024-06-13 12:10:57",
                "updated_at": null
            }
        ]
    }
}
```
## #Authenticate User

### Request

`/api/auth/login`

```bash
curl --location 'localhost/api/auth/login' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data-raw '{
    "email": "johndoe@hb.com",
    "password": "password"
}'
```

### Response

`HTTP 200 OK`

```json
{
    "status": "success",
    "message": "User logged in successfully",
    "token": "7|Oq56UwF73Qz81ImcEiF6uy3vwq1EhL7SN7EwOi4Ga6317d14"
}
```

## #Store Room

### Request

`/api/store-room`

```bash
curl --location 'localhost/api/store-room' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer TOKEN_FROM_AUTH_USER' \
--data '{
    "number": "A31",
    "type": "queen room",
    "price_per_night": 6500234234234,
    "status": "vacant"
}'
```

### Response

`HTTP 200 OK`

```json
{
    "status": "success",
    "message": "Room [A31] was successfully created"
}
```

## Store Customer

### Request

`/api/store-customer`

```bash
curl --location 'localhost/api/store-customer' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer TOKEN_FROM_AUTH_USER' \
--data-raw '{
    "name": "Jo Jones",
    "email": "test3@mail.bg",
    "phone_number": "+123345432765"
}'
```

### Response

`HTTP 200 OK`

```json
{
    "status": "success",
    "message": "User [Jo Jones] was successfully created"
}
```

## Store Booking

### Request

`api/store-booking`

```bash
curl --location 'localhost/api/store-booking' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer TOKEN_FROM_AUTH_USER' \
--data '{
    "room_id": 1,
    "customer_id": 1,
    "check_in_date": "2025-01-17",
    "check_out_date": "2025-01-18"
}'
```

### Response

`HTTP 200 OK`

```json
{
    "status": "success",
    "message": "Booking [4] was successfully created"
}
```
Note: Check `mailtrap` for a new email 

## Store Payment

### Request

`api/store-payment`

```bash
curl --location 'localhost/api/store-payment' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer TOKEN_FROM_AUTH_USER' \
--data '{
    "booking_id": 1,
    "amount": 45000
}'
```

### Response

`HTTP 200 OK`

```json
{
    "status": "success",
    "message": "Payment #3 was successfully created"
}
```

# Future Improvements
- `laminas/laminas-hydrator`
- `Laravel Queues`
- `Caching`
