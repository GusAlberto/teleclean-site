# ROADMAP.md — TeleClean Detail

## Overview

Each phase is a prerequisite for the next. A phase is not complete until its Definition of Done (from AGENTS.md) is satisfied: tests pass, security controls verified, documentation updated, commit created.

---

## Phase 0 — Codebase Assessment (Current)

**Goal:** Understand the existing codebase without changing application code.

**Deliverables:**
- [x] Read and understood AGENTS.md
- [x] Inspected all PHP, JS, CSS, data, and config files
- [x] Populated planning/ and docs/ documentation
- [ ] Confirmed server environment details (PHP production version, web server, MySQL version) — needs owner input

**Definition of Done:** All documentation files populated with verified findings. No application code changed.

---

## Phase 1 — Baseline Security and Infrastructure

**Goal:** Fix the most critical security and infrastructure gaps that exist today, before adding any new features.

**Tasks:**
1. Create `.htaccess` with:
   - Security response headers (CSP, HSTS, X-Content-Type-Options, X-Frame-Options, Referrer-Policy, Permissions-Policy)
   - Block direct access to `data/` directory
   - Block direct access to `includes/` directory
   - Disable directory listing
   - Custom 404 page
   - Force HTTPS redirect
2. Fix `robots.txt` to disallow `/data/`, `/api/`, `/includes/`
3. Add `sitemap.xml` entry for `schedule.php` or add `noindex` meta — decision needed from owner
4. Add Subresource Integrity (SRI) hashes for GSAP CDN script
5. Fix OG image URLs to use absolute paths in `index.php` and `schedule.php`
6. Fix `@type: "AutoDetailing"` in JSON-LD to use a valid Schema.org type
7. Add FAQPage JSON-LD to `index.php`
8. Clean up leftover test/temporary files from `assets/img/`
9. Replace Laravel `.gitignore` template with project-specific version
10. Create `.env.example`
11. Create `security.txt`
12. Confirm `display_errors=Off` in production (owner action)
13. Refactor footer: remove inline footer from `index.php` and use `includes/footer.php` consistently

**Tests required:** Security header verification, robots.txt validation, sitemap validation, SRI check, PHP lint.

---

## Phase 2 — MySQL Migration

**Goal:** Replace `data/appointments.json` with a MySQL database for safe, concurrent, auditable data storage.

**Prerequisite:** MySQL credentials and database on Locaweb confirmed by owner.

**Tasks:**
1. Create `db/migrations/001_create_appointments_table.sql`
2. Create `includes/db.php` — PDO connection using environment variables, emulated prepares disabled
3. Migrate existing `appointments.json` data to database
4. Update `api/appointments.php` to query MySQL with prepared statements
5. Add database-level unique constraint on `(appointment_datetime)` to prevent duplicates
6. Document rollback: keep JSON file as backup, provide restore script
7. Run concurrency tests: simultaneous requests for the same slot

**Risks:** Locaweb shared hosting MySQL limitations; connection pool size; timezone handling.

---

## Phase 3 — Owner Authentication and Dashboard

**Goal:** Allow the business owner to log in securely and manage the appointment schedule.

**Tasks:**
1. Create `admin/login.php` with rate-limited login form and CSRF protection
2. Create `admin/dashboard.php` — view, add, and cancel appointment slots
3. Implement session management: `session_regenerate_id(true)` on login, secure/httponly/samesite cookies
4. Password stored with `password_hash(PASSWORD_ARGON2ID)`
5. All admin endpoints check authentication before any action (deny-by-default)
6. Add `noindex` meta to all admin pages
7. Add `/admin/` to `robots.txt` Disallow

**Tests required:** Authentication bypass attempts, session fixation, privilege escalation, CSRF on admin actions.

---

## Phase 4 — Server-Side Appointment Booking

**Goal:** Replace the WhatsApp-only flow with a server-side booking creation that is concurrency-safe.

**Tasks:**
1. `POST /api/appointments.php` — validate input, check slot availability inside a MySQL transaction, insert, return result
2. CSRF token on booking form
3. Idempotency key to prevent duplicate submissions
4. Server-side allowlist validation for service, date, and time
5. Confirmation message on success; clear conflict message on double-book
6. Rate limit booking requests per IP

**Tests required:** Double-booking concurrency test, CSRF bypass attempt, oversized payload, invalid service/date/time values.

---

## Phase 5 — Google Sheets Synchronization

**Goal:** Mirror new appointments to Google Sheets for owner visibility.

**Tasks:**
1. Service account key stored outside web root, outside version control
2. `includes/sheets.php` — async or queued sync; does not block the booking response
3. Idempotent sync: use appointment ID to avoid duplicate rows
4. Log sync failures; provide owner-visible retry indicator
5. Handle API timeout and credential-missing scenarios gracefully

**Tests required:** API failure (mock), timeout, retry, duplicate delivery, missing credential.

---

## Phase 6 — SEO and Performance Hardening

**Goal:** Achieve strong Lighthouse scores and correct technical SEO.

**Tasks:**
1. Convert images to WebP; provide `<picture>` with JPEG fallback
2. Minify CSS and JS (build step or manual)
3. Self-host or preload fonts to eliminate render-blocking CDN requests
4. Implement cache-control headers for static assets via `.htaccess`
5. Add `<link rel="preload">` for LCP image
6. Add `lastmod` to sitemap entries
7. Measure and address CLS sources
8. Lighthouse and accessibility audit

---

## Phase 7 — Testing and Quality Gates

**Goal:** Automated test suite covers security, functionality, concurrency, SEO.

**Tasks:**
1. PHPUnit unit tests: input validation, conflict calculation
2. Integration tests: booking flow, auth flow, CSRF, IDOR
3. Security tests: SQLi payloads, XSS, rate-limit bypass
4. Concurrency tests: simultaneous booking for same slot
5. SEO/accessibility tests: broken links, missing meta, sitemap validity
6. CI pipeline on GitHub Actions: lint, test, security scan on every PR

---

## Phase 8 — Operations and Monitoring

**Goal:** Production is observable, backed up, and has an incident response plan.

**Tasks:**
1. Error logging to a file outside web root; log rotation configured
2. Monitor appointment sync failures
3. Monitor authentication anomalies
4. Backup schedule for MySQL database
5. Confirm staging environment (or document safe production verification plan)
6. Complete `docs/OPERATIONS.md` and `docs/ROLLBACK.md`
