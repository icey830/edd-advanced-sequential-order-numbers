<?php
class EDD_Son_Settings{
	public static function setting_tabs( $tabs )
	{
		$tabs['edd_son'] = __('Order Numbers', 'edd-son' );

		return $tabs;
	}

	public static function remove_edd_settings( $settings )
	{
		unset( $settings['enable_sequential'] );
		unset( $settings['sequential_start'] );
		unset( $settings['sequential_prefix'] );
		unset( $settings['sequential_postfix'] );

		return $settings;
	}

	/**
	 * Add settings
	 *
	 * @access      public
	 * @since       1.0.0
	 * @param       array $settings The existing EDD settings array
	 * @return      array The modified EDD settings array
	 */
	public static function settings( $settings ) {
		$settings['edd_son'] = array(
			array(
				'id' => 'edd_son_active',
				'name' => __('Enable', 'edd-son'),
				'desc' => __('Enable Advanced Sequential Order Numbers', 'edd-son' ),
				'type' => 'checkbox'
			),

			array(
				'id' => 'edd_son_free_number_series',
				'name' => __('Free Orders number series', 'edd-son'),
				'desc' => __('Enable the number series for free orders.', 'edd-son' ),
				'type' => 'checkbox'
			),

			/** Order number prefixes **/
			/***************************/
			array(
				'id'    => 'edd_son_settings_prefixes',
				'name'  => '<strong>' . __( 'Number Series Prefixes', 'edd-son' ) . '</strong>',
				'desc'  => __( 'Define prefixes for all number series.', 'edd-son' ),
				'type'  => 'header'
			),
			array(
				'id' => 'edd_son_prefix_temp',
				'name' => __('Temp. Prefix', 'edd-son'),
				'desc' => __('Enter the prefix used for temporary order numbers (like pending orders)', 'edd-son' ),
				'type' => 'text',
				'size' => 'medium'
			),
			array(
				'id' => 'edd_son_prefix_free',
				'name' => __('Free Prefix', 'edd-son'),
				'desc' => __('Enter the prefix used for free orders', 'edd-son' ),
				'type' => 'text',
				'size' => 'medium'
			),
			array(
				'id' => 'edd_son_prefix_completed',
				'name' => __('Completed Prefix', 'edd-son'),
				'desc' => __('Enter the prefix used for completed orders, which are not free.', 'edd-son' ),
				'type' => 'text',
				'size' => 'medium'
			),

			/** Order number postfixes **/
			/****************************/
			array(
				'id'    => 'edd_son_settings_postfixes',
				'name'  => '<strong>' . __( 'Number Series Postfixes', 'edd-son' ) . '</strong>',
				'desc'  => __( 'Define postfixes for all number series.', 'edd-son' ),
				'type'  => 'header'
			),
			array(
				'id' => 'edd_son_postfix_temp',
				'name' => __('Temp. Postfix', 'edd-son'),
				'desc' => __('Enter the postfix used for temporary order numbers (like pending orders)', 'edd-son' ),
				'type' => 'text',
				'size' => 'medium'
			),
			array(
				'id' => 'edd_son_postfix_free',
				'name' => __('Free Postfix', 'edd-son'),
				'desc' => __('Enter the postfix used for free orders', 'edd-son' ),
				'type' => 'text',
				'size' => 'medium'
			),
			array(
				'id' => 'edd_son_postfix_completed',
				'name' => __('Completed Postfix', 'edd-son'),
				'desc' => __('Enter the postfix used for completed orders, which are not free.', 'edd-son' ),
				'type' => 'text',
				'size' => 'medium'
			),

			/** Order number padding **/
			/**************************/
			array(
				'id'    => 'edd_son_settings_padding',
				'name'  => '<strong>' . __( 'Order number padding', 'edd-son' ) . '</strong>',
				'desc'  => '',
				'type'  => 'header'
			),
			array(
				'id' => 'edd_son_number_padding_type',
				'name' => __('Pad order numbers', 'edd-son'),
				'desc' => __('Add padding before, after or not at all, to order numbers.', 'edd-son' ),
				'type' => 'radio',
				'std' => 'no_padding',
				'options' => array(
					'no_padding' => __( 'No padding', 'edd-son' ),
					'pad_left' => __( 'Pad left', 'edd-son' ),
					'pad_right'  => __( 'Pad right', 'edd-son' )
				)
			),
			array(
				'id' => 'edd_son_number_padding_char',
				'name' => __('Pad with', 'edd-son'),
				'desc' => __('The character which will be used for padding order numbers.', 'edd-son' ),
				'type' => 'text',
				'size' => 'small'
			),

			array(
				'id' => 'edd_son_number_padding_length',
				'name' => __('Order number length', 'edd-son'),
				'desc' => __('How long should the order number be? Eg. a length of 5, and order number 123, can produce XX123.', 'edd-son' ),
				'type' => 'text',
				'size' => 'small'
			),

			/** Order numbers **/
			/*******************/
			array(
				'id'    => 'edd_son_settings_numbers',
				'name'  => '<strong>' . __( 'Next order numbers', 'edd-son' ) . '</strong>',
				'desc'  => '',
				'type'  => 'header'
			),
			array(
				'id' => 'edd_son_number_temp',
				'name' => __('Temp #', 'edd-son'),
				'desc' => __('Next temporary order number.', 'edd-son' ),
				'type' => 'number',
				'size' => 'small',
				'min' => 1,
				'step' => 1
			),
			array(
				'id' => 'edd_son_number_free',
				'name' => __('Free #', 'edd-son'),
				'desc' => __('Next free order number.', 'edd-son' ),
				'type' => 'number',
				'size' => 'small',
				'min' => 1,
				'step' => 1
			),
			array(
				'id' => 'edd_son_number_completed',
				'name' => __('Completed #', 'edd-son'),
				'desc' => __('Next completed order number.', 'edd-son' ),
				'type' => 'number',
				'size' => 'small',
				'min' => 1,
				'step' => 1
			),
		);
		return $settings;
	}
}