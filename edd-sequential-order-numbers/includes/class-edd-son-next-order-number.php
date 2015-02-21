<?php

class EDD_Son_Next_Order_Number{

	/**
	 * Get the next order number for pending orders
	 *
	 * @return int
	 */
	public static function temporary()
	{
		return self::next( 'temp' );
	}

	/**
	 * Get the next free order number
	 *
	 * @return int
	 */
	public static function free()
	{
		return self::next( 'free' );
	}

	/**
	 * Get the next completed order number
	 *
	 * @return int
	 */
	public static function completed()
	{
		return self::next( 'completed' );
	}

	private static function next( $slug )
	{
		$next = absint( edd_get_option( 'edd_son_number_' . $slug, 1 ) );
		self::increment( $slug );

		return $next;
	}

	private static function increment( $slug )
	{
		global $edd_options;
		$edd_options['edd_son_number_' . $slug]++;
		update_option( 'edd_settings', $edd_options );
	}
}