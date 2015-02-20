<?php
/**
 * Plugin Name: Easy Digital Downloads Sequential Order Numbers
 * Plugin URI: http://edd-son.com
 * Description: Real sequential order numbers for Easy Digital Downloads.
 * Version: 1.0.0
 * Author: 1337 ApS
 * Author URI: http://1337.dk
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'EDD_Plugin_Name' ) ) {

	class EDD_Son {
		private static $_instance;

		/**
		 * Get active instance
		 *
		 * @access      public
		 * @since       1.0.0
		 * @return      object self::$instance The one true EDD_Son
		 */
		public static function instance(){
			if(self::$_instance == null){
				self::$_instance = new EDD_Son();
				self::$_instance->setup_constants();
				self::$_instance->includes();
				self::$_instance->load_textdomain();
				self::$_instance->hooks();
			}
			return self::$_instance;
		}

		/**
		 * Setup plugin constants
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function setup_constants()
		{
			define( 'EDD_SON_PLUGIN_FILE', __FILE__ );
			define( 'EDD_SON_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
			define( 'EDD_SON_PLUGIN_URL', trailingslashit( plugin_dir_url(__FILE__) ) );
			define( 'EDD_SON_VERSION', '1.0.0' );
			define( 'EDD_SON_DEBUG', false );
			define( 'EDD_SON_LANG', 'edd-son' );
		}

		/**
		 * Include necessary files
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function includes()
		{
			require_once 'includes/edd-son-log.php';
			require_once 'includes/edd-son-settings.php';
			require_once 'includes/edd-son-numbers.php';
			require_once 'includes/edd-son-prefix.php';
		}

		/**
		 * Run action and filter hooks
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function hooks() {
			// Register settings
			add_filter( 'edd_settings_extensions', array( 'EDD_Son_Settings', 'settings' ), 1 );

			// Inject order number functionality
			add_action( 'edd_insert_payment', array( $this, 'assign_order_number' ), 10, 2 );
			add_action( 'edd_update_payment_status', array( $this, 'order_completed' ), 10, 3 );
			add_filter( 'edd_payment_number', array( $this, 'get_payment_number' ), 10, 2 );

			// Handle licensing
			if( class_exists( 'EDD_License' ) ) {
				$license = new EDD_License( __FILE__, 'Easy Digital Downloads Sequential Order Numbers', EDD_SON_VERSION, '1337 ApS' );
			}
		}

		/**
		 * Internationalization
		 *
		 * @access      public
		 * @since       1.0.0
		 * @return      void
		 */
		public function load_textdomain() {
			// Set filter for language directory
			$lang_dir = EDD_SON_PLUGIN_DIR . '/languages/';
			$lang_dir = apply_filters( 'edd_' . EDD_SON_LANG . '_languages_directory', $lang_dir );

			// Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale', get_locale(), EDD_SON_LANG );
			$mofile = sprintf( '%1$s-%2$s.mo', EDD_SON_LANG, $locale );

			// Setup paths to current locale file
			$mofile_local   = $lang_dir . $mofile;
			$mofile_global  = WP_LANG_DIR . '/' . EDD_SON_LANG . '/' . $mofile;

			if( file_exists( $mofile_global ) ) {
				// Look in global /wp-content/languages/edd-plugin-name/ folder
				load_textdomain( EDD_SON_LANG, $mofile_global );

			} elseif( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/edd-plugin-name/languages/ folder
				load_textdomain( EDD_SON_LANG, $mofile_local );

			} else {
				// Load the default language files
				load_plugin_textdomain( EDD_SON_LANG, false, $lang_dir );
			}
		}

		private function is_active()
		{
			return edd_get_option( 'edd_son_active' );
		}

		public function get_payment_number( $number, $payment_id )
		{
			if( $this->is_active() ) {
				$sequential_number = edd_get_payment_meta( $payment_id, '_edd_son_payment_number', true );

				if( $sequential_number )
					$number = $sequential_number;
			}

			return $number;
		}

		public function order_completed( $payment_id, $new_status, $old_status )
		{
			EDD_Son_Log::log("order_completed", "Order $payment_id - $new_status - $old_status");

			// Only run this update on orders that're completed
			if( $new_status != 'publish' )
				return;

			// (Re)assign the order number. We reassign
			// because the previously assigned number
			// was simply a "pending" order number.
			$this->assign_order_number( $payment_id );
		}

		/**
		 * Assign a sequential order number to the order
		 *
		 * @param $payment
		 * @param $payment_data
		 */
		public function assign_order_number( $payment_id, $payment_data = null){
			// First check if the plugin is active.
			// If not, don't do anything!
			if( !$this->is_active() )
				return;

			$payment = get_post( $payment_id );

			// Get the next order number including
			// it's pre-/postfix.
			$number = $this->next_payment_number( $payment );

			EDD_Son_Log::log("assign_order_number_2", "Next Order Number: $number");

			// Set the order number!
			edd_update_payment_meta( $payment->ID, '_edd_son_payment_number', $number );
		}

		/**
		 * Get the next payment number, including pre-/postfix.
		 *
		 * @param $payment Payment post object
		 * @param array/null $payment_data
		 *
		 * @return string The next payment number, for the specific order type
		 */
		private function next_payment_number( $payment )
		{
			$number = '';

			// Get the payment total
			$payment_total = edd_get_payment_amount( $payment->ID );

			// If the order isn't completed, we set a temporary order number
			if( $payment->post_status != 'publish' ){
				$number = EDD_Son_Prefix::pending_order() . EDD_Son_Numbers::pending_order();

				// Store the temporary payment number, for (possible)
				// later use. This is because the temp. order number
				// will be overwritten, once the order is completed.
				edd_update_payment_meta( $payment->ID, '_edd_son_temp_payment_number', $number );

			// The order is completed now, so we should
			// set the actual prefix. First check if
			// this is a free order.
			}elseif( $payment_total  == 0 )
				$number = EDD_Son_Prefix::free_order() . EDD_Son_Numbers::free_order();

			// Since the order is completed, and it's
			// not free, this must be a regular order.
			else
				$number = EDD_Son_Prefix::order() . EDD_Son_Numbers::order();

			// Return the order number
			return $number;
		}
	}
} // end class exists check


/**
 * The main function responsible for returning the one true EDD_Plugin_Name
 * instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \EDD_Plugin_Name The one true EDD_Plugin_Name
 *
 * @todo        Inclusion of the activation code below isn't mandatory, but
 *              can prevent any number of errors, including fatal errors, in
 *              situations where your extension is activated but EDD is not
 *              present.
 */
function EDD_Son_load() {
	if( ! class_exists( 'Easy_Digital_Downloads' ) ) {
		if( ! class_exists( 'EDD_Extension_Activation' ) ) {
			require_once 'includes/class.extension-activation.php';
		}
		$activation = new EDD_Extension_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
		$activation = $activation->run();
		return EDD_Son::instance();
	} else {
		return EDD_Son::instance();
	}
}
add_action( 'plugins_loaded', 'EDD_Son_load' );