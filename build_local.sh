#! /bin/bash

composer install
yarn install

mv .env.example .env
php artisan key:generate

yarn run dev
