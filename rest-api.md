# REST API

> Full documentation: [https://ridecabwp.com/documentation](https://ridecabwp.com/documentation)

RideCab exposes two public REST endpoints under the `ridecab/v1` namespace. These are used internally by the booking form but can also be called by external applications.

Base URL: `https://your-site.com/wp-json/ridecab/v1/`

---

## POST /fare/estimate

Returns server-side fare estimates for all active vehicle types given a route.

**URL:** `POST /wp-json/ridecab/v1/fare/estimate`  
**Auth:** None required (public endpoint)

### Request Body

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `distance_km` | number | Yes | Route distance in kilometres |
| `duration_minutes` | integer | No | Estimated travel time in minutes |
| `pickup_datetime` | string | No | Pickup date and time (`Y-m-d H:i:s`) |
| `passengers` | integer | No | Number of passengers (default: 1) |
| `suitcases` | integer | No | Number of suitcases (default: 0) |
| `booked_hours` | number | No | Hours booked for `tiered_hourly` vehicles |
| `pickup_lat` | number | No | Pickup latitude — required for geofence rules |
| `pickup_lng` | number | No | Pickup longitude — required for geofence rules |
| `dropoff_lat` | number | No | Dropoff latitude — required for geofence rules |
| `dropoff_lng` | number | No | Dropoff longitude — required for geofence rules |
| `is_return` | integer | No | `1` to include a return leg in the fare, `0` for one-way (default: 0) |

### Response

HTTP 200 — object keyed by vehicle type ID.

```json
{
  "1": {
    "total": 24.50,
    "base": 5.00,
    "distance": 19.50,
    "duration": 0.00,
    "strategy": "distance",
    "minimum_applied": false,
    "errors": []
  },
  "2": {
    "total": 18.00,
    "base": 8.00,
    "distance": 10.00,
    "duration": 0.00,
    "strategy": "tiered_distance",
    "minimum_applied": false,
    "errors": []
  }
}
```

| Field | Description |
|-------|-------------|
| `total` | Final payable amount |
| `base` | Base fare component |
| `distance` | Distance-driven charge |
| `duration` | Duration-driven charge |
| `strategy` | Strategy used: `distance`, `tiered_distance`, `tiered_hourly`, `zone` |
| `minimum_applied` | `true` when the vehicle's minimum fare was enforced |
| `errors` | Non-empty when a vehicle is unavailable for this route (e.g. distance limits exceeded) — the booking form greys out such vehicles |

### Example Request

```bash
curl -X POST https://your-site.com/wp-json/ridecab/v1/fare/estimate \
  -H "Content-Type: application/json" \
  -d '{
    "distance_km": 12.5,
    "duration_minutes": 22,
    "pickup_datetime": "2026-06-01 14:00:00",
    "passengers": 2,
    "pickup_lat": 48.8566,
    "pickup_lng": 2.3522,
    "dropoff_lat": 48.8737,
    "dropoff_lng": 2.2950,
    "is_return": 0
  }'
```

---

## POST /cart/add

Validates booking data, recalculates the fare server-side, adds the booking as a WooCommerce cart item, and returns the checkout URL.

**URL:** `POST /wp-json/ridecab/v1/cart/add`  
**Auth:** Requires a valid WP nonce (`X-WP-Nonce` header)

### Request Body

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `pickup_address` | string | Yes | Full pickup address string |
| `pickup_lat` | number | Yes | Pickup latitude |
| `pickup_lng` | number | Yes | Pickup longitude |
| `dropoff_address` | string | Yes | Full dropoff address string |
| `dropoff_lat` | number | Yes | Dropoff latitude |
| `dropoff_lng` | number | Yes | Dropoff longitude |
| `pickup_datetime` | string | Yes | Pickup date and time (`Y-m-d H:i:s`) |
| `vehicle_type_id` | integer | Yes | ID of the selected vehicle type |
| `vehicle_name` | string | No | Display name of the vehicle (stored on order) |
| `passengers` | integer | No | Number of passengers |
| `suitcases` | integer | No | Number of suitcases |
| `distance_km` | number | No | Route distance |
| `duration_minutes` | integer | No | Estimated travel time |
| `booked_hours` | number | No | Hours booked (tiered hourly vehicles) |
| `is_return` | integer | No | `1` for return trip, `0` for one-way |
| `return_datetime` | string | No | Return date and time (`Y-m-d H:i:s`) — stored on order when `is_return=1` |
| `stops` | array | No | Intermediate stops: `[{address, lat, lng}]` |
| `form_id` | integer | No | ID of the booking form |

> The client-submitted price is **never trusted**. The server always recalculates the fare using the same fare engine as `/fare/estimate`.

### Response — Success

```json
{
  "success": true,
  "checkout_url": "https://your-site.com/checkout/",
  "price": 24.50
}
```

### Response — Error

```json
{
  "message": "Please select a vehicle."
}
```

HTTP status codes: `200` success, `422` validation error, `500` server error, `503` WooCommerce not active.

---

## Notes

- Both endpoints use `register_rest_route()` with `permission_callback => '__return_true'` for `/fare/estimate` (public) and a nonce check for `/cart/add` (session-sensitive).
- Geofence rules are only applied when both pickup and dropoff coordinates are provided and non-zero.
- Distance is never calculated by the REST endpoints themselves — pass the value from the Google Maps Directions API response for accurate road distances.

---

For more details visit [ridecabwp.com](https://ridecabwp.com) or the full docs at [ridecabwp.com/documentation](https://ridecabwp.com/documentation).
