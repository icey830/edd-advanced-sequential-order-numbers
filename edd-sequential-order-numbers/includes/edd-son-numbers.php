<?php

class EDD_Son_Numbers{
	public static function pending_order()
	{
		return self::next( 'temp' );
	}

	public static function free_order()
	{
		return self::next( 'free' );
	}

	public static function order()
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