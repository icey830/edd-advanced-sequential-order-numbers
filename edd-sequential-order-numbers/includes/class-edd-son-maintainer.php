<?php
class EDD_Son_Maintainer {
    private static $_instance;

    public static function init(){
        if(self::$_instance == null){
            self::$_instance = new EDD_Son_Maintainer();
        }
        return self::$_instance;
    }

    private function __construct(){
        add_action( 'init', array( $this, 'maintain' ) );
    }

	public function maintain()
	{
		if( !isset($_GET['son'] ) )
			return;

		$payments = edd_get_payments( array(
			'number' => 9999,
			'orderby'    => 'id',
			'order'      => 'ASC',
		));

		$edd_son = EDD_Son::instance();

		foreach($payments as $p){
			$edd_son->assign_order_number( $p->ID );
		}

		wp_die( 'done! :-)' );
	}
}
EDD_Son_Maintainer::init();