<?php

/**
 * EDD_Son_Admin_Search Class
 *
 * Hooking into the EDD admin search mechanism
 *
 * @since 1.0.2
 */
class EDD_Son_Admin_Search {
    private static $_instance;

    public static function init(){
        if(self::$_instance == null){
            self::$_instance = new EDD_Son_Admin_Search();
        }
        return self::$_instance;
    }

    private function __construct(){
		add_action( 'edd_pre_get_payments', array( $this, 'search' ) );
    }


	/**
	 * Search through sequential order numbers
	 *
	 * @param $query The payment query
	 * @access public
	 * @since 1.0.2
	 * @return void
	 */
	public function search( $query ) {

		if( ! isset( $query->args[ 's' ] ) ) {
			return;
		}

		$search = trim( $query->args[ 's' ] );

		if( empty( $search ) ) {
			return;
		}

		if ( edd_get_option( 'edd_son_active' ) && (
				false !== strpos( $search, EDD_Son_Prefix::temporary() ) ||
				false !== strpos( $search, EDD_Son_Prefix::free() ) ||
				false !== strpos( $search, EDD_Son_Prefix::completed() ) ||
				false !== strpos( $search, EDD_Son_Postfix::temporary() ) ||
				false !== strpos( $search, EDD_Son_Postfix::free() ) ||
				false !== strpos( $search, EDD_Son_Postfix::completed() )
			) ) {

			$search_meta = array(
				'key'     => '_edd_son_payment_number',
				'value'   => $search,
				'compare' => 'LIKE'
			);

			$query->__set( 'meta_query', $search_meta );
			$query->__unset( 's' );
		}
	}
}
EDD_Son_Admin_Search::init();