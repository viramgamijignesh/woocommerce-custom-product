<?php
/**
 * Plugin Name: Woo Custom Product Type - Call For Price
 * Plugin URI:  https://github.com/viramgamijignesh
 * Description: A sample plugin for Woo Custom product type - call for price
 * Version:     1.0
 * Author:      Viramgami Jignesh 
 */

// Check Woocommerce install or not
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    

	function callback_for_setting_up_scripts() {
		//wp_register_style('custom-css', plugins_url('assets/custom.css',__FILE__ ));
		wp_register_style( 'custom-css', plugins_url( '/assets/css/custom.css', __FILE__ ) );
		wp_enqueue_style('custom-css');
		// wp_register_script( 'custom-js', plugins_url('assets/custom.js',__FILE__ ));
		wp_register_script( 'jquery-cust', plugins_url( '/assets/js/jquery.min.js', __FILE__ ) );
		wp_enqueue_script('jquery-cust');
		wp_register_script( 'custom-js', plugins_url( '/assets/js/custom.js', __FILE__ ) );
		wp_enqueue_script('custom-js');
	}

	add_action( 'wp_enqueue_scripts','callback_for_setting_up_scripts');

	add_action( 'plugins_loaded', 'wcpt_register_call_for_price_type' );
	function wcpt_register_call_for_price_type () {
		// declare the product class
	    class WC_Product_Call_For_Price extends WC_Product {
	        public function __construct( $product ) {
	           $this->product_type = 'call_for_price';
	           parent::__construct( $product );
	           // add additional functions here
	        }
	    }
	}
	add_filter( 'product_type_selector', 'wcpt_add_call_for_price_type' );
	function wcpt_add_call_for_price_type ( $type ) {
		// Key should be exactly the same as in the class product_type
		$type[ 'call_for_price' ] = __( 'Call For Type' );
		
		return $type;
	}
	add_filter( 'woocommerce_product_data_tabs', 'call_for_price_tab' );
	function call_for_price_tab( $tabs) {
		
		$tabs['call_for_price'] = array(
			'label'	 => __( 'Price Note', 'wcpt' ),
			'target' => 'call_for_price_options',
			'class'  => ('show_if_call_for_price'),
		);
		return $tabs;
	}
	add_action( 'woocommerce_product_data_panels', 'wcpt_call_for_price_options_product_tab_content' );
	function wcpt_call_for_price_options_product_tab_content() {
		// Dont forget to change the id in the div with your target of your product tab
		?><div id='call_for_price_options' class='panel woocommerce_options_panel'><?php
			?><div class='options_group'><?php
				
				// Number Field
				woocommerce_wp_text_input( 
					array( 
						'id'                => '_call_for_price_number_field', 
						'label'             => __( 'Mobile Number', 'woocommerce' ), 
						'placeholder'       => '', 
						'description'       => __( 'Enter the mobile number here.', 'woocommerce' ),
						'type'              => 'number', 
						'custom_attributes' => array(
								'step' 	=> 'any',
								'min'	=> '0'
							) 
					)
				);
				// Textarea
				woocommerce_wp_textarea_input( 
					array( 
						'id'          => '_call_for_price_textarea', 
						'label'       => __( 'My Textarea', 'woocommerce' ), 
						'placeholder' => '', 
						'description' => __( 'Enter the custom value here.', 'woocommerce' ) 
					)
				);


			?></div>
		</div><?php
	}
	add_action( 'woocommerce_process_product_meta', 'save_call_for_price_options_field' );
	function save_call_for_price_options_field( $post_id ) {

		if ( isset( $_POST['_call_for_price_textarea'] ) ) :
			update_post_meta( $post_id, '_call_for_price_textarea', sanitize_text_field( $_POST['_call_for_price_textarea'] ) );
		endif;

		if ( isset( $_POST['_call_for_price_number_field'] ) ) :
			update_post_meta( $post_id, '_call_for_price_number_field', sanitize_text_field( $_POST['_call_for_price_number_field'] ) );
		endif;
	}
	add_action( 'woocommerce_single_product_summary', 'call_for_price_template', 60 );
	function call_for_price_template () {
		global $product;
		if ( 'call_for_price' == $product->get_type() ) {
			$template_path = plugin_dir_path( __FILE__ ) . 'templates/';
			// Load the template
			wc_get_template( 'single-product/add-to-cart/call_for_price.php',
				'',
				'',
				trailingslashit( $template_path ) );
		}
	}
}
else{

	echo "Please Install Woocommerce Plugin";
}
