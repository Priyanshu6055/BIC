# BIC Next.js to Laravel migration map

Source audited: `BIC_Final_Corrected_Source` (commit recorded by source package: `ae77d0581b005b5f9e45d6f4b3624eb7c4864fe1`). The extracted source was treated as read-only.

| Approved source | Laravel destination | Preservation result |
|---|---|---|
| `src/app/page.tsx` | `resources/views/home.blade.php` and `resources/views/components/home/*` | All approved sections, wording, class names and ordering migrated |
| `src/app/approved.css` | `resources/css/approved.css` | Copied without visual rewrites |
| `src/app/globals.css` | `resources/css/globals.css` | Copied; form system preserved |
| `approved-homepage-interactions.tsx` | `resources/js/bic-home.js` | React lifecycle removed; calculations and thresholds preserved |
| `form-config.ts` | `config/inquiries.php` | Five field configurations, labels, options, steps, required flags and hints preserved |
| `schemas.ts` | `InquiryController::rules()` | Laravel equivalents for required text, lengths, email, mobile, URL, consent and enum validation |
| `public/images/approved/*` | `public/images/approved/*` | Copied byte-for-byte; checksum verification passed |
| Hard-coded Insight cards | `Insight` records and `InsightSeeder` | Three approved cards retained as published seed content |
| Next metadata | Blade layout sections, robots and sitemap routes | Titles, descriptions, canonicals, OpenGraph, robots and sitemap intent migrated |

## Blade component map

Header, hero, about, evidence/problem, services, audience, Capital+1, process, trust, insights, CTA and footer are separate Blade components. Dynamic Insight cards use the same approved card classes.

## Backend map

- Five inquiry routes persist into MySQL through the `Inquiry` model.
- Form-specific fields remain in JSON while the dashboard columns are normalized.
- PDFs are stored on the private local disk under generated names and are downloadable only behind admin authentication.
- Admin access uses Laravel session authentication plus an `is_admin` authorization check.
- Insights use a full draft/published/archived lifecycle; only published, due content is public.

