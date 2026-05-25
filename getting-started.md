# Getting Started with RideCab

> Full documentation: [https://ridecabwp.com/documentation](https://ridecabwp.com/documentation)

---

## 1. Installation

1. Purchase RideCab at [ridecabwp.com](https://ridecabwp.com).
2. In your WordPress admin, go to **Plugins → Add New → Upload Plugin**.
3. Upload the `ridecab.zip` file and click **Install Now**.
4. Click **Activate Plugin**.

RideCab requires WooCommerce to be installed and active. If WooCommerce is missing, an admin notice will appear at the top of every admin page.

On activation, RideCab automatically creates the following database tables:

| Table | Purpose |
|-------|---------|
| `ridecab_bookings` | All booking records |
| `ridecab_vehicle_types` | Vehicle definitions and pricing |
| `ridecab_tiered_pricing` | Tiered pricing rows per vehicle |
| `ridecab_booking_forms` | Booking form configurations |
| `ridecab_geofence_rules` | Polygon-based pricing zones |
| `ridecab_surcharges` | Time/date surge pricing rules |
| `ridecab_drivers` | Driver profiles |

---

## 2. Google Maps API Keys

RideCab uses two separate Google Maps API keys for security:

### Client Key (browser-side)
Enable these APIs in Google Cloud Console:
- **Maps JavaScript API** — renders the interactive map
- **Places API** — address autocomplete on pickup/dropoff inputs
- **Geocoding API** — converts a typed address to coordinates
- **Directions API** — draws the route on the map

Restrict this key to your domain (HTTP referrers).

### Server Key (server-side, never sent to browser)
Enable these APIs:
- **Distance Matrix API** — calculates road distance and travel time for fare calculation
- **Geocoding API** — server-side address-to-coordinates conversion

Restrict this key to your server's IP address.

Enter both keys in **RideCab → Settings → Maps**.

---

## 3. Create Your First Vehicle

Go to **RideCab → Vehicles → Add Vehicle**.

| Field | Description |
|-------|-------------|
| Name | Displayed to customers (e.g. "Economy", "Business") |
| Max Passengers | Limits the passenger counter on the form |
| Max Luggage | Displayed as bags capacity on the vehicle card |
| Pricing Type | `per_km`, `per_hour`, `tiered_distance`, or `tiered_hourly` |
| Base Fare | Fixed charge applied to every booking |
| Per Km Rate | Charge per kilometre (for `per_km` strategy) |
| Minimum Fare | Floor price — the total never falls below this |
| Vehicle Image | Shown on the booking form vehicle card |

See [fare-engines.md](fare-engines.md) for a full explanation of each pricing strategy.

---

## 4. Create a Booking Form

Go to **RideCab → Booking Forms → Add Form**.

Key options:

| Option | Description |
|--------|-------------|
| Primary Color | Accent colour for buttons and step indicators |
| Time Interval | Minute increment in the time picker (e.g. 15 = 0, 15, 30, 45) |
| Show Passenger Input | Toggle the passenger counter |
| Show Suitcase Input | Toggle the suitcase counter |
| Enable Waypoints | Allow customers to add intermediate stops |
| Enable Return Trip | Show a return trip toggle with a second date/time picker |
| Enable Instant Booking | Show a second tab for near-future time slots |
| Show Map | Display the Google Maps route preview alongside the form |

---

## 5. Embed the Form

Place the shortcode on any page or post:

```
[ridecab_booking_form id="1"]
```

Replace `1` with the ID of the form you created. Multiple forms with different configurations can be embedded on different pages.

---

## 6. Settings Overview

Navigate to **RideCab → Settings** to configure global behaviour.

### General
- **Booking Number Prefix** — e.g. `RC-` produces `RC-0001`
- **Minimum Booking Advance** — hours before pickup customers can book
- **Maximum Booking Advance** — days ahead customers can schedule
- **Return Trip Discount** — percentage discount applied to the return leg (0 = full price, 20 = 20% off return)
- **Driver Mode** — enable the Drivers submenu

### Maps
- Google Maps client and server API keys
- Default map zoom level
- Distance unit (km or miles)

### Appearance
- Primary and secondary colour pickers
- Custom error messages shown to customers

### Emails
- Company logo, name, address, phone, and email shown in notification footers

---

## 7. Test a Booking

1. Visit the page with your booking form.
2. Enter a pickup and destination address.
3. Select a date and time.
4. Click **Search vehicles** — the fare is calculated server-side.
5. Select a vehicle and click **Book this ride**.
6. Review the summary and click **Confirm & Pay**.
7. Complete checkout via WooCommerce.

The booking will appear in **RideCab → Bookings** with status `pending`.

---

For more details visit [ridecabwp.com/documentation](https://ridecabwp.com/documentation).
