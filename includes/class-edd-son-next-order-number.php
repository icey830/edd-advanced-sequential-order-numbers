<?php

class EDD_Son_Next_Order_Number {

	/**
	 * Get the next order number for pending orders
	 *
	 * @return int
	 */
	public static function temporary() {
		return self::next( 'temp' );
	}

	/**
	 * Get the next free order number
	 *
	 * @return int
	 */
	public static function free() {
		return self::next( 'free' );
	}

	/**
	 * Get the next completed order number
	 *
	 * @return int
	 */
	public static function completed() {
		return self::next( 'completed' );
	}

	private static function next( $slug ) {
		$next = absint( edd_get_option( 'edd_son_number_' . $slug, 1 ) );
		self::increment( $slug );

		// Check if we should pad the order number.
		// If not, simply return the generated number.
		$padding_type = edd_get_option( 'edd_son_number_padding_type', 'no_padding' );
		if ( $padding_type == 'no_padding' ) {
			return $next;
		}

		$padding_type = ( $padding_type == 'pad_left' ? STR_PAD_LEFT : STR_PAD_RIGHT );

		// Get the total length of our order numbers.
		$padding_length = absint( edd_get_option( 'edd_son_number_padding_length', 5 ) );
		$padding_char   = edd_get_option( 'edd_son_number_padding_char', '0' );

		if ( strlen( $padding_char ) === 0 ) {
			return $next;
		}

		return str_pad( $next, $padding_length, $padding_char, $padding_type );
	}

	private static function increment( $slug ) {
		global $edd_options;

		if ( isset( $edd_options[ 'edd_son_number_' . $slug ] ) && ! empty( $edd_options[ 'edd_son_number_' . $slug ] ) && is_numeric( $edd_options[ 'edd_son_number_' . $slug ] ) ) {
			$edd_options[ 'edd_son_number_' . $slug ]++;
		} else {
			$edd_options[ 'edd_son_number_' . $slug ] = 2;
		}
		update_option( 'edd_settings', $edd_options );
	}
}