## Food Zero

Food Zero is a modern and eco-friendly restaurant that offers a healthy, zero-waste dining experience. Focused on sustainability, it serves fresh, organic, and locally sourced meals in a minimalist yet cozy environment. With a menu inspired by global cuisines, Food Zero caters to all dietary preferences, including vegan, vegetarian, and gluten-free options.

## Technologies Used

- **Laravel**: Backend framework for routing, models, controllers, and database management.
- **Blade**: Templating engine used for rendering views.
- **MySQL**: Database system for storing user and card-related data.

## Requirements

- PHP **8.4** (`composer.json` requires `^8.4`)
- MySQL 8
- [Laradock](https://laradock.io) is the supported local environment (services `nginx`, `mysql`, `php-fpm-84`, `workspace-84`).

## Launch instructions (Laradock, PHP 8.4)

The project folder must be reachable by Laradock. With `APP_CODE_PATH_HOST=../` the project is available in the containers as `/var/www/FoodZero/zero`.

1. Start the containers from the Laradock directory:
   `docker compose up -d nginx mysql php-fpm-84 workspace-84`
2. Create the database (once):
   `docker compose exec mysql mysql -uroot -proot -e "CREATE DATABASE IF NOT EXISTS zero CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"`
3. Add an nginx site to the sites directory that your Laradock nginx mounts (e.g. `nginx/sites/84_foodzero.conf`), then reload nginx (`docker compose exec nginx nginx -t && docker compose exec nginx nginx -s reload`):

   ```nginx
   server {
       listen 80;
       server_name foodzero.local;
       root /var/www/FoodZero/zero/public;
       index index.php;

       location / {
           try_files $uri $uri/ /index.php$is_args$args;
       }

       location ~ \.php$ {
           try_files $uri /index.php =404;
           fastcgi_pass php-fpm-84:9000;
           fastcgi_index index.php;
           fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
           include fastcgi_params;
       }
   }
   ```
4. Map the domain in the `hosts` file (`C:\Windows\System32\drivers\etc\hosts` on Windows, `/etc/hosts` elsewhere):
   `127.0.0.1 foodzero.local`
5. Open the workspace shell: `docker compose exec --user=laradock workspace-84 bash`, then:
   ```bash
   cd /var/www/FoodZero/zero
   composer install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate
   ```
   `.env.example` is already configured for Laradock (`DB_HOST=mysql`, `DB_DATABASE=zero`, `root`/`root` – development credentials only).
6. Open <http://foodzero.local/> (redirects to `/foodzero`). The admin login is at <http://foodzero.local/admin/login>.

Run tests with `php artisan test` inside the workspace container.

### Notes

- `workspace-84` must be attached to the same Docker network as `mysql` (`backend` in the default Laradock compose file); otherwise `DB_HOST=mysql` cannot be resolved.
- If `composer install` fails with `Could not authenticate against github.com`, the GitHub token in the container's Composer `auth.json` is invalid or expired – replace it with a valid one.
- Frontend assets are served from `public/`; the Blade views do not use Vite, so Node is not required to run the site (Vite 6 / Tailwind 4 in `package.json` need Node 18+, while the default Laradock workspace ships Node 16).