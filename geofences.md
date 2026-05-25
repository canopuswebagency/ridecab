# Geofence Rules

> Full documentation: [https://ridecabwp.com/documentation](https://ridecabwp.com/documentation)

Geofence rules let you set special pricing for specific routes. You draw one or two polygons on a Google Map — one for the pickup zone and one for the dropoff zone — and define what happens when a booking matches those zones.

---

## How It Works

When a customer completes step 1 of the booking form, the server checks all active geofence rules against the pickup and dropoff coordinates using a **ray-casting point-in-polygon algorithm**.

- If the pickup point falls inside the **From zone** and the dropoff inside the **To zone** → the rule matches.
- If `direction` is set to **Both**, the reverse is also checked (pickup in To zone, dropoff in From zone).

Geofence rules are evaluated **in priority order** (highest priority first).

---

## Zone Types

Each side of a rule (From and To) can be one of two types:

| Type | Description |
|------|-------------|
| `precise` | A polygon drawn on the map. The point must fall inside the polygon. |
| `anywhere` | Matches any coordinate. Use for "from anywhere to Airport" rules. |

---

## Price Types

| Price Type | Effect |
|------------|--------|
| `fixed` | Replaces the strategy subtotal entirely with this amount. Only the highest-priority fixed rule applies — lower-priority fixed rules are ignored. |
| `addition` | Adds a flat amount on top of the strategy subtotal (treated as a surcharge line item). |
| `percentage` | Adds a percentage of the strategy subtotal (treated as a surcharge line item). |

---

## Creating a Geofence Rule

1. Go to **RideCab → Geofences → Add Rule**.
2. Enter a name and set the priority (higher = evaluated first).
3. Choose a **Direction**: From→To only, or Both ways.
4. Set the **From zone**: choose `Anywhere` or draw a polygon using the DrawingManager on the map.
5. Set the **To zone**: same options.
6. Set the **Price type** and amount.
7. Under **Vehicle Application**, uncheck any vehicles the rule should not apply to (all checked = applies to all vehicles).
8. Click **Save Rule**.

### Drawing a Polygon

- Click the polygon tool in the top-right of the map.
- Click to place vertices around your zone.
- Close the shape by clicking the first vertex again.
- The coordinates are saved automatically as a JSON array of `{lat, lng}` objects.

### Importing GeoJSON

You can paste a GeoJSON polygon directly into the import field instead of drawing it manually. The coordinates will be extracted and displayed on the map.

---

## Rule Priority

When multiple rules match the same booking:

- **Fixed rules**: only the highest-priority matching rule applies. All lower-priority fixed rules are skipped.
- **Addition rules**: all matching rules accumulate.
- **Percentage rules**: all matching rules accumulate (each percentage is of the base subtotal at the time of evaluation).

This means you can combine one fixed rule (to set the base price for a route) with multiple addition rules (airport fee, night surcharge, etc.).

---

## Trashing and Restoring Rules

Trashed rules are hidden from the fare calculator but not deleted from the database. They can be restored from the **Trash** view.

> **Important:** when a rule is restored, both the trash list and the `is_active` database flag are updated. If only one is changed, the rule may still be invisible to the fare calculator.

---

## Vehicle Filtering

Each rule has a **Vehicle Application** checkbox group. Leave all checked to apply the rule to every vehicle. Uncheck specific vehicles to exclude them.

The "none selected" state (all unchecked) is stored as `[]` in the database — this means the rule applies to **no vehicles**, not all vehicles. This is different from the default all-checked state for a new rule.

---

## Example: Airport Fixed Fare

**Scenario:** any ride to or from the airport costs €35 flat, for all vehicles.

| Field | Value |
|-------|-------|
| Name | Airport Fixed Fare |
| Direction | Both |
| From zone | Anywhere |
| To zone | Polygon around the airport terminal |
| Price type | Fixed |
| Price | 35.00 |
| Priority | 100 |

---

## Example: City Centre Surcharge

**Scenario:** add €5 to any ride that starts inside the city centre.

| Field | Value |
|-------|-------|
| Name | City Centre Pickup Fee |
| Direction | From → To |
| From zone | Polygon around city centre |
| To zone | Anywhere |
| Price type | Addition |
| Price | 5.00 |
| Priority | 50 |

---

For more details visit [ridecabwp.com/documentation](https://ridecabwp.com/documentation).
