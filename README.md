# ZassTech Corporate Website

A responsive corporate website built with modular PHP includes and the Tailwind CSS CDN.

## Requirements

- PHP 8.1 or newer (sessions, `random_bytes`, and JSON support)
- XAMPP, or the PHP built-in development server
- Internet access for Tailwind CSS and Google Fonts CDNs

## Run with XAMPP

1. Copy the project folder into `xampp/htdocs/zasstech`.
2. Start Apache in the XAMPP Control Panel.
3. Open `http://localhost/zasstech/`.

## Run with PHP built-in server

From this project directory, run:

```sh
php -S localhost:8000
```

Then open `http://localhost:8000/`.

## Contact form

The form validates data in the browser and again in `contact-process.php`. The handler checks the request method, session CSRF token, honeypot, field lengths, consent and allowed product values.

By default, valid submissions are saved as JSON Lines in a private temporary directory. In production, set `ZASSTECH_CONTACT_STORAGE` to a persistent directory outside the public web root with restrictive permissions. Do not commit contact submissions.

To email submissions, configure the `ZASSTECH_CONTACT_EMAIL` environment variable to a monitored address and make sure PHP mail is configured. If mail delivery is unavailable, submissions fall back to the local file. Add `storage/` to `.gitignore` in a Git checkout; do not commit contact submissions.

## Before launch

- Replace the example phone number and location with verified business details.
- Confirm the legal business name, jurisdiction, contact details and product terms on the legal pages.
- Replace the example sender domain in `contact-process.php` with a verified domain and configure SPF/DKIM/DMARC if mail is enabled.
- Protect submission storage with web-server rules and a suitable backup and retention policy.
- Configure HTTPS and production error logging.
