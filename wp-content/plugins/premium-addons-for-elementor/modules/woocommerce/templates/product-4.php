<?php
/**
 * PA WooCommerce Products - Template.
 *
 * @package PA
 */

use PremiumAddons\Includes\Premium_Template_Tags;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // If this file is called directly, abort.
}

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

?>

<?php

$product_id = $product->get_id();
$class      = array();
$classes    = array();
$classes[]  = 'post-' . $product_id;
$wc_classes = implode( ' ', wc_product_post_class( $classes, $class, $product_id ) );

$cta_position = $this->get_option_value( 'cta_position' );

$sale_ribbon     = self::$settings['sale'];
$featured_ribbon = self::$settings['featured'];
$quick_view      = $this->get_option_value( 'quick_view' );
$out_of_stock    = 'outofstock' === get_post_meta( $product_id, '_stock_status', true ) && 'yes' === self::$settings['sold_out'];
$image_size      = $settings['featured_image_size'];
?>
<li class=" <?php echo esc_attr( $wc_classes ); ?>">
	<div class="premium-woo-product-wrapper">
		<?php

		echo '<div class="premium-woo-product-thumbnail">';
		echo '<div class="premium-woo-product-overlay"></div>';

		if ( $out_of_stock ) {
			echo '<span class="pa-out-of-stock">' . esc_html( self::$settings['sold_out_string'] ) . '</span>';
		} else {
			if ( 'yes' === $sale_ribbon || 'yes' === $featured_ribbon ) {

				echo '<div class="premium-woo-ribbon-container">';

				if ( 'yes' === $sale_ribbon ) {
					include PREMIUM_ADDONS_PATH . 'modules/woocommerce/templates/loop/sale-ribbon.php';
				}

				if ( 'yes' === $featured_ribbon ) {
					include PREMIUM_ADDONS_PATH . 'modules/woocommerce/templates/loop/featured-ribbon.php';
				}

				echo '</div>';
			}
		}

		woocommerce_template_loop_product_link_open();

		if ( 'yes' === $this->get_option_value( 'product_image' ) ) {
			$product_thumb = has_post_thumbnail( $product_id ) ? get_the_post_thumbnail_url( $product_id, $image_size ) : wc_placeholder_img_src( $image_size );
			echo '<img src="' . esc_url( $product_thumb ) . '">';
		}

		if ( 'swap' === $settings['hover_style'] ) {
			Premium_Template_Tags::get_current_product_swap_image( $image_size );
		}

		woocommerce_template_loop_product_link_close();

		if ( 'yes' === $quick_view ) {
			$qv_type = $this->get_option_value( 'quick_view_type' );
			if ( 'button' === $qv_type ) {
				echo '<div class="premium-woo-qv-btn premium-woo-qv-btn-translate" data-product-id="' . esc_attr( $product_id ) . '">';
					echo '<span class="premium-woo-qv-text">' . esc_html( __( 'Quick View', 'premium-addons-for-elementor' ) ) . '</span>';
					echo '<i class="premium-woo-qv-icon fa fa-eye"></i>';
				echo '</div>';

			} elseif ( 'image' === $qv_type && 'yes' === $this->get_option_value( 'product_image' ) ) {
				echo '<div class="premium-woo-qv-data" data-product-id="' . esc_attr( $product_id ) . '"></div>';
			}
		}

		if ( 'above' === $cta_position ) {
			echo '<div class="premium-woo-product-actions-wrapper">';
			$cart_class = $product->is_purchasable() && $product->is_in_stock() ? 'premium-woo-product-cta-btn' : '';

				echo '<a href=' . esc_url( $product->add_to_cart_url() ) . ' class="premium-woo-cart-btn ' . esc_attr( $cart_class ) . ' product_type_' . esc_attr( $product->get_type() ) . '" data-product_id="' . esc_attr( $product_id ) . '">';
					echo '<span class="premium-woo-add-cart-icon fas fa-shopping-bag"></span>';
				echo '</a>';
			echo '</div>';
		}

		$product_structure = $this->get_option_value( 'product_structure' );

		if ( count( $product_structure ) ) {

			do_action( 'pa_woo_product_before_details_wrap_start', $product_id, $settings );
			echo '<div class="premium-woo-products-details-wrap">';
			do_action( 'pa_woo_product_after_details_wrap_start', $product_id, $settings );

			foreach ( $product_structure as $index => $segment ) {
				$value = $segment['product_segment'];
				switch ( $value ) {
					case 'title':
						do_action( 'pa_woo_product_before_title', $product_id, $settings );
						echo '<a href="' . esc_url( apply_filters( 'premium_woo_product_title_link', get_the_permalink() ) ) . '" class="premium-woo-product__link">';
							woocommerce_template_loop_product_title();
						echo '</a>';
						do_action( 'pa_woo_product_after_title', $product_id, $settings );
						break;

					case 'price':
						do_action( 'pa_woo_product_before_price', $product_id, $settings );
						woocommerce_template_loop_price();
						do_action( 'pa_woo_product_after_price', $product_id, $settings );
						break;

					case 'ratings':
						do_action( 'pa_woo_product_before_rating', $product_id, $settings );
						woocommerce_template_loop_rating();
						do_action( 'pa_woo_product_after_rating', $product_id, $settings );
						break;

					case 'desc':
						do_action( 'pa_woo_product_before_desc', $product_id, $settings );
						Premium_Template_Tags::get_product_excerpt();
						do_action( 'pa_woo_product_after_desc', $product_id, $settings );
						break;

					case 'cta':
						if ( 'below' === $cta_position ) {
							do_action( 'pa_woo_product_before_cta', $product_id, $settings );
							echo '<div class="premium-woo-atc-button">';
								woocommerce_template_loop_add_to_cart();
							echo '</div>';
							do_action( 'pa_woo_product_after_cta', $product_id, $settings );
						}

						break;

					case 'category':
						do_action( 'pa_woo_product_before_cat', $product_id, $settings );
						Premium_Template_Tags::get_current_product_category();
						do_action( 'pa_woo_product_after_cat', $product_id, $settings );
						break;

					default:
						break;
				}
			}

			do_action( 'pa_woo_product_before_details_wrap_end', $product_id, $settings );
			echo '</div>';
			do_action( 'pa_woo_product_after_details_wrap_end', $product_id, $settings );
		}

		echo '</div>';

		?>
	</div>
</li>