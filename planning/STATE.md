# STATE.md — Current State Audit

_Last updated: 2026-06-25 (Phase 0 assessment)_

---

## Summary

The site is a functional marketing landing page with a read-only appointment calendar. It has no backend booking logic, no authentication, no database, and no security hardening. It is safe to run in its current form only because the single write operation (managing `appointments.json`) is done manually by the owner and the public API is read-only.

The critical path before adding any write endpoints or multi-user features is: **MySQL migration → authentication → server-side booking**.

---

## Implemented Features

| Feature | File(s) | Notes |
|---|---|---|
| Landing page with sections | `index.php` | Hero, services, differentials, gallery, FAQ, CTA |
| 3D service carousel | `index.php`, `main.js` | GSAP-powered; keyboard and drag support |
| Mobile-responsive navigation | `header.php`, `main.js`, `style.css` | Hamburger menu with ARIA |
| Scheduling calendar | `schedule.php` | Read-only; no server-side booking |
| Booked slot API | `api/appointments.php` | GET only; reads from JSON file |
| FAQ accordion | `index.php`, `main.js` | Accessible; ARIA expanded/controls |
| WhatsApp deep-links | All pages | Pre-filled messages per service |
| JSON-LD structured data | `includes/head.php` | Business info present; type incorrect |
| OG / Twitter Card meta | `includes/head.php` | Present; OG image URL is relative |
| Canonical URL | `includes/head.php` | Set per page |
| robots.txt | `robots.txt` | Allows all; missing Disallow rules |
| sitemap.xml | `sitemap.xml` | Only homepage; missing schedule.php |
| Skip link | `index.php` | Present |
| Smooth-scroll navigation | `main.js` | Cross-page hash navigation handled |
| Reveal animations | `main.js` | IntersectionObserver; respects prefers-reduced-motion |
| Image error fallback | `main.js` | Falls back to `placeholder.svg` |

---

## Missing / Not Implemented

| Feature | Priority | Phase |
|---|---|---|
| MySQL database | CRITICAL | Phase 2 |
| Owner authentication | CRITICAL | Phase 3 |
| Owner dashboard | HIGH | Phase 3 |
| Server-side booking (POST) | HIGH | Phase 4 |
| CSRF protection | HIGH | Phase 4 |
| Security HTTP headers (.htaccess) | HIGH | Phase 1 |
| Rate limiting | HIGH | Phase 1–4 |
| Google Sheets sync | MEDIUM | Phase 5 |
| Email/WhatsApp notifications | MEDIUM | Phase 5 |
| WebP images | MEDIUM | Phase 6 |
| Minified assets | LOW | Phase 6 |
| Self-hosted fonts | LOW | Phase 6 |
| Automated test suite | HIGH | Phase 7 |
| CI pipeline | HIGH | Phase 7 |
| Monitoring and alerting | MEDIUM | Phase 8 |
| `.env.example` | HIGH | Phase 1 |
| `.htaccess` | HIGH | Phase 1 |
| `security.txt` | LOW | Phase 1 |

---

## File Health Check

| File | PHP Lint | Notes |
|---|---|---|
| `index.php` | PASS | |
| `schedule.php` | PASS | |
| `api/appointments.php` | PASS | |
| `includes/head.php` | PASS | |
| `includes/header.php` | PASS | |
| `includes/footer.php` | PASS | |

### Known Asset Issues

| Issue | Severity |
|---|---|
| `assets/img/hero-poster.jpg` is referenced in `index.php` but not present in `assets/img/` | MEDIUM |
| `assets/img/og-cover.jpg` referenced in all pages but not confirmed present | MEDIUM |
| Leftover test files: `placeholder-errado.svg`, `temporary-image.svg`, `teste-favicon.svg`, `example-service-cristalizacao.jpg`, `preto.svg` | LOW |
| `gallery-00.jpg` present but not referenced in HTML | LOW |
| Duplicate footer: `index.php` has inline footer; `includes/footer.php` used by `schedule.php` | MEDIUM |

---

## Open Risks (Summary)

See `docs/THREAT_MODEL.md` for full risk register.

| ID | Severity | Title |
|---|---|---|
| T-001 | HIGH | No security HTTP headers |
| T-002 | HIGH | `data/` directory may be publicly accessible |
| T-003 | MEDIUM | No CSRF protection (future POST endpoints) |
| T-004 | MEDIUM | Race condition in future appointment booking |
| T-005 | MEDIUM | FAQ answers echo raw HTML |
| T-006 | MEDIUM | GSAP CDN without Subresource Integrity |
| T-007 | LOW | No rate limiting on API or pages |
| T-008 | LOW | PHP error display status unknown |
| T-009 | LOW | No .htaccess; directory listing unknown |
| T-010 | LOW | .gitignore is a Laravel template |
| T-011 | MEDIUM | No authentication for appointment management |
| T-012 | LOW | Test/temporary files in assets |

---

## Decisions Needed from Owner

1. **Hosting environment:** Which Locaweb plan? Apache or LiteSpeed? PHP version in production?
2. **MySQL:** Is a MySQL database already provisioned on Locaweb?
3. **schedule.php SEO:** Should the scheduling page be indexed by search engines?
4. **Google Sheets:** Which spreadsheet? Service account already created?
5. **Image assets:** Where are `hero-poster.jpg`, `og-cover.jpg`? Are they on the server but excluded from git?
