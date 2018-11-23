# NJIT FAQ Project

To get started with this project, please have a look at the following:

-   [Local Development Setup](#local-development-setup) - How to run this project locally on your machine
-   [Contributing to Front-End Code](#contributing-to-front-end-code) - How to contribute to front-end code

## Local Development Setup

**You'll need to have Node 8.10.0 or later and PHP 7.1.3 or later on your local development machine.**

To get started developing, clone this repository:

```sh
git clone git@github.com:kaw393939/webAPI.git
cd webAPI
```

Install project dependencies and create a database file:

```sh
composer install
npm install
touch database/database.sqlite
cp .env.example .env
```

Change the content of the `.env` file to the following:

```sh
DB_CONNECTION=sqlite
DB_HOST=/absolute/path/to/database.sqlite
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=homestead
# DB_USERNAME=homestead
# DB_PASSWORD=secret
```

Run migration and generate necessary keys:

```sh
php artisan migrate
php artisan key:generate
php artisan jwt:secret
```

Create a minified bundle of your front-end code and start the development server:

```sh
npm run build
php artisan serve
```

Open `127.0.0.1:3000` or `localhost:3000` to view it in the browser.

## Contributing to Front-End Code

TODO
