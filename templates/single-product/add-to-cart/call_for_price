<?php
/**
 * Simple custom product
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $product;
do_action( 'call_for_price_before_add_to_cart_form' );  ?>

<form class="call_for_price_cart" method="post" enctype='multipart/form-data'>
	<table cellspacing="0">
		<tbody>
			<tr>
				<td >
					<label for="call_for_price_amount"><?php echo __( "Mobile Number", 'wcpt' ); ?></label>
				</td>
				<td class="number">
					<?php $number = get_post_meta ( $product->get_id(), '_call_for_price_number_field' );
					$number = implode(" ",$number);					
					echo $number;
					 ?>0
				</td>
			</tr>
		</tbody>
	</table>
	<button type="submit" name="add-to-cart" value="<?php //echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt"><?php echo esc_html( "Call For Price" ); ?></button>
</form>

<?php do_action( 'call_for_price_after_add_to_cart_form' ); ?>
