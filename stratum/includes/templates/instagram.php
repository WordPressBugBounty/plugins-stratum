<?php

extract( shortcode_atts( array(
	'items'		     => 6,
	'columns'		 => 3,
	'columns_mobile' => 3,
	'columns_tablet' => 3,
	'animate_on_scroll' => '',
	'animation_effects'   => '',
), $settings ) );

extract( shortcode_atts(
	array(
		'media' => array()
	),
	$extra_params
) );


$widget_name = 'stratum-instagram';

$class = $block_name = 'stratum-instagram';

$wrapper_class = 'stratum-instagram__wrapper masonry-grid' . ( $animate_on_scroll == 'yes' ? (' ' . $animation_effects . ' animate_on_scroll') : '' );

?>
<div class="<?php echo esc_attr( $class ); ?>">
	<div class="<?php echo esc_attr( $wrapper_class ); ?>">
	<?php
	$counter = 1;
	foreach ( $media as $value ) {
		if ( $counter <= $items ) {

			$alt = '';
			if ( isset( $value->caption ) ) {
				$alt = wp_trim_words( $value->caption );
			}
			?>
			<div class="<?php echo esc_attr( $widget_name ); ?>__item masonry-item">
				<div class="<?php echo esc_attr( $widget_name ); ?>__media-wrapper">
					<a class="<?php echo esc_attr( $widget_name ); ?>__media-link" target="_blank" href="<?php echo esc_url( $value->permalink ); ?>">
						<?php
						if ( $value->media_type == 'IMAGE' || $value->media_type == 'CAROUSEL_ALBUM' ){ ?>
							<img class="<?php echo esc_attr( $widget_name ); ?>__media" src="<?php echo esc_url( $value->media_url ); ?>" alt="<?php echo esc_attr( $alt ); ?>"/>
						<?php } elseif ($value->media_type == 'VIDEO'){ ?>
							<img class="<?php echo esc_attr( $widget_name ); ?>__media" src="<?php echo esc_url( $value->thumbnail_url ); ?>" alt="<?php echo esc_attr( $alt ); ?>"/>
						<?php } ?>
					</a>
				</div>
			</div>
		<?php }
		$counter ++;
	} ?>
	</div>
</div>
