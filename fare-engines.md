# Fare Engine

> Full documentation: [https://ridecabwp.com/documentation](https://ridecabwp.com/documentation)

RideCab calculates fares entirely server-side. The client-submitted price is never trusted — the server always recalculates before adding to the WooCommerce cart.

---

## Pricing Strategies

Each vehicle type uses one of four strategies, selected in **RideCab → Vehicles → Edit Vehicle**.

### 1. Per Kilometre (`per_km`)

```
total = base_fare + (distance_km × per_km_rate)
```

Best for: standard metered taxi services where the fare scales linearly with distance.

**Vehicle fields used:** `base_fare`, `per_km_rate`, `minimum_fare`

---

### 2. Per Hour (`per_hour`)

```
total = base_fare + (duration_minutes / 60 × per_hour_rate)
```

Best for: chauffeur or hourly hire services. Uses the Google Maps estimated travel time, not the booked hours input.

**Vehicle fields used:** `base_fare`, `per_hour_rate`, `minimum_fare`

---

### 3. Tiered Distance (`tiered_distance`)

The fare is calculated by applying different rates across distance bands. Each tier row defines a range (`value_from` → `value_to` km) and a rate per km within that range.

**Example:**

| From (km) | To (km) | Rate (per km) |
|-----------|---------|---------------|
| 0 | 10 | €2.50 |
| 10 | 50 | €2.00 |
| 50 | ∞ | €1.50 |

Best for: services that offer cheaper per-km rates for longer journeys.

**Vehicle fields used:** `base_fare`, `minimum_fare`, tiers in `ridecab_tiered_pricing`

---

### 4. Tiered Hourly (`tiered_hourly`)

The fare is calculated using different rates across booked-hours bands. The customer selects the number of hours on the booking form step 2.

**Example:**

| From (h) | To (h) | Rate (per hour) |
|----------|--------|-----------------|
| 0 | 3 | €40.00 |
| 3 | 8 | €35.00 |
| 8 | ∞ | €30.00 |

Best for: full-day or half-day vehicle hire.

---

## Calculation Order

The fare calculator applies components in this exact order:

1. **Strategy** — base + distance/duration component from the chosen strategy
2. **Vehicle multiplier** — scales the strategy subtotal (`multiplier` field, default 1.0)
3. **Geofence rules** — polygon-based fixed fares or surcharges (see [geofences.md](geofences.md))
4. **Extras** — per-passenger, per-suitcase, waiting time, additional stops
5. **Minimum fare** — floor is applied here, before surcharges
6. **Surcharges** — time/date-based surge rules applied on top of the minimum
7. **Return leg** — adds the same subtotal again, minus the return trip discount
8. **Coupon discount** — applied last via WooCommerce coupons
9. **Final total** — `max(0, subtotal - discount)`

---

## Minimum Fare

Set `minimum_fare` on the vehicle. The minimum is enforced **before** surcharges so that time-based surge rules are always visible on top of the minimum and never hidden by it.

---

## Return Trip Discount

When the customer toggles **Return trip** on the booking form:

- The return leg is priced as the same subtotal as the outbound leg.
- A percentage discount can be configured in **RideCab → Settings → General → Return Trip Discount**.
- `0%` = full price for both legs (total = outbound × 2)
- `20%` = return leg costs 20% less (total = outbound × 1.8)
- `100%` = return leg is free (total = outbound × 1.0)

---

## Surcharges

Go to **RideCab → Surcharges → Add Surcharge**.

| Type | When it applies |
|------|----------------|
| `fixed_date` | Between a specific date-from and date-to range |
| `weekly` | On selected days of the week |
| `daily_time` | During specific time slots every day |

| Price Type | Behaviour |
|------------|-----------|
| `flat` | Adds a fixed amount to the fare |
| `percentage` | Adds a percentage of the current subtotal |

Surcharges can be restricted to specific vehicle types. All checked by default — uncheck to exclude a vehicle.

---

## Vehicle Extras

Additional per-booking charges configurable on the vehicle:

| Field | Description |
|-------|-------------|
| `per_passenger_rate` | Charge per passenger beyond the first |
| `per_suitcase_rate` | Charge per suitcase |
| `min_distance_km` | Minimum bookable distance (hard error if not met) |
| `max_distance_km` | Maximum bookable distance (hard error if exceeded) |

---

## Developer Hook

The full fare breakdown can be modified before it is returned:

```php
add_filter( 'ridecab_fare_calculated', function ( $breakdown, $params, $vehicle ) {
    // $breakdown keys: base, distance, duration, extras, surcharges, discount, total, ...
    return $breakdown;
}, 10, 3 );
```

See [examples/custom-fare-hook.php](../examples/custom-fare-hook.php) for a practical example.

More details at [ridecabwp.com/documentation](https://ridecabwp.com/documentation).
