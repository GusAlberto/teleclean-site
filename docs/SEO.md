# SEO.md — TeleClean Detail

_Last updated: 2026-06-25 (Phase 0 assessment)_

## Summary

The site has solid foundational SEO: each page defines unique title, description, and canonical URL; meta tags are properly escaped; JSON-LD is present; semantic HTML is used throughout; images have explicit dimensions and alt text; and responsive layout is implemented. Key gaps are an invalid Schema.org type, missing FAQPage structured data, relative OG image URL, and `schedule.php` absent from the sitemap.

---

## Page Inventory

| URL | Title | Description | Canonical | In Sitemap | noindex? |
|---|---|---|---|---|---|
| `https://www.teleclean.com.br/` | TeleClean Detail \| Estética Automotiva em Belo Horizonte | Set; 183 chars (slightly long) | Set | YES | NO |
| `https://www.teleclean.com.br/schedule.php` | Agenda de Serviços \| TeleClean | Set; 135 chars | Set | **NO** | NO |

**Decision needed:** Should `schedule.php` be indexed? It displays available booking slots and could rank for "agendamento estética automotiva belo horizonte". Recommendation: add it to `sitemap.xml` with a `noindex` to block indexing if the page is considered utility-only, or include it fully if it has SEO value.

---

## Structured Data Audit

### Current JSON-LD (`includes/head.php:36–72`)

```json
{
  "@context": "https://schema.org",
  "@type": "AutoDetailing",
  ...
}
```

**Issues:**

| Issue | Severity | Fix |
|---|---|---|
| `@type: "AutoDetailing"` is not a valid Schema.org type | HIGH | Use `"AutomotiveBusiness"` or `["LocalBusiness", "AutomotiveBusiness"]` |
| Missing `@id` property | MEDIUM | Add `"@id": "https://www.teleclean.com.br/#business"` |
| `"priceRange": "$$$"` uses US dollar sign | LOW | Change to `"R$$$"` or omit if not representative |
| No FAQPage markup despite FAQ section existing | MEDIUM | Add `FAQPage` JSON-LD to `index.php` |
| `og:image` is a relative path (`assets/img/og-cover.jpg`) | HIGH | Change to absolute URL `https://www.teleclean.com.br/assets/img/og-cover.jpg` |
| Testimonials use `itemscope` microdata, not JSON-LD | LOW | Consistent with JSON-LD is preferred; or validate microdata separately |

### Recommended JSON-LD Fix

```json
{
  "@context": "https://schema.org",
  "@type": "AutomotiveBusiness",
  "@id": "https://www.teleclean.com.br/#business",
  "name": "TeleClean Detail",
  "image": "https://www.teleclean.com.br/assets/img/og-cover.jpg",
  "url": "https://www.teleclean.com.br/",
  "telephone": "+55-31-3568-3754",
  "description": "Especialistas em polimento técnico, vitrificação e detalhamento automotivo em Belo Horizonte.",
  "email": "contato@teleclean.com.br",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Rua Benjamim Flores, 170 - Santo Antônio",
    "addressLocality": "Belo Horizonte",
    "addressRegion": "MG",
    "postalCode": "30350-130",
    "addressCountry": "BR"
  },
  "openingHoursSpecification": [
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
      "opens": "08:00",
      "closes": "18:00"
    }
  ],
  "sameAs": ["https://www.instagram.com/teleclean_/"],
  "areaServed": {
    "@type": "City",
    "name": "Belo Horizonte"
  }
}
```

### Recommended FAQPage JSON-LD (add to `index.php` before `</head>` or inline)

```json
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Quanto tempo leva um serviço de estética automotiva?",
      "acceptedAnswer": { "@type": "Answer", "text": "O tempo varia conforme o pacote e o estado do veículo. Após a análise inicial, o cliente recebe uma estimativa clara de prazo." }
    }
    // ... other questions
  ]
}
```

---

## On-Page SEO Audit

### `index.php`

| Element | Status | Note |
|---|---|---|
| `<h1>` | PASS | One H1: "Estética automotiva premium" |
| H1 → H2 → H3 hierarchy | PASS | Structure is logical |
| Title tag | PASS | "TeleClean Detail \| Estética Automotiva em Belo Horizonte" (71 chars) |
| Meta description | PASS (slightly long) | 183 chars; recommended 140–160 |
| Canonical | PASS | `https://www.teleclean.com.br/` |
| Open Graph title/description | PASS | |
| `og:image` | FAIL | Relative path — social crawlers may fail to resolve |
| `og:image:alt` | PASS | Set |
| Twitter Card | PASS | `summary_large_image` |
| Structured data | PARTIAL | See above issues |
| `<meta name="keywords">` | INFORMATIONAL | Present but ignored by Google/Bing |
| Image `alt` attributes | PASS | All checked images have descriptive alt text |
| Image `width`/`height` | PASS | Explicit on all images |
| `loading="lazy"` | PASS | Applied below-fold; first carousel image uses `loading="eager"` |
| `loading="eager"` on LCP candidate | PASS | First carousel image |
| Skip link | PASS | `.skip-link` pointing to `#conteudo` |
| Language attribute | PASS | `<html lang="pt-BR">` |
| FAQ visibility without JS | PASS | PHP renders FAQ items in HTML; accordion requires JS to open |

### `schedule.php`

| Element | Status | Note |
|---|---|---|
| `<h1>` | PASS | "Agende seu serviço" |
| Title | PASS | "Agenda de Serviços \| TeleClean" |
| Meta description | PASS | 135 chars |
| Canonical | PASS | `https://www.teleclean.com.br/schedule.php` |
| `og:image` | FAIL | Relative path |
| Content without JS | FAIL | Calendar is entirely JS-rendered; no fallback content |
| noindex | ABSENT | Decide whether to index or exclude |

---

## robots.txt Audit

Current content:
```
User-agent: *
Allow: /

Sitemap: https://www.teleclean.com.br/sitemap.xml
```

**Issues:**

| Issue | Recommendation |
|---|---|
| `data/appointments.json` likely crawlable | Add `Disallow: /data/` |
| `api/appointments.php` crawlable | Add `Disallow: /api/` |
| `includes/` PHP partials crawlable | Add `Disallow: /includes/` |
| No `admin/` disallow yet | Add when admin is created (Phase 3) |

---

## sitemap.xml Audit

Current:
```xml
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>https://www.teleclean.com.br/</loc>
    <changefreq>weekly</changefreq>
    <priority>1.0</priority>
  </url>
</urlset>
```

**Issues:**

| Issue | Recommendation |
|---|---|
| `schedule.php` missing | Add if page is to be indexed |
| No `<lastmod>` dates | Add last-modified dates for crawl budget efficiency |
| `changefreq` and `priority` have minimal impact on modern crawlers | Keep for completeness, but not a ranking signal |

---

## Performance and Core Web Vitals

| Issue | Impact | Phase |
|---|---|---|
| GSAP from external CDN | Extra DNS lookup + TLS handshake; render-blocking potential | Phase 1/6 |
| Fonts from Fontshare CDN + Google Fonts CDN + CSS @import | Three separate external font requests; render-blocking | Phase 6 |
| Images in JPEG only | WebP would reduce file size ~25–35% | Phase 6 |
| Hero video size unknown | Full HD video can be 10–50 MB; critical for LCP on mobile | Phase 6 |
| `hero-poster.jpg` referenced but may be missing | Blank hero frame while video loads; CLS risk | Phase 1 |
| No cache-control headers for assets | Browsers re-fetch CSS/JS on every visit | Phase 6 |
| CSS not minified | Minor | Phase 6 |
| JS not minified | Minor | Phase 6 |

---

## Local SEO Checklist

| Item | Status |
|---|---|
| Business name consistent across page | PASS — "TeleClean Detail" used consistently |
| Phone number consistent | PASS — (31) 3568-3754 used in multiple places |
| Address in JSON-LD and footer | PASS — Rua Benjamim Flores, 170, Santo Antônio, BH |
| Email in JSON-LD and FAQ | PASS — contato@teleclean.com.br |
| Instagram sameAs in JSON-LD | PASS — @teleclean_ |
| Opening hours in JSON-LD | PASS — Mo–Sa 08:00–18:00 |
| Google Maps embed in footer | PASS |
| Service area defined | PASS — "Belo Horizonte e região metropolitana" |
| Google Business Profile link | NOT FOUND — confirm and add if available |

---

## Action Items Ranked by SEO Impact

| Priority | Action | File | Phase |
|---|---|---|---|
| 1 | Fix `@type: "AutoDetailing"` to `"AutomotiveBusiness"` | `includes/head.php` | Phase 1 |
| 2 | Fix `og:image` to absolute URL | `index.php`, `schedule.php` | Phase 1 |
| 3 | Add FAQPage JSON-LD | `index.php` | Phase 1 |
| 4 | Add `Disallow` rules to `robots.txt` | `robots.txt` | Phase 1 |
| 5 | Decide and act on `schedule.php` indexability | `sitemap.xml` / `schedule.php` | Phase 1 |
| 6 | Add `<lastmod>` to sitemap | `sitemap.xml` | Phase 1 |
| 7 | Confirm `hero-poster.jpg` and `og-cover.jpg` exist and are deployed | `assets/img/` | Phase 1 |
| 8 | Convert images to WebP | `assets/img/` | Phase 6 |
| 9 | Eliminate render-blocking font requests | `includes/head.php`, `style.css` | Phase 6 |
| 10 | Add `preload` for LCP image/poster | `includes/head.php` | Phase 6 |
