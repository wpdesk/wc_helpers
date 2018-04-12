<?php

class WPDesk_Helpers_WC_Order_LegacyV27 implements WPDesk_Helpers_WC_Order_Interface {

	/** @var WC_Order */
	private $order;

	/** @var int */
	private $order_id;

	/** @var array */
	private $meta_data;

	public function __construct( WC_Order $order ) {
		$this->order    = $order;
		$this->order_id = $order->id;
	}

	/**
	 * Save data to the database.
	 *
	 * @return int order ID
	 */
	public function save() {
		foreach ( $this->meta_data as $name => $value ) {
			update_post_meta( $this->order_id, $name, $value );
		}

		return $this->order_id;
	}

	/**
	 * Get billing first name.
	 *
	 * @param  string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string
	 */
	public function get_billing_first_name( $context = 'view' ) {
		return $this->get_order_meta( self::META_NAME_BILLING_FIRST_NAME, true );
	}

	/**
	 * @param string $meta_key
	 * @param bool $single
	 *
	 * @return mixed
	 */
	private function get_order_meta( $meta_key, $single = false ) {
		switch ( $meta_key ) {
			case 'order_date':
				return $this->order->order_date;
			case 'customer_note':
				return $this->order->customer_note;
			default:
				return get_post_meta( $this->order_id, $meta_key, $single );
		}
	}

	/**
	 * Set billing first name.
	 *
	 * @param string $value Billing first name.
	 *
	 * @throws WC_Data_Exception Throws exception when invalid data is found.
	 */
	public function set_billing_first_name( $value ) {
		$this->meta_data[ self::META_NAME_BILLING_FIRST_NAME ] = $value;
	}


}