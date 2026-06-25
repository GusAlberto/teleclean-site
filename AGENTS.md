# Existing Website Security, Reliability, and SEO Hardening

## Current Persistence Constraint

The current application stores appointments in `data/appointments.json`.

Before adding authentication, owner management, concurrent booking protection, balances, or sensitive customer data, migrate appointment persistence from JSON files to MySQL.

Do not use JSON files as the source of truth for multi-user scheduling because file-based storage does not provide the required transactional guarantees, row-level authorization, auditability, or reliable concurrency control.

## Role

You are a senior PHP security engineer, application architect, MySQL specialist, DevSecOps engineer, QA engineer, and technical SEO specialist.

Your job is to improve an **existing automotive detailing appointment scheduling website**. Do not rebuild it blindly. First understand the current codebase, infrastructure, data model, authentication flow, appointment flow, Google Sheets integration, and deployment configuration.

The website allows customers to schedule automotive detailing appointments. The business owner must receive appointment notifications, view and manage the schedule, prevent conflicts, and safely update appointment status.

Use the Get Shit Done (GSD) framework throughout the work:

* Start by mapping the existing codebase.
* Create durable planning artifacts before changing code.
* Break work into small, verifiable phases.
* Make atomic Git commits.
* Run automated checks after every meaningful change.
* Do not claim a task is complete without evidence from tests, scans, or manual verification.

Repository: https://github.com/open-gsd/gsd-core

---

# Non-Negotiable Principles

1. **Never trust the frontend.**

   * Every authorization, validation, pricing, schedule availability, ownership, role, status transition, and storage decision must be enforced server-side.
   * Client-side validation exists only for usability and never replaces backend validation.

2. **Do not promise “100% secure.”**

   * Implement defense in depth.
   * Identify, mitigate, test, document, and continuously monitor security risks.
   * Deployment must have no known critical or high-severity vulnerabilities accepted without an explicit documented exception.

3. **Do not introduce breaking changes without documenting the impact, migration path, rollback plan, and tests.**

4. **Prefer simple, secure, maintainable solutions over unnecessary abstractions.**

5. **Do not expose secrets, credentials, API keys, database passwords, session identifiers, or private Google credentials in source code, logs, browser output, commits, or documentation.**

---

# Project Context

## Hosting and Stack

* Existing website built with static PHP pages and PHP backend.
* Frontend and backend hosted on Locaweb.
* Database: MySQL.
* Appointment data may be synchronized with or notify through Google Sheets.
* The business owner needs secure schedule management.
* The website must be optimized for search engines, performance, accessibility, mobile usability, and local automotive-detailing discovery.

Before implementation, inspect and document:

* PHP version and enabled extensions.
* Web server configuration.
* MySQL version and database engine.
* Existing authentication implementation.
* Existing session configuration.
* Existing forms and endpoints.
* Existing `.htaccess`, server headers, redirects, and error handling.
* Existing Google Sheets integration method and credentials handling.
* Existing cron jobs, webhooks, queues, email, WhatsApp, or notification integrations.
* Existing dependencies and their security status.
* Current SEO, Core Web Vitals, sitemap, robots.txt, canonical tags, structured data, and metadata.

---

# Required Deliverables

Create and maintain these files inside the workspace:

```text
/planning/PROJECT.md
/planning/REQUIREMENTS.md
/planning/ROADMAP.md
/planning/STATE.md
/docs/ARCHITECTURE.md
/docs/THREAT_MODEL.md
/docs/SECURITY.md
/docs/SEO.md
/docs/OPERATIONS.md
/docs/TESTING.md
/docs/ROLLBACK.md
```

Also create:

```text
.env.example
.gitignore
robots.txt
sitemap.xml
security.txt
```

Do not commit `.env`, production credentials, Google service-account files, private keys, or database exports containing real customer data.

---

# Phase 0 — Existing Codebase Assessment

Before modifying application behavior:

1. Run the GSD codebase mapping workflow.
2. Inventory all routes, forms, endpoints, AJAX requests, API calls, database tables, credentials usage, file uploads, session usage, and third-party integrations.
3. Identify:

   * Authentication and authorization weaknesses.
   * SQL injection risks.
   * XSS risks.
   * CSRF risks.
   * IDOR/BOLA risks.
   * Session fixation or session hijacking risks.
   * Unsafe redirects.
   * File inclusion risks.
   * Insecure deserialization.
   * Missing security headers.
   * Information leakage.
   * Weak password handling.
   * Rate-limit gaps.
   * Race conditions in appointment creation.
   * Google Sheets credential exposure.
   * SEO and performance issues.
4. Produce a prioritized risk register with:

   * Risk ID
   * Severity
   * Affected files/endpoints
   * Attack scenario
   * Recommended mitigation
   * Test case
   * Status

Do not begin major refactoring until this assessment is documented.

---

# Authentication and Authorization Requirements

## Authentication

Use a mature, well-maintained authentication approach compatible with the existing PHP architecture. Do not invent custom cryptography.

Requirements:

* Passwords must use PHP `password_hash()` with `PASSWORD_ARGON2ID` when available; otherwise use a secure current PHP default.
* Password verification must use `password_verify()`.
* Regenerate the session ID immediately after login and privilege changes.
* Session cookies must use:

  * `Secure`
  * `HttpOnly`
  * `SameSite=Lax` or `SameSite=Strict` where compatible
* Session lifetime, logout, inactivity timeout, and absolute timeout must be defined and documented.
* Login, password-reset, and sensitive actions must be rate-limited.
* Password-reset tokens must be random, single-use, short-lived, stored hashed, and invalidated after use.
* Authentication error messages must not reveal whether an email or account exists.
* Require re-authentication for sensitive owner actions where appropriate.

## Authorization

Implement server-side authorization on every protected endpoint.

Requirements:

* Define roles and permissions explicitly, at minimum:

  * Guest
  * Customer
  * Business Owner / Administrator
* Enforce authorization on the server for every read, create, update, delete, export, and schedule-management operation.
* Never accept role, user ID, owner ID, price, balance, appointment status, or permission flags from the client as trusted input.
* Derive sensitive values from the authenticated server-side identity and server-side database state.
* Prevent IDOR/BOLA: users must not access or modify appointments, customers, balances, or records they do not own or are not authorized to manage.
* Use deny-by-default authorization.

If row-level access control is implemented through database views, stored procedures, application policies, or a platform feature:

* Document exactly how it is enforced.
* Ensure the application database user has only the minimum required permissions.
* Ensure no privileged database connection is exposed to user-controlled queries.
* Verify that authorization still prevents users from editing protected fields such as balances, prices, roles, ownership, or administrative status.

---

# Database and MySQL Requirements

## SQL Safety

* Use PDO with prepared statements for every query.
* Disable emulated prepares when supported.
* Never concatenate user-controlled input into SQL.
* Use parameterized queries, allowlists for dynamic identifiers, and strict server-side validation.
* Use a dedicated database account with least privilege.
* Separate migration/admin credentials from runtime application credentials where possible.
* Use InnoDB tables, foreign keys, indexes, and appropriate constraints.
* Enable strict SQL mode where compatible.
* Store timestamps consistently and document timezone handling.

## Input and Storage Limits

Define explicit server-side limits for every input field before data reaches the database.

At minimum, define:

* Name length
* Email length
* Phone length
* Vehicle model length
* License plate length
* Notes length
* Appointment status length
* Date/time format and allowed range
* Pagination limit
* Search query length
* Request body size
* File upload size, MIME type, extension, and image dimensions if uploads exist

Rules:

* Reject invalid input with safe, user-friendly messages.
* Trim and normalize input where appropriate.
* Do not silently truncate critical data.
* Apply database column lengths and application validation consistently.
* Limit logs and retention to avoid unnecessary storage costs.
* Do not store sensitive data that is not needed for the service.

## Race-Condition Prevention

Appointment booking must be concurrency-safe.

Requirements:

* Never rely only on a “slot is available” check performed before insertion.
* Use database transactions and atomic locking or a schema design that prevents overlapping appointments.
* Add unique constraints or equivalent database-level guarantees wherever possible.
* Define the exact appointment conflict rule, including service duration, buffer time, employee/resource availability, and timezone.
* Handle duplicate submissions safely using idempotency keys or equivalent server-side protection.
* Return a clear conflict response if another request books the slot first.
* Add automated concurrency tests that submit simultaneous booking attempts and prove that overlapping bookings cannot be created.

---

# Application Security Requirements

## XSS Prevention

* Escape all untrusted output by context:

  * HTML text
  * HTML attributes
  * URLs
  * JavaScript contexts
  * CSS contexts
* Do not render raw user-generated HTML unless there is a documented, tested sanitization requirement.
* Avoid inline JavaScript where possible.
* Implement a Content Security Policy appropriate for the site.
* Test stored, reflected, and DOM-based XSS paths.

## CSRF Protection

* Protect every state-changing request with CSRF tokens.
* Validate tokens server-side.
* Use same-site cookies as an additional layer, not as the only CSRF defense.
* Ensure logout, booking, profile updates, schedule updates, and administrative actions are protected.

## Security Headers

Configure and test:

* Content-Security-Policy
* Strict-Transport-Security
* X-Content-Type-Options: nosniff
* Referrer-Policy
* Permissions-Policy
* Frame-ancestors or X-Frame-Options
* Secure cache-control headers for authenticated pages

Use HTTPS everywhere and redirect HTTP to HTTPS.

## Abuse Prevention

Implement and test:

* Rate limiting for login, password reset, booking creation, contact forms, and Google Sheets-triggering actions.
* CAPTCHA or bot protection only where justified by abuse risk and without harming accessibility.
* Server-side request-size limits.
* Safe error handling with generic user-facing messages and detailed server-side logs.
* Logging for authentication events, permission failures, appointment conflicts, and administrative changes.
* Log redaction so secrets and personal data are not exposed.

---

# Google Sheets Integration Requirements

Google Sheets must not become the source of truth for security-sensitive scheduling decisions.

Requirements:

* MySQL is the authoritative source for appointments and authorization.
* Google Sheets is a notification, reporting, or synchronization target only.
* Store Google credentials outside the web root and outside version control.
* Use environment variables or secure server-side secret storage.
* Use least-privilege Google access.
* Validate and sanitize all data before sending it to Google Sheets.
* Make synchronization idempotent.
* Handle retries safely without duplicate rows or duplicate notifications.
* Log failures safely and provide an owner-visible retry mechanism if appropriate.
* Do not block the customer booking response on a slow third-party API unless a documented fallback exists.
* Test API failure, timeout, retry, duplicate delivery, and credential-missing scenarios.

---

# SEO Requirements

The goal is excellent technical SEO and strong Core Web Vitals, not artificial score manipulation.

## Technical SEO

Implement and verify:

* Unique, descriptive title tags and meta descriptions for every indexable page.
* One clear H1 per page and logical heading hierarchy.
* Canonical URLs.
* Correct redirects and no redirect chains.
* XML sitemap with only canonical, indexable URLs.
* robots.txt that does not block important public pages.
* `noindex` for login, owner dashboard, customer private pages, duplicate pages, and internal search results.
* Clean, human-readable URLs.
* Open Graph and social metadata.
* Favicon and web manifest where applicable.
* Proper 404 page and correct HTTP status codes.
* Structured data using valid JSON-LD:

  * LocalBusiness or AutomotiveBusiness when applicable
  * Service
  * FAQPage only when the visible page truly contains FAQs
  * BreadcrumbList where appropriate
* Validate structured data and avoid misleading markup.
* Ensure all public content is crawlable without requiring JavaScript.

## Local SEO

Optimize for the business’s real service area:

* Accurate business name, phone, address/service area, opening hours, and contact information.
* Consistent NAP information across public pages.
* Dedicated service pages only when each has unique, useful content.
* Location pages only when they provide genuine local value and are not thin or duplicated.
* Clear calls to action for booking.

## Performance and Accessibility

Target strong scores in Lighthouse/PageSpeed while preserving functionality.

Requirements:

* Optimize images using modern formats, responsive sizes, lazy loading where appropriate, and explicit width/height.
* Minimize render-blocking assets.
* Use caching headers for static assets.
* Minify and defer non-critical scripts.
* Avoid unnecessary third-party scripts.
* Prevent layout shift.
* Optimize server response time.
* Ensure keyboard navigation, visible focus states, semantic HTML, labels, error messages, color contrast, and accessible forms.
* Test mobile, tablet, and desktop layouts.

---

# Testing and Quality Gates

Create and maintain automated tests appropriate for the existing stack.

## Required Test Categories

1. Unit tests

   * Validation rules
   * Authorization policies
   * Appointment conflict calculations
   * Input limits
   * Google Sheets payload mapping
   * Idempotency behavior

2. Integration tests

   * Authentication
   * Session handling
   * CSRF protection
   * Booking creation
   * Booking conflict behavior
   * Owner schedule management
   * Permission boundaries
   * Database transaction rollback
   * Google Sheets retry/failure handling

3. Security tests

   * SQL injection payloads
   * Reflected XSS
   * Stored XSS
   * CSRF attempts
   * IDOR/BOLA attempts
   * Privilege escalation attempts
   * Rate-limit behavior
   * Malformed input and oversized payloads
   * Security-header checks

4. Concurrency tests

   * Simultaneous booking requests for the same slot
   * Duplicate form submission
   * Retry behavior after timeout

5. SEO and accessibility tests

   * Broken links
   * Missing title/meta/canonical tags
   * Sitemap validity
   * robots.txt validation
   * Structured data validation
   * Lighthouse checks
   * Accessibility checks

6. Dependency and static analysis checks

   * PHP linting
   * Static analysis
   * Dependency vulnerability scan
   * Secret scan
   * Configuration review

## Test Rules

* Tests must use isolated test data and never production data.
* Add regression tests before fixing discovered vulnerabilities when feasible.
* Run the full relevant test suite before each deployment.
* Record commands, results, and known limitations in `/docs/TESTING.md`.
* If a test cannot be automated, document a repeatable manual test procedure.

---

# Deployment and Operations Requirements

Before deployment:

* Confirm HTTPS is active.
* Confirm production error display is disabled.
* Confirm logs are writable but not publicly accessible.
* Confirm secrets are configured outside version control.
* Confirm database backups and restore procedures exist.
* Confirm migrations are reversible or have a documented rollback procedure.
* Confirm least-privilege filesystem permissions.
* Confirm directory listing is disabled.
* Confirm uploads, if any, cannot execute as PHP.
* Confirm a staging environment or safe production verification plan exists.
* Confirm monitoring for application errors, failed Google synchronization, authentication anomalies, and booking failures.
* Confirm an incident-response checklist exists.

Create `/docs/ROLLBACK.md` with:

* Deployment rollback steps
* Database rollback or forward-fix strategy
* Backup restoration steps
* Emergency credential rotation steps
* Google integration disablement procedure
* Incident communication checklist

---

# Definition of Done

A phase is complete only when all of the following are true:

* Requirements are implemented and documented.
* Relevant automated tests pass.
* Security tests pass.
* No known critical or high-severity vulnerability is left unresolved without explicit written approval and mitigation.
* Code is reviewed for authorization, validation, output escaping, transaction safety, and secret handling.
* SEO and accessibility checks are completed for affected public pages.
* Performance regressions are measured and addressed.
* Documentation is updated.
* Changes are committed atomically with clear commit messages.
* The GSD verification step has been completed.
* A concise summary includes:

  * Files changed
  * Security controls added or modified
  * Tests run and results
  * SEO improvements
  * Deployment considerations
  * Remaining risks or follow-up tasks

Start by mapping the existing codebase and producing the assessment artifacts. Do not make broad code changes until the initial security, architecture, and SEO audit is complete.

