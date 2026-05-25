# RideCab — Taxi & Cab Booking Plugin for WordPress

**RideCab** is a professional taxi and cab booking plugin for WordPress, built on top of WooCommerce. It turns any WordPress site into a fully featured ride-booking platform — complete with fare calculation, geofence rules, driver management, and PDF invoices.

🌐 **Website:** [https://ridecabwp.com](https://ridecabwp.com)  
📦 **Download:** [https://ridecabwp.com/#pricing](https://ridecabwp.com/#pricing)  
📄 **Documentation:** [https://ridecabwp.com/documentation](https://ridecabwp.com/documentation)  
📋 **Changelog:** [https://ridecabwp.com/changelog](https://ridecabwp.com/changelog)

---

## Features

- **Multi-step booking form** — embeddable via shortcode `[ridecab_booking_form]`, powered by Google Maps autocomplete
- **4 pricing strategies** — per km, per hour, tiered distance, tiered hourly — configurable per vehicle type
- **Polygon geofence rules** — draw pickup/dropoff zones on Google Maps, assign fixed fares or surcharges per route
- **Surge pricing** — date-range, day-of-week, and time-slot surcharges with flat or percentage modifiers
- **Return trip support** — optional return leg with configurable discount percentage
- **WooCommerce checkout** — all WC payment gateways work automatically; HPOS compatible
- **Driver management** — profiles, vehicle assignments, and a colour-coded FullCalendar view
- **PDF invoices** — 4 templates (Classic, Modern, Minimal, Corporate) with company branding
- **Email notifications** — branded booking confirmation emails to customer and admin
- **REST API** — public endpoints for fare estimation and cart integration
- **Translation-ready** — `.pot` file + bundled de_DE, fr_FR, es_ES, ar translations

---

## Requirements

| Requirement | Minimum |
|-------------|---------|
| WordPress | 5.8+ |
| WooCommerce | 7.0+ |
| PHP | 7.4+ |
| MySQL | 5.7+ |

---

## Quick Start

1. Purchase and download RideCab from [ridecabwp.com](https://ridecabwp.com).
2. Upload and activate the plugin in **WordPress → Plugins → Add New → Upload Plugin**.
3. Go to **RideCab → Settings → Maps** and enter your Google Maps API key.
4. Go to **RideCab → Vehicles** and create at least one vehicle type.
5. Place the shortcode `[ridecab_booking_form]` on any page.

Full setup guide: [https://ridecabwp.com/documentation](https://ridecabwp.com/documentation)

---

## Documentation

| Guide | Description |
|-------|-------------|
| [Getting Started](docs/getting-started.md) | Installation, first vehicle, first booking form |
| [Fare Engine](docs/fare-engines.md) | All 4 pricing strategies, surcharges, geofences |
| [Geofences](docs/geofences.md) | Drawing zones, rule priority, bidirectional routes |
| [REST API](docs/rest-api.md) | Public endpoints for fare estimation and cart |

---

## Changelog

See [changelog.md](changelog.md) or the full history at [ridecabwp.com/changelog](https://ridecabwp.com/changelog).

---

## Support

For support, feature requests, and bug reports, visit [ridecabwp.com](https://ridecabwp.com).

---

*Built by [Canopus Web Agency](https://canopuswebagency.com)*
