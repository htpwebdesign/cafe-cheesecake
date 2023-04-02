<?php
/**
 * The template for displaying Locations archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cafe_Cheesecake
 */

get_header();
?>

	<main id="primary" class="site-main">
		<section class="outer-container">
			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
				$args = array(
					'post_type' => 'cafe-location',
					'post_per_page' => -1,
				);

				$query = new WP_Query($args);
				if($query -> have_posts()){
					echo '<section class="location-container">';
					while($query -> have_posts()){
						$query -> the_post();
	
						if ( function_exists( 'get_field' ) ) {
							?>
							<h2><?php echo the_field('location_name'); ?></h2>
							<p><?php echo the_field('location_information'); ?></p>	
							
							<?php
							echo wp_get_attachment_image( get_field( 'location_image' ), 'medium', '',
								array(''));
						}
					}
					wp_reset_postdata();
					echo '</section>';
				}
				if( have_rows('all_location_map') ): ?>
					<div class="acf-map" data-zoom="16">
						<?php while ( have_rows('all_location_map') ) : the_row(); 
				
							// Load sub field values.
							$location = get_sub_field('location');
							$title = get_sub_field('title');
							$description = get_sub_field('description');
							?>
							<div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>">
								<h3><?php echo esc_html( $title ); ?></h3>
								<p><em><?php echo esc_html( $location['address'] ); ?></em></p>
								<p><?php echo esc_html( $description ); ?></p>
							</div>
					<?php endwhile; ?>
					</div>
				<?php endif; 
			?>
		</section>
	</main><!-- #main -->

<?php
get_footer();