# PROJECT.md — TeleClean Detail

## Business Context

TeleClean Detail is an automotive detailing and aesthetics business based in Belo Horizonte, MG, Brazil. The website's purpose is to:

1. Present services to potential customers.
2. Drive WhatsApp contact and appointment requests.
3. Allow customers to view slot availability and start a booking flow.
4. Support the business owner in managing the schedule.

**Business address:** Rua Benjamim Flores, 170, Santo Antônio, Belo Horizonte, MG  
**Phone / WhatsApp:** (31) 3568-3754  
**E-mail:** contato@teleclean.com.br  
**Instagram:** @teleclean_  
**Opening hours (from JSON-LD):** Mon–Sat 08:00–18:00

---

## Tech Stack (Verified)

| Layer | Technology |
|---|---|
| Language | PHP 8.3.6 (CLI confirmed; production version unconfirmed) |
| Frontend | HTML5, vanilla CSS, vanilla JavaScript (no build step, no framework) |
| Animation | GSAP 3.12.5 via jsDelivr CDN |
| Fonts | Satoshi (Fontshare CDN) + Cormorant Garamond (Google Fonts CDN) + Inter (Google Fonts CSS `@import`) |
| Data store | `data/appointments.json` (flat file; no MySQL yet) |
| Hosting | Locaweb (PHP hosting; exact plan/server type unknown) |
| Version control | Git; remote at `https://github.com/GusAlberto/teleclean-site.git` |
| Database | MySQL planned but not yet implemented |
| Notifications | WhatsApp deep-link only; no server-side email or push |

---

## Current Pages and Endpoints

| Route | File | Purpose |
|---|---|---|
| `/` | `index.php` | Landing page (hero, services, differentials, gallery, FAQ, CTA) |
| `/schedule.php` | `schedule.php` | Booking calendar view |
| `/api/appointments.php` | `api/appointments.php` | GET-only JSON endpoint for booked datetime slots |

There is no:
- Admin/owner dashboard
- Authentication page
- Password-reset flow
- Contact form (WhatsApp link is the only contact mechanism)
- Database connection
- Google Sheets integration

---

## Repository Branch Strategy (Observed)

Branches observed in git log:
- `main` — production-ready merges
- `staging` — integration testing
- `develop` — ongoing development
- Feature branches following `feat/`, `fix/`, `style/`, `docs/`, `refactor/` prefixes

---

## Environment and Configuration

- No `.env` file exists.
- No `.env.example` exists yet.
- No `.htaccess` found anywhere in the project tree.
- PHP error display configuration is **unknown** (not controlled at code level).
- No Composer, no `composer.json`, no `vendor/` directory.
- No npm/node_modules, no `package.json`.
- `.gitignore` is a Laravel 4/5 template, not tailored to this project.

---

## Known Constraints

1. **Persistence constraint:** `data/appointments.json` is currently the only data store. It must be migrated to MySQL before adding any write endpoints, authentication, or multi-user support. (See AGENTS.md.)
2. **No build pipeline:** CSS and JS are served as-is. No minification, bundling, or asset hashing.
3. **Manual appointment management:** The owner edits `data/appointments.json` directly. There is no admin UI.
4. **WhatsApp-only booking flow:** The site shows available slots but does not confirm bookings automatically. WhatsApp confirmation is required.

---

## Assumptions and Unknowns

| Item | Status |
|---|---|
| PHP version in production | UNKNOWN — CLI is 8.3.6; Locaweb plan may differ |
| Web server (Apache / LiteSpeed / Nginx) | UNKNOWN |
| PHP `display_errors` and `error_log` in production | UNKNOWN |
| MySQL version and database name | UNKNOWN — no MySQL installed yet |
| Whether `data/` is publicly accessible via HTTP | UNKNOWN — no .htaccess exists |
| SSL/HTTPS active in production | UNKNOWN — assumed yes for production hosting |
| Google Sheets integration status | NOT IMPLEMENTED |
| Cron jobs or scheduled tasks | UNKNOWN |
| CDN in front of Locaweb | UNKNOWN |
| Backup and restore procedures | UNKNOWN |
