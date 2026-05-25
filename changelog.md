# RideCab Changelog

Full release history for the [RideCab WordPress plugin](https://ridecabwp.com).

---

## v1.0.9 — 2026-05-20

**New Features**

- **Custom email notifications — admin** — branded email sent to the site admin instantly when a new booking is placed, with full booking details and fare breakdown.
- **Custom email notifications — customer** — branded confirmation email sent to the customer when a new booking is placed, including booking summary and fare breakdown.
- **Return Trip Discount setting** — new field in Settings → General to configure a percentage discount (0–100%) applied to the return leg fare.

**Bug Fixes**

- **Return trip pricing fixed** — `is_return` was never forwarded to the fare estimate or cart endpoints; the return leg was always priced as zero. All three layers (JS state, `fare/estimate` REST endpoint, `cart/add` REST endpoint) now correctly calculate and charge the return leg.
- **Return date & time tracked in JS state** — return date, hour, and minute fields now sync to form state on change.
- **Return datetime shown in step 3 summary** — the booking summary now displays both the pickup datetime and the return datetime when a return trip is selected (e.g. `01 Jun 14:00 → 02 Jun 10:00`).

---

## v1.0.8 — 2026-04-27

**Initial Release**

- Multi-step booking form with Google Maps autocomplete via shortcode `[ridecab_booking_form]`.
- Four vehicle pricing strategies: per km, per hour, tiered distance, tiered hourly.
- Polygon geofence rules with fixed fare, flat surcharge, or percentage surcharge per route and vehicle; bidirectional or one-way direction support.
- WooCommerce checkout integration: rides processed through WC cart; all payment gateways available automatically; HPOS compatible.
- Driver management: create driver profiles, assign bookings, colour-coded FullCalendar view; disabled by default, opt-in via Settings.
- PDF invoices: four templates (Classic, Modern, Minimal, Corporate) with browser print-to-PDF and company branding settings.
- Surge pricing rules: date-based and time-slot-based surcharges with flat or percentage modifier; vehicle-specific application.
- Booking management dashboard: WP_List_Table with status badges, bulk actions, search, and filters; booking detail view with fare breakdown and driver assignment.
- FullCalendar integration: monthly/weekly/daily views with driver colour-coded events.
- Multiple booking forms: create independent forms with separate map settings, colours, and time intervals.
- 12h/24h time format: auto-detected from WordPress Settings → General; AM/PM embedded inside the hour field.
- Translation-ready: bundled `.pot` file; de_DE, fr_FR, es_ES, ar translations included.
- REST API: `/wp-json/ridecab/v1/` endpoints for fare estimation and cart.
- Appearance settings: primary/secondary colour pickers and custom error messages for the booking form.
- Activation hook: all custom database tables created on activation via `dbDelta()`.

---

For the full changelog with release badges visit [ridecabwp.com/changelog](https://ridecabwp.com/changelog).  
Plugin homepage: [ridecabwp.com](https://ridecabwp.com)
