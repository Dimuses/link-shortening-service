# Setup Guide for the Link Shortening Service Project

Follow the steps below to install and run the project.

## Installation Steps:

1. **Clone the repository**

    ```bash
    git clone <repository-URL>
    ```

2. **Navigate to the project directory**

    ```bash
    cd link-shortening-service
    ```

3. **Create the `.env` file from `.env.example`**

    ```bash
    cp .env.example .env
    ```

4. **Install dependencies using Composer**

   Run Composer through a Docker container to avoid any platform-specific issues:

    ```bash
    docker run --rm \
       -u "$(id -u):$(id -g)" \
       -v "$(pwd):/var/www/html" \
       -w /var/www/html \
       laravelsail/php83-composer:latest \
       composer install --ignore-platform-reqs
    ```

5. **Start the project using Laravel Sail**

    ```bash
    ./vendor/bin/sail up -d
    ```

6. **Run migrations**

    ```bash
    ./vendor/bin/sail artisan migrate
    ```
7. **Generate app key**
    ```bash
    ./vendor/bin/sail artisan key:generate
    ```

This guide ensures that you can set up the project with minimal friction and is tailored to environments that use Docker and Laravel Sail for a consistent development experience.
