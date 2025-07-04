# SEO Audit App

A **web‑based SEO auditing tool** built with [Laravel 10](https://laravel.com) to help small and medium businesses diagnose and improve their on‑page search‑engine optimisation. The app analyses technical, content, and performance signals, then returns clear recommendations that non‑technical users can act on.

---

## ✨ Key Features

| Feature                                     | What it does & why it matters                                                                                           |
| ------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------- |
| **Image `alt`‑text audit**                  | Flags images missing descriptive `alt` text so visually‑impaired visitors and search crawlers understand every graphic. |
| **SEO‑friendly URL structure check**        | Detects overly long, dynamic, or keyword‑stuffed URLs and recommends concise slugs.                                     |
| **Page Speed Insights (Google Lighthouse)** | Pulls real‑time scores via the PageSpeed API and highlights slow resources.                                             |
| **Mobile‑friendliness analysis**            | Screens for viewport issues and uncrawlable mobile content.                                                             |
| **Keyword‑density report**                  | Calculates focus‑keyword density on each page and warns of over‑ or under‑optimisation.                                 |
| **Role‑based dashboards**                   | Separate admin & user portals using **Laravel Breeze** authentication scaffolding.                                      |
| **Export to PDF & CSV**                     | One‑click export of audit results for clients or teammates.                                                             |

---

## 🚀 Quick Start

### Prerequisites

* PHP ≥ 8.2 & Composer
* Node.js ≥ 18 & npm
* MySQL / MariaDB (or any DB supported by Laravel)
* Google PageSpeed API key (optional but recommended)

### Installation

```bash
# 1 Clone the repo
$ git clone https://github.com/rafliadipratama/seo-audit-app.git
$ cd seo-audit-app

# 2 Install backend dependencies
$ composer install --no-dev --optimize-autoloader

# 3 Install frontend dependencies & compile assets
$ npm install && npm run build # or `npm run dev` for hot‑reload

# 4 Configure environment
$ cp .env.example .env
$ php artisan key:generate
# Update DB_*, PAGESPEED_API_KEY, etc. in .env

# 5 Run migrations & seeders
$ php artisan migrate --seed

# 6 Serve the app
$ php artisan serve
```

Browse to **[http://127.0.0.1:8000](http://127.0.0.1:8000)** and log in with the seeded admin account.

---

## 🧩 Project Structure

```
seo-audit-app/
├─ app/        # Laravel MVC code
├─ resources/  # Blade views & Vue components
├─ database/   # Migrations & seeders
├─ public/     # Compiled assets (Vite)
└─ tests/      # Pest unit & feature tests
```

---

## 🔐 Environment Variables (.env)

| Key                 | Example value       | Description                                  |
| ------------------- | ------------------- | -------------------------------------------- |
| `APP_NAME`          | `SEO Audit App`     | App name displayed in UI                     |
| `PAGESPEED_API_KEY` | `AIzaSy...`         | Google PageSpeed Insights API key            |
| `DB_CONNECTION`     | `mysql`             | Database driver                              |
| `DB_DATABASE`       | `seo_audit`         | Database name                                |
| `ADMIN_EMAIL`       | `admin@example.com` | Default admin login                          |
| `ADMIN_PASSWORD`    | `secret`            | Default admin password (hashed on first run) |

---

## 🧪 Running Tests

```bash
php artisan test  # runs all Pest tests
```

---

## 📦 Deployment

1. Push to `main` (CI pipeline builds assets & runs tests).
2. Set up environment variables on production server.
3. Run `php artisan migrate --force` after every release.

> **Tip:** Use Laravel Forge or Ploi for zero‑downtime deploys.

---

## 🤝 Contributing

Pull requests are welcome! Please open an issue first to discuss major changes.

1. Fork the repo & create your branch: `git checkout -b feature/my-feature`
2. Commit your changes with clear messages.
3. Push the branch & open a PR.

All contributions must pass CI and follow the [PSR‑12](https://www.php-fig.org/psr/psr-12/) coding standard.

---

## 🛡️ Security Vulnerabilities

If you discover a security issue, please e‑mail **Mohamad Rafli Adipratama** at `rafliadipratama@gmail.com`. Do **not** post it in the public issue tracker.

---

## 📜 License

This project is open‑source software licensed under the [MIT License](LICENSE).
