#!/usr/bin/env bash

export APP_PORT=${APP_PORT:-8080}
export APP_ENV=${APP_ENV:-local}

export MYSQL_PORT=${MYSQL_PORT:-33060}
export MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD:-root}
export MYSQL_NAME=${DB_DATABASE:-laravel}
export MYSQL_USER=${DB_USERNAME:-laravel}
export MYSQL_PASSWORD=${DB_PASSWORD:-secret}

COMPOSE="docker-compose"
PS_RESULT=$(docker-compose ps -q)

if [[ ! -z "$PS_RESULT" ]]; then
    EXEC="yes"
else
    EXEC="no"
fi

if [[ $# -gt 0 ]]; then
    if [[ -f .env ]]; then
        source .env
    fi

    if [[ "$1" == "start" ]]; then
        ${COMPOSE} up -d

    elif [[ "$1" == "stop" ]]; then
        ${COMPOSE} down

    elif [[ "$1" == "art" ]]; then
        shift 1

        if [[ "$EXEC" == "yes" ]]; then
            ${COMPOSE} exec php \
                php artisan "$@"
        else
            ${COMPOSE} run --rm -w /var/www/html php \
                php artisan "$@"
        fi

    elif [[ "$1" == "composer" ]]; then
        shift 1

        if [[ "$EXEC" == "yes" ]]; then
            ${COMPOSE} exec php \
                composer "$@"

        else
            ${COMPOSE} run --rm -w /var/www/html php \
                composer "$@"
        fi

    elif [[ "$1" == "test" ]]; then
        shift 1

        if [[ "$EXEC" == "yes" ]]; then
            ${COMPOSE} exec php \
                ./vendor/bin/phpunit "$@"
        else
            ${COMPOSE} run --rm -w /var/www/html php \
                ./vendor/bin/phpunit "$@"
        fi
    else
        ${COMPOSE} "$@"
    fi
else
    ${COMPOSE} ps
fi
