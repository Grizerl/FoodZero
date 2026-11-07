## Food Zero

Food Zero is a modern and eco-friendly restaurant that offers a healthy, zero-waste dining experience. Focused on sustainability, it serves fresh, organic, and locally sourced meals in a minimalist yet cozy environment. With a menu inspired by global cuisines, Food Zero caters to all dietary preferences, including vegan, vegetarian, and gluten-free options.

## Technologies Used

- **Laravel**: Backend framework for routing, models, controllers, and database management.
- **Blade**: Templating engine used for rendering views.
- **MySQL**: Database system for storing menu, blog, reservation, subscriber and user data.
- **SCSS**: Styles live in `resources/scss/` and are compiled to committed static CSS in `public/assets/css/` (see [Styles](#styles-scss)).
- **Sanctum**: Token-protected JSON API (`routes/api.php`).

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
### Styles (SCSS)

Public-site and login styles are written in SCSS (`resources/scss/`) and compiled to static CSS in `public/assets/css/` (same paths the Blade views already link). The compiled CSS **is committed**, so the Laradock containers need no Node build.

- Run on the **host** (Node 20+), not in `workspace-84` (Node 16): `npm install`, then `npm run scss:build` (or `npm run scss:watch`).
- Never edit `public/assets/css/**` by hand: edit the SCSS and rebuild. Every compiled file starts with a "Compiled from …" banner.
- The build is deterministic: running it twice without changes leaves `git diff` empty.
- `sass` is pinned (`1.89.2`) because newer releases need a newer Node than the host currently provides.
- The admin theme is `resources/scss/admin.scss` → `public/assets/css/admin.css`, loaded after AdminLTE's `adminlte.min.css`. Restyle AdminLTE there; the vendor files in `public/admin/**` are never edited.
- Layout: `abstracts/` (tokens, mixins, breakpoints), `base/`, `components/` (shared partials: buttons, cards, header, footer, banners), `pages/`, `auth/`. Colors, radii and shadows come from `abstracts/_tokens.scss`; breakpoints only through `respond-down(xs|sm|md|lg|xl|xxl)`.

### Visual audit

`tools/visual-audit` (headless Chrome via `puppeteer-core`) captures every public page at 375/768/1024/1440 px, checks console errors, 404s, horizontal scroll, `h1` count and overlaps, and pixel-diffs two screenshot sets. See the header of `audit.mjs`; run `npm install` inside that folder first.

### Reservations

Guests book through the form on the contact/home pages (`public/assets/js/reservation.js`). Bookable slots, open days and the booking window are set in `config/reservations.php` (one table per slot per date); the logic is in `app/Services/ReservationSchedule.php`.

### Newsletter

The footer form subscribes with double opt-in (signed confirmation link, welcome mail, signed one-click unsubscribe). Admins manage subscribers and send campaigns at `/dashboard/newsletters`. Mails are queued: run `php artisan queue:work` in `workspace-84`. With `MAIL_MAILER=log` (the default in `.env.example`) mails only land in `storage/logs`; configure a real SMTP `MAIL_*` block to deliver them.

### Demo content and keys

- A fresh database has no menu and no blog posts, so those pages are empty. Load demo data (idempotent, creates no users): `php artisan db:seed --class=DemoContentSeeder` (inside `workspace-84`). It is deliberately not part of `DatabaseSeeder`.
- The admin TinyMCE editor reads its API key from `TINYMCE_API_KEY` in `.env` (`config('services.tinymce.key')`); `.env.example` leaves it empty.
