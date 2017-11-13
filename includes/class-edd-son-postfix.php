<?php

/**
 * Class EDD_Son_Prefix Simple way of getting order number prefixes
 */
class EDD_Son_Postfix {

	public static function temporary() {
		return edd_get_option( 'edd_son_postfix_temp', '' );
	}

	public static function free() {
		return edd_get_option( 'edd_son_postfix_free', '' );
	}

	public static function completed() {
		return edd_get_option( 'edd_son_postfix_completed', '' );
	}
}