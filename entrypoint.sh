#!/bin/sh

set -e

cd /var/www/html

mkdir -p \
    bootstrap/cache \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/testing \
    storage/framework/views \
    storage/logs

chown -R www-data:www-data bootstrap/cache storage
chmod -R ug+rwx bootstrap/cache storage

if [ ! -f .env ] && [ -f .env.example ]; then
    cp .env.example .env
fi

if [ ! -f vendor/autoload.php ]; then
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

if [ -f package.json ] && [ ! -d node_modules ]; then
    if [ -f package-lock.json ]; then
        npm ci
    else
        npm install
    fi
fi

if [ -f artisan ]; then
    php artisan config:clear --no-interaction >/dev/null 2>&1 || true
fi

if [ "${DB_CONNECTION:-}" = "mysql" ]; then
    echo "Aguardando o MySQL ficar disponivel..."

    until php -r '
        $host = getenv("DB_HOST") ?: "mysql";
        $port = getenv("DB_PORT") ?: "3306";
        $username = getenv("DB_USERNAME") ?: "root";
        $password = getenv("DB_PASSWORD") ?: "";

        try {
            new PDO("mysql:host={$host};port={$port}", $username, $password);
            exit(0);
        } catch (Throwable $exception) {
            fwrite(STDERR, $exception->getMessage() . PHP_EOL);
            exit(1);
        }
    '; do
        sleep 2
    done
fi

if [ -f artisan ]; then
    if ! grep -q '^APP_KEY=base64:' .env 2>/dev/null; then
        php artisan key:generate --force --no-interaction
    fi

    if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
        php artisan migrate --force --no-interaction
    fi

    if [ "${RUN_FRONTEND_BUILD:-true}" = "true" ] && [ -f package.json ] && [ ! -f public/build/manifest.json ]; then
        npm run build
    fi
fi

exec "$@"
