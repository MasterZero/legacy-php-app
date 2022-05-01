## Legacy test app

Test empty php application with tree view.
Located at `/` and `/admin.php` after start listening.

## Install & run

required php5.6 + mysql. After clone this repo follow this steps:

1. setup database connection in `config.php`
2. run:
```
php5.6 migrate.php
php5.6 seed.php
```
3. start listening at `web` folder:
```
cd web
php5.6 -S 127.0.0.1:8000
```

Test account data:
admin:reallyhardpassword1337