<?php

class EDD_Son_Prefix {
	public static function pending_order()
	{
		return edd_get_option( 'edd_son_prefix_temp', 'temp' );
	}

	public static function free_order()
	{
		return edd_get_option( 'edd_son_prefix_free', 'free' );
	}

	public static function order()
	{
		return edd_get_option( 'edd_son_prefix_completed', 'completed' );
	}
}