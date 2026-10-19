# ArcticRestoDRY ICE — WordPress + Elementor Website & Theme Documentation

- **Brand Name:** ArcticRestoDRY ICE
- **Primary Tagline:** *Quality Dry Ice. Reliable Supply. Flexible Solutions.*
- **Theme Version:** `2.0.0`
- **Installable Theme Packages:**
  - `arctic-resto-dry-ice.zip` (Installable WordPress Theme ZIP)
  - `arctic-resto-latest.zip` (Updated in-place installable WordPress Theme ZIP)
- **Theme Source Directory:** `arctic-resto/`

---

## 1. Summary of Changes from the Original Arctic Resto Theme

The original `arctic-resto` theme (v1.5.0) was positioned as a B2B industrial dry ice blasting service and franchise recruitment website. It has been transformed into **ArcticRestoDRY ICE (v2.0.0)** — a complete, production-ready WordPress + Elementor website for a **dry ice manufacturing and commercial supply business**:

1. **Brand Repositioning & Identity (`style.css`, `functions.php`, `inc/helpers.php`, `template-parts/*`):**
   - Repositioned the site around **ArcticRestoDRY ICE** (*Quality Dry Ice. Reliable Supply. Flexible Solutions.*).
   - Replaced all franchise recruitment, Item 19, territory royalty, and cleaning-first messaging with dry ice manufacturing, product formats (pellets, nuggets, solid blocks), bulk & recurring supply programs, cold-chain applications, and safe handling/storage education.
   - Replaced hard-coded fictional contact information with **admin-configurable contact & dispatch placeholders** (`ar_has_contact_value()`, `ar_contact_display()`) managed in **Appearance → Customize → Contact, Dispatch & Quote Routing**.

2. **Secondary Cross-Promotion for Arctic Resto Cleaning Services (`inc/customizer.php`, `W_CrossPromo`, `template-parts/site-footer.php`):**
   - Added a visually secondary, reusable, and separately configurable cross-promotion section and Elementor widget (`AR · Secondary Cleaning Cross-Promo`) directing visitors who need on-site mobile dry ice cleaning/blasting services to `https://arcticresto.com/` (with `target="_blank" rel="noopener noreferrer"` when opening in a new tab).

3. **Enhanced Elementor Integration & 34 Custom Widgets (`inc/elementor.php`, `inc/elementor/*`):**
   - Preserved all 29 existing `ar_*` widget slugs (updated with dry ice manufacturing and supply defaults so zero widgets ever break) and added **5 new dedicated dry ice supply widgets** in `inc/elementor/widgets-dryice.php`:
     - `ar_products` (`W_Products`) — **Dry Ice Product Format Cards** (extruded pellets, dense nuggets, solid blocks/slabs, and custom/application-specific formats, with editable specification verification notices).
     - `ar_spec_table` (`W_SpecTable`) — **Dry Ice Technical Specification Table** (separating physical properties of solid CO₂ from editable operational placeholders).
     - `ar_industries` (`W_Industries`) — **Industries We Serve Matrix** (all 8 core commercial, food, life-science, and industrial sectors).
     - `ar_safety_notice` (`W_SafetyNotice`) — **Dry Ice Safety, PPE & Ventilation Callout** (`-78.5°C / -109.3°F`, CO₂ gas displacement, insulated gloves, and vented container requirements).
     - `ar_cross_promo` (`W_CrossPromo`) — **Secondary Cleaning Cross-Promo Callout (`https://arcticresto.com/`)**.
   - Upgraded `Base_Widget` (`inc/elementor/class-base.php`) so **every `ar_*` widget automatically exposes comprehensive Elementor `Style` tab controls** (`Section Container & Spacing`, `Typography & Text Colors`, `Card & Box Styling`, and `Buttons & CTAs`) using `{{WRAPPER}}` CSS selectors.
   - Added a frontend safeguard in `functions.php` ensuring `wp-admin/includes/plugin.php` is available on frontend requests for full compatibility with Elementor 3.35+.

4. **Custom Post Types & Delivery Coverage System (`inc/post-types.php`, `inc/territory.php`):**
   - Registered `ar_product` (**Dry Ice Products**) and `ar_industry` (**Industries Served**) CPTs with custom admin meta boxes and Elementor support.
   - Repurposed `ar_territory` into **Delivery & Supply Zones** (`inc/territory.php`) with admin-editable fields for supported regions/states/cities, ZIP prefixes, local pickup/collection notes, bulk route notes, order minimums, and transit sublimation restrictions. All demo zones are clearly labeled as editable placeholders requiring customer confirmation where coverage is not yet specified.

5. **Comprehensive Quote, Bulk Order & Service-Area Forms (`inc/forms.php`, `assets/js/theme.js`):**
   - Upgraded `ar_render_form()` and `/wp-json/ar/v1/lead` to support `quote`, `bulk`, `service_area`, `contact`, and `newsletter` workflows with conditional fields (recurring delivery schedule notes, delivery vs. collection preferences, product format pre-selection), honeypot spam protection, privacy/handling consent validation, CRM storage (`ar_lead`), and configurable email notification routing.

6. **Complete 16-Page Elementor Demo Website & 8 Technical Blog Articles (`inc/demo-importer.php`, `inc/demo/*`):**
   - Built all 16 required pages with valid Elementor Flexbox Container + Widget JSON (`_elementor_data`) and semantic HTML fallback content:
     1. **Home** (`/`)
     2. **About Us** (`/about-us/`)
     3. **Dry Ice Manufacturing** (`/dry-ice-manufacturing/`)
     4. **Dry Ice Products** (`/dry-ice-products/`)
     5. **Dry Ice Pellets** (`/dry-ice-pellets/`)
     6. **Dry Ice Blocks and Nuggets** (`/dry-ice-blocks-nuggets/`)
     7. **Bulk Dry Ice Orders** (`/bulk-orders/`)
     8. **Industries We Serve** (`/industries/`)
     9. **Dry Ice Applications** (`/dry-ice-applications/`)
     10. **Delivery and Supply Areas** (`/delivery-areas/`)
     11. **Dry Ice Safety, Handling and Storage** (`/dry-ice-safety/`)
     12. **Quality and Product Specifications** (`/quality/`)
     13. **Frequently Asked Questions** (`/faq/`)
     14. **Request a Quote / Contact** (`/contact/`)
     15. **Blog and Resources** (`/blog/`)
     16. **Privacy Policy** (`/privacy-policy/`)
   - Authored 8 full-length technical blog articles on dry ice manufacturing, pellets vs. blocks, safe handling (`-78.5°C / -109.3°F`), sublimation management, food processing, pharmaceutical/lab cold-chain logistics, recurring bulk supply planning, and common transport/storage mistakes.

7. **Truthful SEO, Schema & `/llms.txt` (`inc/seo.php`, `inc/ai.php`):**
   - Outputs clean `Organization`, `WebSite`, `WebPage`, `BreadcrumbList`, `Article`, `Product`, and conditional `FAQPage` JSON-LD schema with **zero** fabricated `AggregateRating`, `Review`, price, stock status, or ISO certification claims.
   - Updated `/llms.txt` to describe **ArcticRestoDRY ICE** accurately as a dry ice manufacturing and supply business while noting `https://arcticresto.com/` for mobile dry ice cleaning services.

---

## 2. How to Install and Activate the Theme

1. Log in to your WordPress Administrator Dashboard (`/wp-admin/`).
2. Navigate to **Appearance → Themes → Add New Theme → Upload Theme**.
3. Select `arctic-resto-dry-ice.zip` (or `arctic-resto-latest.zip`) and click **Install Now**, then **Activate**.
4. Install and activate the free **Elementor** plugin (**Plugins → Add New Plugin → Search "Elementor"**). *Elementor Pro is not required.*

---

## 3. How to Run the Demo Importer

1. In WordPress Admin, go to **Appearance → Dry Ice Demo Import**.
2. Click **Import / Refresh ArcticRestoDRY ICE Website Content**.
3. The importer automatically runs 4 sequential steps:
   - **Step 1 (`media`):** Imports 12 dry ice manufacturing, product, container, safety, and industry images into the Media Library with descriptive `alt` attributes.
   - **Step 2 (`pages`):** Creates/updates all 16 pages with valid Elementor `_elementor_data` and semantic fallback content.
   - **Step 3 (`cpts`):** Creates/updates 4 Dry Ice Product CPT entries, 8 Industries Served CPT entries, 3 editable Delivery Zone placeholders, and 8 technical Blog Articles.
   - **Step 4 (`settings`):** Creates and assigns the Primary Navigation menu with dropdowns, sets `Home` as the static front page, enables the Elementor Flexbox Container experiment, syncs the Elementor Global Kit, and flushes rewrite rules.

---

## 4. How to Edit Pages in Elementor

1. Go to **Pages → All Pages** in WordPress Admin.
2. Hover over any of the 16 imported pages and click **Edit with Elementor**.
3. Every section is built inside an Elementor Flexbox Container containing an **ArcticRestoDRY ICE Supply Widget** (under the **ArcticRestoDRY ICE Supply Widgets** category in the left panel) or native Elementor widget:
   - **Content Tab:** Edit eyebrow badges, headings, lead copy, repeater cards, specification rows, FAQ items, images, button labels, and URLs.
   - **Style Tab:** Customize section background colors, padding, header alignment, heading/body typography and colors, card background/border/radius/padding, and primary/secondary button styles.

---

## 5. How to Update Contact Details, Product Specs, Delivery Areas & Form Recipients

### A. Business Contact Details & Quote Notification Email
- Go to **Appearance → Customize → ArcticRestoDRY ICE Settings → Contact, Dispatch & Quote Routing**.
- Enter your verified **Business Phone**, **Public Sales/Quote Email**, **Facility / Dispatch Address**, **Operating & Dispatch Hours**, and **Quote Notification Recipient Email**.
- While any contact field is left blank, the theme displays a clear admin placeholder note rather than fictional contact info.

### B. Product Specifications & Formats
- **On Elementor Pages (`/dry-ice-products/`, `/dry-ice-pellets/`, `/dry-ice-blocks-nuggets/`, `/quality/`):** Open the page in Elementor and click the **AR · Dry Ice Product Formats** or **AR · Dry Ice Specification Table** widget to edit pellet diameters, block weights, packaging options, MOQs, and verification notices.
- **In Custom Post Types:** Go to **Dry Ice Products** in the WordPress Admin sidebar to edit individual `ar_product` entries and their specification meta boxes.

### C. Delivery & Supply Areas
- Go to **Delivery & Supply Zones** in the WordPress Admin sidebar (`ar_territory`).
- Edit the 3 demo zones or add new zones. Change **Coverage Verification Status** from `Editable Demo Placeholder` to `Verified Active Supply Zone` once your supported states, cities, ZIP prefixes, pickup instructions, and order minimums are confirmed.

---

## 6. How to Edit or Disable the Secondary Arctic Resto Cleaning Cross-Promotion

1. **Global Footer & Default Widget Settings:**
   - Go to **Appearance → Customize → ArcticRestoDRY ICE Settings → Cross-Promotion: Arctic Resto Cleaning**.
   - Toggle **Enable Secondary Cleaning Cross-Promo** on or off, or customize the badge, heading, description, button label, destination URL (`https://arcticresto.com/`), and new-tab behavior.
2. **Per-Page Elementor Widget:**
   - On pages containing the **AR · Secondary Cleaning Cross-Promo (ArcticResto.com)** widget (`Home`, `About Us`, `Dry Ice Applications`, `Contact`), click the widget in Elementor to customize its text/styling or delete the container if not desired on a specific page.

---

## 7. Summary of Verification & Tests Completed

All 16 verification requirements were executed and confirmed against WordPress 6.7.1 + Free Elementor 3.35.0 on PHP 8.2:

| # | Verification Requirement | Result | Details |
|---|---|---|---|
| 1 | Clean theme activation (PHP 8.2) | **PASS** | All 36 PHP files linted with zero parse errors, warnings, or fatals. |
| 2 | One-click demo importer | **PASS** | Imported 12 media assets, 16 Elementor pages, 4 Dry Ice Products, 8 Industries, 3 Delivery Zones, 8 Blog Posts, and menus. |
| 3 | Frontend rendering of all 16 pages | **PASS** | All 16 pages render complete semantic HTML and styling (`4,272` to `88,491` bytes per page). |
| 4 | Elementor Editor document loading | **PASS** | `\Elementor\Plugin::instance()->documents->get($id)` loads all 16 pages with valid container/widget trees. |
| 5 | Custom Elementor widget registration | **PASS** | All 34 `ar_*` widgets register cleanly with 172–182 Content + Style + Advanced controls and 0 missing-widget warnings. |
| 6 | Customizer settings live updates | **PASS** | Verified phone, email, CTA, color token, and cross-promotion updates and placeholder fallbacks. |
| 7 | Quote, Bulk Order, Service-Area & Contact forms | **PASS** | Verified REST submission (`HTTP 200`, `ar_lead` creation), honeypot check, and missing-consent rejection (`HTTP 400`). |
| 8 | Navigation menus, dropdowns, mobile drawer & footer | **PASS** | Primary dropdowns, mobile drawer toggle, and 4-column footer + safety bar verified. |
| 9 | Internal link resolution | **PASS** | Checked all 36 unique internal links across all 16 pages; 0 broken links / 0 404s. |
| 10 | Secondary cross-promotion to `https://arcticresto.com/` | **PASS** | Verified secondary visual hierarchy, Customizer toggle, and `target="_blank" rel="noopener noreferrer"`. |
| 11 | Blog archive & 8 single technical articles | **PASS** | Verified `/blog/` Elementor page, `index.php` archive fallback, and `single.php` with `Article` schema. |
| 12 | Truthful JSON-LD schema markup | **PASS** | Valid `Organization`, `WebSite`, `WebPage`, `BreadcrumbList`, `Article`, `Product`, and conditional `FAQPage` schema; 0 fake ratings/prices. |
| 13 | `/llms.txt` discovery endpoint | **PASS** | Accurately describes **ArcticRestoDRY ICE** manufacturing & supply and notes `https://arcticresto.com/` as sister cleaning service. |
| 14 | Zero legacy franchise/blasting-first copy | **PASS** | Scanned all 40 pages, posts, and CPTs; 0 legacy franchise positioning strings remain. |
| 15 | Desktop, tablet & mobile responsiveness | **PASS** | Verified responsive grids across `1440px+`, `1200px`, `1024px`, `768px`, `430px`, `390px`, and `360px` with `overflow-x: hidden`. |
| 16 | Clean installable WordPress theme ZIP | **PASS** | Packaged `arctic-resto-dry-ice.zip` and `arctic-resto-latest.zip` with `arctic-resto/` root folder. |
