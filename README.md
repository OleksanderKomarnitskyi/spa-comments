 SPA Comments

реалізація каскадної струкрури коментарів для поста.
У проекті використано наступні технології 

Laravel 10

php 8.1

DB sqlite можна перключити на звичайну mysql або іншу реляційну базу даних

inertiajs/vue3 and  tailwindcss  для фронтової чвстини

pusher для використання WS

laravel-echo для WS на фронтовій частині

predis для кешування на Redis

laravel queue 


Для розвертанні та запуску проекту виконати нвступну послідовність

стягуєм проет
- git clone git@github.com:OleksanderKomarnitskyi/spa-comments.git

встановлюємо необхідні пакети 
- composer install

створюємо глобальний конфіг за зразком
- cp .env.example .env

підключення бази даних 
створити базу даних та встановити свої доступи
або використати 
DB_CONNECTION=sqlite

запустити міграції та наповнення тестовими даними 
- php artisan migrate --seed

встановити значення ключів доступу до google recaptcha

- GOOGLE_RECAPTCHA_SITE_KEY=
- GOOGLE_RECAPTCHA_SECRET_SITE_KEY=

встановити налаштування доступу до WS сервера або свій варіант
- BROADCAST_DRIVER=pusher   
- PUSHER_APP_ID=
- PUSHER_APP_KEY=
- PUSHER_APP_SECRET=
- PUSHER_PORT=443
- PUSHER_SCHEME=https
- PUSHER_APP_CLUSTER=

вказати драйвер для кеша  або свій варіант
- CACHE_DRIVER=redis  

налаштування для черг вказати
- QUEUE_CONNECTION=database
якщо вказано  database обовязково виконати запуск черг
- php artisan queue:work

або встановити 

- QUEUE_CONNECTION=sync

виконати створення унікального ключа 
- php artisan key:generate

Для фронтової частини необхіна node  v19.9.0
встановлення залежностей 
- npm i

запуск компіляції 
- npm run build

запустити локальний хост або інший варіант
- php artisan serve



