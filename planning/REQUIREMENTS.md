# REQUIREMENTS.md — TeleClean Detail

## Functional Requirements

### FR-01: Public Landing Page

- Display business hero, services, differentials, gallery, before/after comparisons, testimonials, FAQ, and contact CTA.
- All public content must be crawlable without JavaScript.
- Status: **IMPLEMENTED**

### FR-02: Service Catalog

- List all offered services with descriptions.
- Each service card links to WhatsApp with a pre-filled message.
- Status: **IMPLEMENTED**

### FR-03: Booking Calendar View

- Show a monthly calendar with per-day availability fill percentage.
- Show hourly time slots (08:00–18:00) for a selected day.
- Mark booked slots as unavailable.
- On selecting an available slot, open WhatsApp with the service and time pre-filled.
- Status: **IMPLEMENTED (frontend only; no server-side booking confirmation)**

### FR-04: Appointment Data API

- `GET /api/appointments.php` returns a JSON array of booked ISO datetime strings.
- Response used by the frontend calendar.
- Status: **IMPLEMENTED (read-only)**

### FR-05: Owner Appointment Management

- Owner must be able to mark slots as booked or available without editing JSON files manually.
- Requires authentication.
- Status: **NOT IMPLEMENTED**

### FR-06: Server-Side Appointment Booking

- Customer submits booking; server validates slot availability atomically, records the appointment, and sends confirmation.
- Must prevent double-booking via database transactions.
- Status: **NOT IMPLEMENTED**

### FR-07: Authentication

- Business owner login with secure password handling.
- Session regeneration on login.
- Rate-limited login.
- Status: **NOT IMPLEMENTED**

### FR-08: Google Sheets Synchronization

- New appointments sync to a Google Sheet as a notification/reporting layer.
- MySQL remains authoritative.
- Status: **NOT IMPLEMENTED**

### FR-09: WhatsApp / Email Notifications

- Owner receives notification on new appointment.
- Status: **NOT IMPLEMENTED**

---

## Non-Functional Requirements

### NFR-01: Security

- All state-changing requests protected with CSRF tokens.
- Server-side validation on every input.
- No SQL injection or XSS vulnerabilities.
- Security HTTP headers on all responses.
- Rate limiting on booking, login, and API endpoints.
- Authentication using `password_hash(PASSWORD_ARGON2ID)`.
- Status: **PARTIALLY MET** — See THREAT_MODEL.md for open issues.

### NFR-02: Performance

- Core Web Vitals: target LCP < 2.5 s, FID/INP < 100 ms, CLS < 0.1.
- Images in WebP/AVIF with explicit dimensions.
- Non-critical JS deferred; render-blocking assets minimized.
- Status: **UNKNOWN** — No Lighthouse baseline recorded.

### NFR-03: SEO

- Unique title, description, and canonical per indexable page.
- Valid JSON-LD structured data (LocalBusiness or AutomotiveBusiness).
- Sitemap includes all indexable pages.
- robots.txt correct.
- Status: **PARTIALLY MET** — See docs/SEO.md for open issues.

### NFR-04: Accessibility

- WCAG 2.1 AA target.
- Keyboard navigation for all interactive elements.
- Skip link present.
- Correct ARIA attributes on accordion and mobile menu.
- Status: **PARTIALLY MET** — Skip link present, ARIA on components; full audit not yet done.

### NFR-05: Reliability

- No data loss during concurrent booking requests.
- File persistence must not cause race conditions.
- Status: **NOT MET** — JSON file store has no locking or transaction guarantees.

### NFR-06: Maintainability

- All shared components in `includes/`.
- Business data (phone, address) defined in one place.
- Status: **PARTIALLY MET** — Footer is duplicated between `index.php` and `includes/footer.php`.

---

## Input Field Limits (To Be Enforced When Booking Form Is Added)

| Field | Max Length | Validation Rule |
|---|---|---|
| Name | 100 chars | Letters, spaces, hyphens |
| Email | 254 chars | RFC 5321 format |
| Phone | 20 chars | Digits, spaces, hyphens, `+` |
| Vehicle model | 100 chars | Printable text |
| License plate | 10 chars | Alphanumeric |
| Notes | 500 chars | Printable text |
| Service selection | Allowlist | Must match server-side allowed values |
| Date | ISO 8601 | Must be a future weekday within booking window |
| Time | Allowlist | Must be one of the 11 valid hourly slots (08–18) |

---

## Out of Scope (Phase 0)

- Customer accounts / self-service profile management
- Online payment processing
- SMS notifications
- Multi-location support
- Staff / technician management
