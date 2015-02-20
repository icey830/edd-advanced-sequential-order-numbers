<?php
class EDD_Son_Log{
	public static function log( $slug, $message, $details = '' )
	{
		$fh = fopen( EDD_SON_PLUGIN_DIR . 'logs/' . date( 'Y-m-d' ), 'a' );

		$output = " -----[$slug-" . date( 'd-m-Y H:i' ) . "]----- \n";
		$output .= $message . "\n";

		if( !empty( $details ) ){
			if( !is_string( $details ) && !is_numeric( $details ) )
				$details = print_r( $details, true );

			$output .= "\n --- Details ---\n$details\n";
		}

		$output .= ' ' . str_repeat('-', 20) . "\n\n";

		fwrite( $fh, $output );

		fclose( $fh );
	}
}