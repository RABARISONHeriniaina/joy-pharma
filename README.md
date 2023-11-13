# JOY PHARME API Project

![Symfony](https://img.shields.io/badge/Symfony-6.3-purple.svg)
![PHP](https://img.shields.io/badge/PHP-8.2-blue.svg)

## 📖 Project description

This project is made with [Symfony][1] 6.3.

## 🚀 Environment Setup

### 🐳 Needed tools

1. PHP 8.2 or higher;
2. Composer
3. PDO-MySQL PHP extension enabled;
4. and the [usual Symfony application requirements][2].

[//]: # (5. Clone this project: `git clone -`)

6. Move to the project folder: `cd joy-pharma`


### 🛠️ Environment configuration

1. Create a local environment file (`cp .env .env.local`) if you want to modify any parameter
2. If you want to modify database configuration, edit this line in `.env` file with your own configuration
   `DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8.0.32&charset=utf8mb4"`


### 🔥 Application execution

1. Install the backend dependencies: `composer install`.
2. Create a database & tables with `php bin/console d:d:c` then `php bin/console make:migration`
   and `php bin/console migration:migrate` or force with `php bin/console d:s:u -f`

[//]: # (3. Create default user with command `php bin/console app:create-user`, if you want to create and administrator or super-administrator)

[//]: # (   add the argument `--role=admin` or `--role=super-admin`)

4. As stated in the [`lexik/jwt-authentication-bundle`](https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#generate-the-ssh-keys) documentation, run the following commands to generate ssh keys:
   You can modify your passphrase in `.env` file inside the lexik-bundle section as following:
   **JWT_PASSPHRASE=your_passphrase_goes_here**
   ``` bash
    php bin/console lexik:jwt:generate-keypair
    ``` 
   If you have a problem to execute this command, you can try to execute this command (passphrase : joy-pharma):
   ``` bash
    mkdir -p config/jwt
    openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
    openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
    ```
5. Start the server with Symfony: `symfony serve`.
   Then access the application in your browser at the given URL ([https://localhost:8000](https://localhost:8000) by default).
   If you don't have the Symfony binary installed, run `php -S localhost:8000 -t public/`
   to use the built-in PHP web server or [configure a web server][3] like
   Apache or Nginx to run the application.
6. If you want to use the API, you can use Insomnia or Postman to test the API, then import `{URL}/api/docs.json`
   to get all collections or download the OpenAPI specification file from the documentation. You can find the API documentation at `{URL}/api/docs`.

### ✅ Tests execution

1. Install the dependencies if you haven't done it previously: `composer install`

[//]: # (2. Execute PHPUnit tests: `php bin/phpunit --configuration phpunit.xml.dist`)

[1]: https://symfony.com/doc/6.3/index.html
[2]: https://symfony.com/doc/6.3/setup.html#technical-requirements
[3]: https://symfony.com/doc/6.3/setup/web_server_configuration.html