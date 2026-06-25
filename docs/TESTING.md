# TESTING.md — TeleClean Detail

_Last updated: 2026-06-25 (Phase 0 assessment)_

## Current Test Infrastructure

**No automated tests exist.** The only testing tool referenced in `README.md` is manual PHP linting (`php -l`) and JavaScript syntax checking (`node --check`).

---

## Tests Run in Phase 0

### PHP Lint

All PHP files passed `php -l` with no syntax errors:

```bash
php -l index.php             # No syntax errors detected
php -l schedule.php          # No syntax errors detected
php -l api/appointments.php  # No syntax errors detected
php -l includes/head.php     # No syntax errors detected
php -l includes/header.php   # No syntax errors detected
php -l includes/footer.php   # No syntax errors detected
```

PHP version in use: **8.3.6** (CLI; production version unconfirmed).

### JavaScript Syntax

Not run. Can be verified with:
```bash
node --check assets/js/main.js
```

### Security Header Check

Not yet run. Target command after Phase 1 `.htaccess` is deployed:
```bash
curl -I https://www.teleclean.com.br/
```
Expected headers: `Content-Security-Policy`, `Strict-Transport-Security`, `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`, `Permissions-Policy`.

### Endpoint Accessibility Check

Not yet run. After Phase 1, run:
```bash
curl -o /dev/null -s -w "%{http_code}" https://www.teleclean.com.br/data/appointments.json
# Expected: 403
curl -o /dev/null -s -w "%{http_code}" https://www.teleclean.com.br/includes/head.php
# Expected: 403
```

---

## Test Plan by Phase

### Phase 1 — Baseline Security

| Test | Method | Expected Result |
|---|---|---|
| Security headers present | `curl -I https://…` | All 6 headers present |
| `data/` blocked | `curl` direct URL | HTTP 403 |
| `includes/` blocked | `curl` direct URL | HTTP 403 |
| Directory listing disabled | Browse to `assets/img/` | HTTP 403, no file list |
| HTTPS redirect | `curl -I http://…` | HTTP 301 → HTTPS |
| PHP lint | `php -l *.php` | All pass |
| robots.txt valid | Google Search Console or manual review | All Disallow rules present |
| sitemap.xml valid | XML validation; sitemap linting tool | Valid XML; all URLs canonical |
| JSON-LD structured data valid | Google Rich Results Test | No errors on AutomotiveBusiness and FAQPage |
| OG image absolute URL | View page source | `og:image` contains `https://` |
| SRI hash on GSAP | View page source | `integrity` attribute present |

### Phase 2 — MySQL Migration

| Test | Method | Expected Result |
|---|---|---|
| GET /api/appointments.php returns JSON | `curl /api/appointments.php` | Valid JSON array |
| SQL injection on GET params | Send `'; DROP TABLE appointments; --` in any param | No error; query unaffected |
| Existing appointments data migrated | Compare DB rows to original JSON | Count matches |
| Unique constraint on datetime | Insert duplicate datetime in DB | MySQL error; graceful 409 from API |
| Race condition — concurrent reads | 10 parallel `curl` requests | All return same data; no corruption |

### Phase 3 — Authentication

| Test | Method | Expected Result |
|---|---|---|
| Login with correct credentials | POST to `/admin/login.php` | Session created; redirect to dashboard |
| Login with wrong credentials | POST wrong password | HTTP 401; no session; generic error message |
| Session fixation | Capture session ID before login; attempt to use after login | Session ID changes on login |
| Access dashboard without login | GET `/admin/dashboard.php` | Redirect to login page |
| CSRF on login form | POST without CSRF token | HTTP 403 |
| Brute-force protection | 6 rapid login attempts | HTTP 429 on 6th attempt |
| SQL injection on login form | `' OR 1=1 --` in email field | No login; query unaffected |
| XSS in login error message | `<script>alert(1)</script>` in email field | Escaped output; no execution |
| Password stored hashed | Inspect DB `password` column | Argon2id or bcrypt hash, not plaintext |

### Phase 4 — Server-Side Booking (POST)

| Test | Method | Expected Result |
|---|---|---|
| Book available slot | POST valid service + datetime | HTTP 201; slot marked booked |
| Book already-booked slot | POST same slot twice sequentially | HTTP 409 with clear conflict message |
| Double-book concurrency | 20 simultaneous POST requests for same slot | Exactly 1 succeeds (201); rest get 409 |
| CSRF bypass | POST without CSRF token | HTTP 403 |
| Invalid service value | POST `service=INVALID` | HTTP 422; validation error |
| Past datetime | POST `2020-01-01T08:00:00` | HTTP 422; validation error |
| Oversized payload | POST body > 10 KB | HTTP 413 or 422 |
| Duplicate submission (idempotency) | Re-POST same idempotency key | Second request returns same 201; no duplicate row |
| XSS in notes field | `<script>alert(1)</script>` in notes | Escaped in response and storage |

### Phase 5 — Google Sheets Sync

| Test | Method | Expected Result |
|---|---|---|
| Sync on booking | Book a slot; check Google Sheet | Row appears in sheet |
| API failure | Mock Sheets API timeout | Booking still succeeds; failure logged |
| Duplicate row prevention | Re-sync same appointment ID | No duplicate row in sheet |
| Missing credential | Remove service account key | Graceful failure; admin alert |

### Security Tests (All Phases)

| Test | Method | Expected Result |
|---|---|---|
| Reflected XSS | Inject `<script>` into URL params / query strings | No execution |
| Stored XSS | Submit `<script>` as booking note | Escaped in all views |
| IDOR / BOLA | Access another user's appointment by guessing ID | HTTP 403 |
| Privilege escalation | Access `/admin/` as guest | Redirect to login |
| Rate-limit bypass | Send requests from multiple IPs | Rate limit per IP enforced |
| Security header regression | After each phase deploy | All headers still present |

### SEO Tests

| Test | Method | Expected Result |
|---|---|---|
| Structured data valid | Google Rich Results Test | No critical errors |
| Sitemap valid | XML validator | Well-formed; all URLs return 200 |
| robots.txt valid | Google Search Console | No errors |
| Broken links | `wget --spider` or Screaming Frog | No 4xx/5xx on linked pages |
| Canonical correct | View page source | Canonical matches actual URL |
| OG image resolves | Fetch `og:image` URL | HTTP 200 |

### Accessibility Tests

| Test | Method | Expected Result |
|---|---|---|
| Keyboard navigation | Tab through all interactive elements | Logical focus order; no keyboard traps |
| Screen reader on FAQ | NVDA/VoiceOver + FAQ | Questions announced; answers expand on Enter |
| Skip link | Tab from page start | Skip link visible and functional |
| Color contrast | axe DevTools or Lighthouse | No critical contrast failures |
| Mobile responsiveness | Chrome DevTools device emulation | No horizontal scroll; text readable |
| Prefers-reduced-motion | Set OS preference | Animations disabled; content still visible |

---

## Tools Required

| Tool | Purpose | Install |
|---|---|---|
| `php -l` | PHP syntax check | Built-in |
| `node --check` | JS syntax check | Built-in (Node 18 installed) |
| PHPUnit | Unit + integration tests | `composer require --dev phpunit/phpunit` |
| curl | HTTP endpoint testing | System |
| axe DevTools | Accessibility testing | Browser extension |
| Google Rich Results Test | JSON-LD validation | Web tool |
| Lighthouse | Performance + SEO + accessibility | Chrome DevTools |
| Screaming Frog or `wget --spider` | Broken link check | Download |

---

## Known Limitations

- No test suite exists; all tests above are manual or future-state.
- No staging environment confirmed; production verification plan needed before any deployment.
- Concurrency tests for JSON file store cannot be reliable; they validate the existing vulnerability rather than a fix.
- PHP lint does not catch logic errors, authorization flaws, or output-encoding gaps.
