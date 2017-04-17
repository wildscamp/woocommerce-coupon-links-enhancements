<?php
/**
 * WooCommerce Coupon Links Enhancements
 *
 * @package   WooCommerceCouponLinksEnhancements
 * @author    Joel Rowley
 * @link      https://www.wilds.org/
 * @copyright Copyright (c) 2017 The Wilds
 * @license   GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Coupon Links Enhancements
 * Plugin URI:        https://github.com/wildscamp/woocommerce-coupon-links-enhancements
 * Description:       Augments the https://github.com/cedaro/woocommerce-coupon-links plugin with additional features and enhancements.
 * Version:           1.0.0
 * Author:            The Wilds
 * Author URI:        https://www.wilds.org/
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * GitHub Plugin URI: wildscamp/woocommerce-coupon-links-enhancements
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A test function that determines if the cedaro/woocommerce-coupon-links plugin is installed
 * and activated.
 *
 * @return bool true if it is installed and activated; false if it is not.
 * @since 1.0.0
 */
function check_for_dependent_plugin() {
	return is_plugin_active( 'woocommerce-coupon-links/woocommerce-coupon-links.php' );
}

/**
 * Display the URL on the coupon page.
 *
 * @since 1.0.0
 */
function wilds_show_coupon_url() {
	if ( ! check_for_dependent_plugin() ) {
		return;
	}

	// Get the coupon code query variable.
	$query_var = apply_filters( 'woocommerce_coupon_links_query_var', 'coupon_code' );

	?>
	<p class="form-field coupon_url_field">
		<span id="coupon-url-label"><?php esc_html_e( 'Coupon URL', 'cedaro-coupon-links' ); ?></span>
		<span id="coupon-url"
		      data-template="<?php echo esc_attr( get_home_url() . "?$query_var={coupon}" ); ?>"><?php echo esc_html( get_home_url() . "?$query_var=" . get_the_title() ); ?></span>
		<span class="woocommerce-help-tip"
		      data-tip="<?php esc_attr_e( 'This field displays the URL that can be used to directly add this coupon. The URL will work in conjunction with other query string parameters. An example of this would be adding a product to the cart while at the same time applying the coupon.', 'cedaro-coupon-links' ); ?>"></span>
	</p>
	<?php
}

/**
 * Enqueue style and JavaScript needed for proper display of the URL on
 * the coupon page and also to make it easier to copy the URL.
 *
 * @since 1.0.0
 */
function wilds_enqueue_coupon_url_styles() {
	if ( ! check_for_dependent_plugin() ) {
		return;
	}

	$screen = get_current_screen();

	if ( ! empty( $screen ) && 'shop_coupon' === $screen->id ) {
		wp_enqueue_script( 'woocommerce-coupon-links-enhancements', plugin_dir_url( __FILE__ ) . 'woocommerce-coupon-links-enhancements-admin.js', array( 'jquery' ), '1.0.0', false );
		wp_enqueue_style( 'woocommerce-coupon-links-enhancements', plugin_dir_url( __FILE__ ) . 'woocommerce-coupon-links-enhancements-admin.css', array(), '1.0.0', 'all' );
	}
}

add_action( 'woocommerce_coupon_options', 'wilds_show_coupon_url', 20 );
add_action( 'admin_enqueue_scripts', 'wilds_enqueue_coupon_url_styles' );
