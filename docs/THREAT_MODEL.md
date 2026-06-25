# THREAT_MODEL.md — TeleClean Detail

_Last updated: 2026-06-25 (Phase 0 assessment)_

## Risk Register

| ID | Severity | Title | Affected Files / Endpoints | Attack Scenario | Recommended Mitigation | Test Case | Status |
|---|---|---|---|---|---|---|---|
| T-001 | **HIGH** | No security HTTP headers | All pages | Attacker frames the site in an iframe (clickjacking); browser lacks XSS filter hints; no HSTS means HTTPS downgrade possible | Add `.htaccess` with CSP, HSTS, X-Content-Type-Options, X-Frame-Options, Referrer-Policy, Permissions-Policy | `curl -I https://teleclean.com.br` — verify headers present | OPEN |
| T-002 | **HIGH** | `data/` directory likely publicly accessible via HTTP | `data/appointments.json` | Attacker downloads `https://teleclean.com.br/data/appointments.json` directly; leaks all booked datetimes | Block `data/` in `.htaccess`; move sensitive files outside web root | `curl https://teleclean.com.br/data/appointments.json` — expect 403 | OPEN |
| T-003 | **MEDIUM** | No CSRF protection on future write endpoints | `api/appointments.php` (POST, when added) | Malicious site tricks authenticated owner into POSTing a fake booking | Add CSRF token validation on every state-changing request before opening POST | Attempt cross-origin POST without CSRF token — expect 403 | OPEN (not exploitable yet) |
| T-004 | **MEDIUM** | Race condition in future appointment booking | `api/appointments.php`, `data/appointments.json` | Two simultaneous POST requests for the same slot both read "available" before either writes; both succeed, creating a double-booking | Use MySQL transactions with `SELECT ... FOR UPDATE` and unique constraint | Submit 20 concurrent requests for same slot; confirm only one succeeds | OPEN (not exploitable yet) |
| T-005 | **MEDIUM** | Raw HTML echoed in FAQ answers | `index.php:341` | If FAQ answers ever move to user-supplied or database-sourced content, stored XSS becomes possible | Escape with `htmlspecialchars(ENT_QUOTES, UTF-8)` or use a safe HTML allowlist for formatting tags only | Inject `<script>alert(1)</script>` into an answer; verify it does not execute | OPEN (currently low risk — data is hardcoded) |
| T-006 | **MEDIUM** | GSAP CDN script loaded without Subresource Integrity | `includes/head.php:35` | If jsDelivr CDN is compromised or MITM'd, attacker injects malicious JavaScript into every page load | Add `integrity` and `crossorigin` attributes with the correct SHA-384 hash | Verify `integrity` attribute present in page source | OPEN |
| T-007 | **LOW** | No rate limiting on API or public endpoints | `/api/appointments.php`, all pages | Automated bot enumerates all booked datetimes; floods server | Add rate limiting at `.htaccess` / web server level (or PHP-level with IP tracking after MySQL migration) | Send 100 requests/second to `/api/appointments.php`; expect 429 after threshold | OPEN |
| T-008 | **LOW** | PHP `display_errors` status unknown in production | Server configuration | Unhandled exception leaks file paths, PHP version, and stack traces to the browser | Confirm `display_errors=Off` and `log_errors=On` in production `php.ini` or `.htaccess` | Trigger a PHP error; verify no stack trace in response body | UNKNOWN |
| T-009 | **LOW** | Directory listing status unknown | Web root, `assets/`, `api/`, `data/` | Attacker browses `https://teleclean.com.br/assets/img/` and sees all image filenames | Add `Options -Indexes` in `.htaccess` | Request a directory URL; expect 403 or 404, not a file listing | UNKNOWN |
| T-010 | **LOW** | `.gitignore` is a Laravel template; may miss project-specific paths | `.gitignore` | Developer accidentally commits `data/appointments.json` with real customer bookings, or a future `.env` with database credentials | Replace with a project-specific `.gitignore` that excludes `data/`, `.env`, Google service account JSON, logs | Review git status after adding sensitive files; verify they are ignored | OPEN |
| T-011 | **MEDIUM** | No authentication for appointment management | Entire site | Owner must edit `data/appointments.json` manually; no access control means any developer with repo access can modify booking data | Implement owner authentication (Phase 3) | Attempt to access `/admin/` without credentials — expect redirect to login | OPEN (planned) |
| T-012 | **LOW** | Leftover test/temporary files in `assets/img/` | `assets/img/` | Test files (`placeholder-errado.svg`, `temporary-image.svg`, `teste-favicon.svg`, `example-service-cristalizacao.jpg`, `preto.svg`, `gallery-00.jpg`) visible to the public | Delete or move to a non-public location | Directory listing check; verify files return 404 or are removed | OPEN |
| T-013 | **LOW** | `@mkdir` error suppression in API | `api/appointments.php:6` | Suppressed mkdir failure means the data directory silently fails to create; subsequent `file_put_contents` may leak a PHP warning | Remove `@` operator; handle errors explicitly with logging | Simulate missing directory; verify graceful error response | OPEN |
| T-014 | **INFO** | OG image URL is relative | `index.php:5`, `schedule.php:4` | Social media crawlers may not resolve relative paths; `og:image` renders incorrectly when shared | Set `$ogImage` to absolute URL (`https://www.teleclean.com.br/assets/img/og-cover.jpg`) | Test URL in Facebook Sharing Debugger | OPEN |
| T-015 | **INFO** | `includes/` PHP files directly requestable | `includes/head.php`, `includes/header.php`, `includes/footer.php` | Direct request to `https://teleclean.com.br/includes/head.php` renders a partial HTML document; discloses structure | Block `includes/` in `.htaccess` | `curl https://teleclean.com.br/includes/head.php` — expect 403 | OPEN |

---

## Threat Actors

| Actor | Motivation | Likelihood |
|---|---|---|
| Automated scanner / bot | Find misconfigured endpoints, common vulnerabilities | HIGH |
| Competitor | Enumerate booked slots to infer business volume | MEDIUM |
| Script kiddie | Opportunistic XSS / injection testing | MEDIUM |
| Malicious customer | Book same slot multiple times, disrupt business | LOW (no POST yet) |
| Insider (developer) | Accidental credential or data commit | LOW |

---

## Assets to Protect

| Asset | Sensitivity | Current Protection |
|---|---|---|
| `data/appointments.json` | LOW (datetimes only, no PII) | NONE — publicly readable via HTTP |
| Owner credentials | CRITICAL | N/A — not yet implemented |
| Business phone / email | PUBLIC | Intentionally published |
| Google service account key | CRITICAL | Not yet obtained |
| Source code | LOW | Private GitHub repo |
| Customer booking details (future) | HIGH | Not yet collected |

---

## Assumptions

- The current site collects no PII; the only data stored is booked datetime strings with no customer identification.
- The booking flow redirects to WhatsApp; TeleClean does not store customer names, phones, or vehicle data server-side at this time.
- These assumptions must be revisited before Phase 4 (server-side booking) is implemented.
