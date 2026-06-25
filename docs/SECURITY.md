# SECURITY.md — TeleClean Detail

_Last updated: 2026-06-25 (Phase 0 assessment)_

## Current Security Posture

The application is currently a read-only marketing site with a JSON-backed calendar. The attack surface is narrow because there are no write endpoints, no authentication, no database, and no user-supplied data stored server-side. However, several baseline controls are missing that must be in place before any feature addition.

---

## Security Controls — Status

| Control | Status | Location | Notes |
|---|---|---|---|
| PHP syntax — no errors | PASS | All PHP files | Verified with `php -l` |
| Output escaping in PHP | PASS (partial) | `includes/head.php` | Meta tags escaped with `htmlspecialchars(ENT_QUOTES, UTF-8)` |
| Raw HTML in FAQ answers | RISK | `index.php:341` | `echo $answer` outputs raw HTML; currently safe because data is hardcoded, but must be escaped or sanitized before any dynamic content is introduced |
| CSRF protection | MISSING | — | No forms with state change exist yet, but must be added before Phase 4 |
| Security HTTP headers | MISSING | — | No `.htaccess`; no CSP, HSTS, X-Content-Type-Options, X-Frame-Options, Referrer-Policy |
| `data/` directory protection | UNKNOWN | `data/` | No `.htaccess` found; direct HTTP access to `appointments.json` is likely possible |
| `includes/` directory protection | UNKNOWN | `includes/` | Same concern — PHP files in `includes/` should not be directly accessible |
| Directory listing disabled | UNKNOWN | Web root | No `.htaccess` to disable it |
| Subresource Integrity (SRI) | MISSING | `includes/head.php:35` | GSAP loaded from jsDelivr CDN without SRI hash |
| PHP `display_errors` | UNKNOWN | Server config | Not controlled in code; must be Off in production |
| HTTPS enforcement | UNKNOWN | Server/`.htaccess` | Assumed active via Locaweb hosting; no redirect rule confirmed |
| Authentication | NOT IMPLEMENTED | — | No owner login exists |
| Authorization | NOT IMPLEMENTED | — | No access control on any endpoint |
| Rate limiting | NOT IMPLEMENTED | — | No throttling on API or page loads |
| Input validation (server-side) | NOT IMPLEMENTED | — | API returns data without sanitisation (GET only; no user input accepted) |
| SQL injection | N/A | — | No database queries exist yet |
| Session security | N/A | — | No sessions used yet |
| Secret management | N/A | — | No credentials in codebase; no `.env` needed yet |
| `.gitignore` coverage | PARTIAL | `.gitignore` | Laravel template; missing project-specific paths like `/data/` |

---

## Phase 1 Remediations (Immediate)

### 1. Add `.htaccess`

Minimum content required:

```apache
# Force HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Security headers
Header always set X-Content-Type-Options "nosniff"
Header always set X-Frame-Options "DENY"
Header always set Referrer-Policy "strict-origin-when-cross-origin"
Header always set Permissions-Policy "camera=(), microphone=(), geolocation=()"
Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
Header always set Content-Security-Policy "default-src 'self'; script-src 'self' https://cdn.jsdelivr.net https://api.fontshare.com 'unsafe-inline'; style-src 'self' https://api.fontshare.com https://fonts.googleapis.com 'unsafe-inline'; font-src 'self' https://api.fontshare.com https://fonts.gstatic.com; img-src 'self' data: https:; frame-src https://www.google.com; connect-src 'self';"

# Block direct access to sensitive directories
<FilesMatch "^">
    Order allow,deny
    Allow from all
</FilesMatch>

# Disable directory listing
Options -Indexes

# Block access to data directory
<IfModule mod_rewrite.c>
    RewriteRule ^data/ - [F,L]
    RewriteRule ^includes/ - [F,L]
</IfModule>

# Custom error pages
ErrorDocument 404 /404.php
ErrorDocument 403 /403.php
```

Note: CSP must be tested against the actual page to avoid breaking GSAP, Google Maps iframe, fonts, and inline styles. Inline styles are currently used in `index.php` and `footer.php`.

### 2. Add SRI hash to GSAP

Replace:
```html
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js" defer></script>
```

With:
```html
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"
        integrity="sha384-[HASH]"
        crossorigin="anonymous"
        defer></script>
```

The correct SRI hash must be generated from the actual file content.

### 3. Fix raw HTML in FAQ

In `index.php:341`, change:
```php
<p><?php echo $answer; ?></p>
```
to:
```php
<p><?php echo htmlspecialchars($answer, ENT_QUOTES, 'UTF-8'); ?></p>
```

**Exception:** The last FAQ item uses `<strong>` tags in the answer strings. These must be either allowed via a safe HTML allowlist or restructured as separate data keys.

---

## Future Security Requirements (Phase 3+)

When authentication is implemented:

- `password_hash($password, PASSWORD_ARGON2ID)` — fall back to `PASSWORD_BCRYPT` if Argon2id unavailable.
- `password_verify($input, $hash)` for verification.
- `session_regenerate_id(true)` immediately after successful login.
- Session cookies: `Secure`, `HttpOnly`, `SameSite=Lax`.
- Absolute session timeout (e.g., 8 hours) and inactivity timeout (e.g., 30 minutes).
- Login rate limiting: max 5 attempts per IP per 15 minutes; lockout or CAPTCHA after threshold.
- Password-reset tokens: random 32 bytes via `random_bytes()`, stored hashed, single-use, expire in 1 hour.
- Generic error messages: do not reveal whether email exists.

When booking POST endpoint is implemented:

- CSRF token per form submission.
- Server-side service allowlist validation.
- Date/time range and format validation.
- MySQL transaction wrapping the availability check and insert (prevents race condition).
- Idempotency key (e.g., UUID in hidden form field) to prevent duplicate submissions.
- Input length limits enforced server-side before database insertion.
