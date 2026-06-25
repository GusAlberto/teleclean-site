# ARCHITECTURE.md — TeleClean Detail

_Last updated: 2026-06-25 (Phase 0 assessment)_

## System Overview

TeleClean Detail is a server-rendered PHP website with no framework. Pages are composed by including shared PHP partials. There is no build step, no bundler, no dependency manager (Composer or npm), and no database connection. All booking data is stored in a flat JSON file.

```
Browser
  │
  │  HTTP GET /
  │  HTTP GET /schedule.php
  │  HTTP GET /api/appointments.php
  ▼
Locaweb PHP Hosting (Apache or LiteSpeed — unconfirmed)
  │
  ├── index.php           ──► includes/head.php, includes/header.php
  │                            (footer is inline in index.php)
  ├── schedule.php        ──► includes/head.php, includes/header.php, includes/footer.php
  └── api/appointments.php ──► data/appointments.json (file read)
```

---

## File Structure (Verified)

```
teleclean_site/
├── api/
│   └── appointments.php       GET-only API; reads booked slots from JSON
├── assets/
│   ├── css/
│   │   └── style.css          All styles; ~100+ lines; CSS custom properties
│   ├── img/                   Static images (JPEG + SVG)
│   ├── js/
│   │   └── main.js            All client-side behavior (~280 lines)
│   └── video/
│       └── hero-detail.mp4    Hero background video
├── data/
│   └── appointments.json      Array of ISO datetime strings for booked slots
├── includes/
│   ├── head.php               HTML <head>; meta, OG, JSON-LD, fonts, CSS, JS
│   ├── header.php             Site header and navigation
│   └── footer.php             Shared footer (used by schedule.php only)
├── index.php                  Landing page (includes own inline footer)
├── schedule.php               Booking calendar page
├── structure.md               Original design-time file tree (may be stale)
├── robots.txt
├── sitemap.xml
├── .gitignore                 Laravel template (not project-specific)
└── README.md                  Developer documentation
```

**Note:** `index.php` contains its own footer inline. `includes/footer.php` is used only by `schedule.php`. Both footers must be kept in sync manually — a maintenance risk.

---

## Component Relationships

### Page Composition

```
index.php
├── $pageTitle, $pageDescription, $canonicalUrl, $ogImage (set at top)
├── include includes/head.php   → outputs <!DOCTYPE html> through </head>
├── <body>
├── include includes/header.php → site header + nav
├── <main>
│   ├── $faqItems PHP array   → drives FAQ section
│   └── Sections: hero, services, differentials, before/after,
│                 process, testimonials, gallery, FAQ, CTA
├── <footer> (inline — duplicated from includes/footer.php)
└── </html>

schedule.php
├── $pageTitle, $pageDescription, $canonicalUrl, $ogImage (set at top)
├── include includes/head.php
├── <body>
├── include includes/header.php
├── <main> → calendar UI
├── <script> → fetchAppointments() + calendar rendering (inline JS, ~120 lines)
├── include includes/footer.php
└── </html>
```

### Data Flow

```
Customer browser
  │
  │ 1. GET /schedule.php  → PHP renders calendar shell
  │
  │ 2. JS: fetch('/api/appointments.php')
  │       → PHP reads data/appointments.json
  │       → returns JSON array of ISO datetime strings
  │
  │ 3. JS: renders calendar with fill percentages
  │
  │ 4. Customer clicks available slot
  │       → window.open(wa.me/…) — no server-side booking
  │
WhatsApp (external)
```

---

## External Dependencies

| Dependency | How Used | Risk |
|---|---|---|
| GSAP 3.12.5 (jsDelivr CDN) | 3D service carousel animations | CDN compromise; no SRI hash |
| Satoshi (Fontshare CDN) | Body and heading font | CDN availability; render-blocking |
| Cormorant Garamond (Google Fonts CDN) | Display/decorative font | CDN availability; render-blocking |
| Inter (Google Fonts via CSS @import) | Fallback body font | render-blocking @import |
| Google Maps Embed | Footer map | iframe; no API key exposed |
| WhatsApp (wa.me) | All booking and contact CTAs | Third-party; no direct integration |

---

## Current Data Model

`data/appointments.json` is an array of ISO 8601 local datetime strings (no timezone suffix):

```json
[
    "2026-06-10T08:00:00",
    "2026-06-10T09:00:00",
    "2026-06-11T14:00:00"
]
```

- No customer data stored.
- No service type stored per booking.
- No unique IDs.
- No status field (pending / confirmed / cancelled).
- No timezone — implicit local time (Brasília, UTC-3).
- No locking on file reads or writes.

---

## Planned Data Model (MySQL — Phase 2)

```sql
CREATE TABLE appointments (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    service       VARCHAR(100)     NOT NULL,
    appointment_at DATETIME        NOT NULL,
    status        ENUM('pending','confirmed','cancelled') NOT NULL DEFAULT 'pending',
    created_at    DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_appointment_at (appointment_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

Customer PII (name, phone, vehicle) will be added only when a server-side booking form is built (Phase 4).

---

## Architecture Gaps and Technical Debt

| Gap | Impact | Phase |
|---|---|---|
| No `.htaccess` | No security headers, directory listing potentially enabled | Phase 1 |
| Duplicate footer | Maintenance risk; desync likely | Phase 1 |
| Inline JS in `schedule.php` (~120 lines) | Mixed concerns; harder to test | Phase 4 |
| Inline styles in `index.php` and `footer.php` | CSP `unsafe-inline` required; limits header security | Phase 1/6 |
| GSAP loaded from external CDN | No SRI; supply-chain risk | Phase 1 |
| Fonts from two CDNs + CSS @import | Three separate render-blocking requests | Phase 6 |
| No Composer / autoloader | All includes are manual; no autoloading | Phase 2+ |
| `@` error suppression in `api/appointments.php:6` | Silent failures; debugging harder | Phase 1 |
| No timezone handling | `appointments.json` uses implicit local time | Phase 2 |

---

## Authentication Architecture (Planned — Phase 3)

No authentication exists. When implemented:

- Sessions via PHP native sessions with `session_set_cookie_params(['secure'=>true,'httponly'=>true,'samesite'=>'Lax'])`.
- Roles: Guest (public) and Owner/Admin.
- Protected routes in `admin/` directory; `includes/auth.php` guard included at the top of each.
- Session data: `$_SESSION['user_id']`, `$_SESSION['role']`, `$_SESSION['last_activity']`.
- No customer accounts in scope for now.
