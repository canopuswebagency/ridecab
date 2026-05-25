<?php
/**
 * RideCab — Custom Fare Hook Examples
 *
 * These examples show how to modify fare calculation results using the
 * ridecab_fare_calculated filter. Place this code in your theme's
 * functions.php or a custom plugin.
 *
 * Plugin website: https://ridecabwp.com
 * Documentation:  https://ridecabwp.com/documentation
 */

// ---------------------------------------------------------------------------
// Example 1: Add a flat airport fee when the dropoff is near an airport
// ---------------------------------------------------------------------------
// This example adds €10 to any booking whose dropoff coordinates fall within
// ~1 km of a specific airport location.

add_filter( 'ridecab_fare_calculated', function ( array $breakdown, array $params, array $vehicle ): array {

	$airport_lat = 48.9901; // Replace with your airport latitude
	$airport_lng =  2.5479; // Replace with your airport longitude
	$radius_km   =  1.0;

	$dlat = deg2rad( $params['dropoff_lat'] - $airport_lat );
	$dlng = deg2rad( $params['dropoff_lng'] - $airport_lng );
	$a    = sin( $dlat / 2 ) ** 2
		  + cos( deg2rad( $airport_lat ) ) * cos( deg2rad( $params['dropoff_lat'] ) ) * sin( $dlng / 2 ) ** 2;
	$dist = 6371.0 * 2.0 * atan2( sqrt( $a ), sqrt( 1.0 - $a ) );

	if ( $dist <= $radius_km ) {
		$fee = 10.00;
		$breakdown['surcharges']      += $fee;
		$breakdown['surcharge_items'][] = [ 'name' => 'Airport drop-off fee', 'amount' => $fee ];
		$breakdown['total']           += $fee;
	}

	return $breakdown;

}, 10, 3 );


// ---------------------------------------------------------------------------
// Example 2: Apply a 15% loyalty discount for a specific WP user
// ---------------------------------------------------------------------------

add_filter( 'ridecab_fare_calculated', function ( array $breakdown, array $params, array $vehicle ): array {

	$loyalty_user_id = 42; // Replace with the WP user ID

	if ( (int) $params['user_id'] !== $loyalty_user_id ) {
		return $breakdown;
	}

	$discount = round( $breakdown['total'] * 0.15, 2 );

	$breakdown['discount'] += $discount;
	$breakdown['total']     = max( 0.0, $breakdown['total'] - $discount );

	return $breakdown;

}, 10, 3 );


// ---------------------------------------------------------------------------
// Example 3: Force a minimum fare of €20 for night bookings (22:00–06:00)
// ---------------------------------------------------------------------------

add_filter( 'ridecab_fare_calculated', function ( array $breakdown, array $params, array $vehicle ): array {

	$pickup_hour = (int) gmdate( 'H', strtotime( $params['pickup_datetime'] ) );
	$is_night    = $pickup_hour >= 22 || $pickup_hour < 6;

	if ( $is_night && $breakdown['total'] < 20.00 ) {
		$breakdown['total']           = 20.00;
		$breakdown['minimum_applied'] = true;
	}

	return $breakdown;

}, 10, 3 );


// ---------------------------------------------------------------------------
// Example 4: Add a per-stop charge of €3 (if not already configured globally)
// ---------------------------------------------------------------------------

add_filter( 'ridecab_fare_calculated', function ( array $breakdown, array $params, array $vehicle ): array {

	$stop_count = count( $params['waypoints'] );

	if ( $stop_count > 0 ) {
		$charge = $stop_count * 3.00;
		$breakdown['extras']        += $charge;
		$breakdown['extras_items'][] = [
			'id'         => 0,
			'name'       => 'Additional stops',
			'quantity'   => $stop_count,
			'unit_price' => 3.00,
			'total'      => $charge,
		];
		$breakdown['total'] += $charge;
	}

	return $breakdown;

}, 10, 3 );
