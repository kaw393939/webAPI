# NJIT FAQ Project

To get started with this project, please have a look at the following:

-   [Local Development Setup](#local-development-setup) - Learn how to run this project locally on your machine
-   [Contributing](#contributing) - Learn how to contribue to this project

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


In order to use the Swagger API make sure to include:
```sh
L5_SWAGGER_GENERATE_ALWAYS=true
SWAGGER_VERSION=2.0
```
The Swagger Api can be found at:
```sh
http://127.0.0.1:8000/api/documentation
```
For routes that require the auth token in Swagger make sure:
```sh
to include "Bearer" before placing the value of the token

eg. Bearer "TOKEN_VALUE"
```




Create a minified bundle of your front-end code:

```sh
cd frontend
npm install
npm run build
npm run build:win # alternatively, when using command prompt
```

Start your development server in the root directory:

```sh
php artisan serve
```

Open `127.0.0.1:3000` or `localhost:3000` to view it in the browser.

## Contributing

In order to contribute to codebase of this project, you need to have a knowledge of `Laravel` and `Vue.js`.

To get started learning about these two Web frameworks, please visit the following sites:

-   [Laravel.com](https://laravel.com) - official `Laravel` website
-   [Laracast.com/laravel](https://laracasts.com/skills/laravel) -
    video tutorials for learning `Laravel` from scratch
-   [Vue.js](https://vuejs.org/v2/guide/) - official `Vue.js` website
-   [Laracast.com/vuejs](https://laracasts.com/series/learn-vue-2-step-by-step) - video tutorials for learning `Vue.js` from scratch

### Contributing to Front-End Codebase

**Before you start contributing to this project's front-end codebase, make sure you have a good understanding of `Vue.js` and front-end Web development. Please look through the learning resources above to learn more about modern front-end Web frameworks.**

Every `pull request` requires unit tests and must follow best practices for writing front-end code. In order to check whether your contribution is ready for a pull request, you can take advantage of the `scripts` specified in the `frontend/package.json` file.

The test script will run all unit tests to make sure your code behaves exactly how you're expecting.

```sh
npm run test:unit
```

To check whether your code is following best practices, you can use the following command:

```sh
npm run lint
```

If errors appear in your terminal, make sure you go back and fix them as necessary.

#### Notes on Linting and Unit Testing

Linting is done using the popular [`Eslint`](https://eslint.org) JavaScript linter. If you're unsure how to fix your linting errors, I recommend looking through the list of rules and how to fix them:

-   [ESLint Rules](https://eslint.org/docs/rules/)

---

**It is highly recommended that you go through the resources below to learn how to write tests for front-end code and `Vue.js`.**

All unit tests are executed using [`Jest`](https://jestjs.io/en/). To learn more about `Jest`, please look through its documentation:

-   [Jest Getting Started](https://jestjs.io/docs/en/getting-started.html)
-   [Jest Matchers](https://jestjs.io/docs/en/expect)

In addition to `Jest`, the [`vue-test-utils`](https://github.com/vuejs/vue-test-utils) package is used to test all `Vue.js` related code. It is **highly recommended** to go through its [documentation](https://vue-test-utils.vuejs.org/guides/#getting-started) to learn how to properly test `Vue.js` components.

-   [Unit Testing Introduction](https://vuejs.org/v2/guide/unit-testing.html)
-   [Unit Testing Vue Components](https://vuejs.org/v2/cookbook/unit-testing-vue-components.html)
-   [Knowing What to Test](https://vue-test-utils.vuejs.org/guides/#common-tips)

Each test file needs to be located in the `frontend/tests/unit` directory and should follow the `.spec` naming convention, for example:

```sh
frontend/src/components/MyComponent.vue
frontend/tests/unit/MyComponent.spec.js # your test code goes here
```
