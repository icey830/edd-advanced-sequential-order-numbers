<?php
class EDD_Son_Settings{
	/**
	 * Add settings
	 *
	 * @access      public
	 * @since       1.0.0
	 * @param       array $settings The existing EDD settings array
	 * @return      array The modified EDD settings array
	 */
	public static function settings( $settings ) {
		$new_settings = array(
			array(
				'id'    => 'edd_son_settings',
				'name'  => '<strong>' . __( 'Sequential Order Numbers Settings', EDD_SON_LANG ) . '</strong>',
				'desc'  => __( 'Configure Sequential Order Numbers', EDD_SON_LANG ),
				'type'  => 'header'
			),
			array(
				'id' => 'edd_son_active',
				'name' => __('Enable', EDD_SON_LANG),
				'desc' => __('Enable Sequential Order Numbers', EDD_SON_LANG ),
				'type' => 'checkbox'
			),
			array(
				'id' => 'edd_son_prefix_temp',
				'name' => __('Temp. Prefix', EDD_SON_LANG),
				'desc' => __('Enter the prefix used for temporary order numbers (like pending orders)', EDD_SON_LANG ),
				'type' => 'text',
				'size' => 'small'
			),
			array(
				'id' => 'edd_son_prefix_free',
				'name' => __('Free Prefix', EDD_SON_LANG),
				'desc' => __('Enter the prefix used for free orders', EDD_SON_LANG ),
				'type' => 'text',
				'size' => 'small'
			),
			array(
				'id' => 'edd_son_prefix_completed',
				'name' => __('Completed Prefix', EDD_SON_LANG),
				'desc' => __('Enter the prefix used for completed orders, which are not free.', EDD_SON_LANG ),
				'type' => 'text',
				'size' => 'small'
			),

			array(
				'id' => 'edd_son_number_temp',
				'name' => __('Temp #', EDD_SON_LANG),
				'desc' => __('Next temporary order number.', EDD_SON_LANG ),
				'type' => 'number',
				'size' => 'small',
				'min' => 1,
				'step' => 1
			),
			array(
				'id' => 'edd_son_number_free',
				'name' => __('Free #', EDD_SON_LANG),
				'desc' => __('Next free order number.', EDD_SON_LANG ),
				'type' => 'number',
				'size' => 'small',
				'min' => 1,
				'step' => 1
			),
			array(
				'id' => 'edd_son_number_completed',
				'name' => __('Completed #', EDD_SON_LANG),
				'desc' => __('Next completed order number.', EDD_SON_LANG ),
				'type' => 'number',
				'size' => 'small',
				'min' => 1,
				'step' => 1
			),
		);
		return array_merge( $settings, $new_settings );
	}
}