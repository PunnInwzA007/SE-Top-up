# SE Topup

> A small PHP + MySQL top-up / digital goods storefront with an admin panel and Omise (PromptPay) payments. Docker Compose is provided for local development.

## Tech stack (auto-detected)
- PHP 8.2 + Apache (Dockerfile: builds `php:8.2-apache`)
- MySQL 8 (docker-compose service `db`)
- Omise PHP library for payments (folder: `omise/` and `config/omise.php`)
- Frontend: Bootstrap, jQuery, DataTables (under `admin/assets`, `Customer/assets`, `admin/vendor`)
- Docker Compose for local development (`docker-compose.yml`)

## Main features (inferred)
- Customer-facing storefront for games, packages and subscriptions (`Customer/`)
- Admin control panel to manage games, packages, discounts, rewards and orders (`admin/`)
- Orders, payments and transactions (`orders`, `payments`, `transactions` tables)
- Discount codes, bonus codes, gift card stock and rewards
- Payment integration via Omise (PromptPay flow) in `payment/create_charge.php`
- Database seed / schema available at `db/init.sql`

## Quickstart (Docker)
1. Build and start services:

```bash
docker-compose up --build -d
```

2. Open services in your browser:
- Web app: http://localhost/ (project mounted into the container webroot)
- Customer UI: http://localhost/Customer/
- Admin UI: http://localhost/admin/
- phpMyAdmin: http://localhost:8080 (PMA_HOST=db)

3. Database credentials (from `docker-compose.yml` / `config/db.php`):
- **Host:** db
- **User:** root
- **Password:** root
- **Database:** se_topup

Notes:
- The `db` service mounts `./db` to `/docker-entrypoint-initdb.d` so `db/init.sql` seeds the database on first startup.
- Edit `config/omise.php` to set your Omise keys before processing real payments.

## Useful examples

- Admin login (default seeded admin):

  - Username: admin
  - Password: 1234

  Visit: http://localhost/admin/login.php

- Inspect the database with phpMyAdmin: http://localhost:8080 (login as `root` / `root`).

- Create a customer account (example via the web or directly in DB):

  Generate a password hash and insert a user directly (run inside the web container):

  ```bash
  # Example (adjust quoting for Windows PowerShell)
  docker-compose exec web php -r "require '/var/www/html/config/db.php'; $h = password_hash('secret', PASSWORD_DEFAULT); $conn->query(\"INSERT INTO users (username,password) VALUES ('devuser', '$h')\"); echo 'created\n';"
  ```

- Create a charge (PromptPay) for wallet or package (requires a logged-in session):

  - Wallet: `payment/create_charge.php?amount=100`
  - Package: `payment/create_charge.php?package_id=1` (the site normally uses a checkout flow that sets `amount` and discount)

  These endpoints require an authenticated session. For manual testing you can create a user (see previous example), log in via the Customer UI and then visit the `create_charge` URL.

## Where to look in the code
- App entry points: `Customer/` (customer-facing), `admin/` (admin panel)
- Payment flow: `payment/create_charge.php`, `payment/check_status.php`
- DB config: `config/db.php`; Omise config: `config/omise.php`
- DB schema & seed: `db/init.sql`

## Security & notes
- The repo currently contains example API keys in `config/omise.php` and seeded plaintext passwords (see `db/init.sql`) — treat this as development/demo data and rotate/remove keys in production.
- If you deploy, secure the `config` files and use environment variables for secrets.

---
If you'd like, I can:
- Add environment-based configuration (read Omise keys / DB creds from env)
- Add a short Docker dev guide or healthcheck endpoints
- Harden the login/password handling and provide a small script to create test users

PRs welcome.
