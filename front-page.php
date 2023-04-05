<?php
/**
 * The template for displaying the Home page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cafe_Cheesecake
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			?>
			<section class="home-blog">
				<?php
				if ( function_exists ( 'get_field' ) ) {
					
					// Repeater ACF Field
					if( have_rows('carousel') ): ?>
						<ul class='home-carousel'>
						  <?php while( have_rows('carousel') ): the_row(); ?>
							<li>
							  <?php 
									echo wp_get_attachment_image( get_sub_field( 'banner_image' ), 'banner-crop')?>
							  <?php echo "<h2>" . get_sub_field('banner_heading') . "</h2>"; ?>
							  <?php echo '<p>' . get_sub_field('banner_description') . '</p>'; ?>
							</li>
						  <?php endwhile; ?>
						</ul>
					  <?php endif; ?>
					  <?php

					if ( get_field( 'arrow_icon' ) ) {
						echo wp_get_attachment_image( get_field( 'arrow_icon' ), 'medium', '',
						array(''));
					}
					?>

					<section class="cheesecakes-container">
						<section class="cheesecakes">
							<?php
							if ( get_field( 'our_cheesecakes_heading' ) ) {
								echo '<h3>' . get_field( 'our_cheesecakes_heading' ) . '</h3>';
							}

							if ( get_field( 'our_cheesecakes_description' ) ) {
								echo '<p>' . get_field( 'our_cheesecakes_description' ) . '</p>';
							}

							$url = get_field( 'our_cheesecakes_read_more' );
								if ( get_field( 'our_cheesecakes_read_more' ) ) {
									echo '<a href="' . $url . '" class="button">Read More</a>';
								}
							
								?>
						</section>
					</section>

					<section class="favourites-container">
						<section class="favourites">
							<?php
							if ( get_field( 'favourites_heading' ) ) {
								echo '<h3>' . get_field( 'favourites_heading' ) . '</h3>';
							}

							// Relationship ACF Field

							$relationship = get_field( 'favourites' );

							if ( $relationship ) : ?>
							<ul>
								<?php foreach($relationship as $relation): ?>
									<li>
										<a href="<?php echo get_permalink( $relation->ID ); ?>">
										<?php echo "<img src='" . get_the_post_thumbnail_url( $relation->ID ) . "'>" ?></a>
										<?php echo "<h3>" . get_the_title( $relation->ID ) . "</h3>" ?>
										<?php echo "<p>" . get_the_excerpt( $relation->ID ) . "</p>" ?>

								</li>
								<?php endforeach; ?>
								</ul>
								<?php endif; 

							// See Menu Button
							$urlfave = get_field( 'favourites_button' );
							if ( get_field( 'favourites_button' ) ) {
								echo '<a href="' . $urlfave . '" class="button">See Menu</a>';
							}
							?>
					</section>
				</section>

				<section class="drinks-container">
					<section class="drinks">
							<?php

							if ( get_field( 'drinks_title' ) ) {
								echo '<h3>' . get_field( 'drinks_title' ) . '</h3>';
							}

							?>

								
							<?php
							
							$parent_category_slug = 'drinks';
							$parent_category_id = get_term_by('slug', $parent_category_slug, 'product_cat')->term_id;
							$child_categories = get_term_children($parent_category_id, 'product_cat');

							echo '<div class="single-drinks-container">';

							foreach ($child_categories as $child_category) {
								$term = get_term_by('id', $child_category, 'product_cat');
								$thumbnail_id = get_term_meta($child_category, 'thumbnail_id', true);

								echo '<div class="single-drinks">';
								echo '<a href="' . get_term_link($term) . '">' . wp_get_attachment_image($thumbnail_id, 'thumbnail') . '</a>';
								echo '<a href="' . get_term_link($term) . '">' . $term->name . '</a>';
								echo '</div>';
							}
							echo '</div>';

							// See Menu Button
							$urldrinks = get_field( 'drinks_button' );
							if ( get_field( 'drinks_button' ) ) {
								echo '<a href="' . $urldrinks . '" class="button">See Menu</a>';
							}

							?>
							</div>
					</section>
				</section>

				<section class="merch-container">
					<section class="merch">

							<?php

							if ( get_field( 'merch_heading' ) ) {
								echo '<h3>' . get_field( 'merch_heading' ) . '</h3>';
							}

							// Display Merch Posts
							$argsMerch = array(
								'post_type' 		=> 'product',
								'posts_per_page'	=> 5,
								'oderby' 			=> 'term_id',
								'tax_query' 		=> array(
									array(
										'taxonomy' 			=> 'product_cat',
										'field' 			=> 'slug',
										'terms' 			=> 'merch',
										'include_children' 	=> false,
									)
									),
							);
							
							$queryMerch = new WP_Query( $argsMerch );
							
							echo '<div class="single-merch-container">';

							if ( $queryMerch->have_posts() ){
								while ( $queryMerch->have_posts() ) {
									$queryMerch->the_post(); 
									global $product;
									?>

									<div class="single-merch">
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail(); ?>
											<h3><?php the_title(); ?></h3>
										</a>
										<?php echo $product->get_price_html(); ?>

									</div>
									<?php			
								}
								wp_reset_postdata();
							}
									
							echo '</div>';

							$urlmerch = get_field( 'merch_section_button' );
							if ( get_field( 'merch_section_button' ) ) {
								echo '<a href="' . $urlmerch . '" class="button">Our Shop</a>';
							}

						}
						?>
					</section>
				</section>
			</section>
		<?php
		endwhile; // End of the loop.
		?>
	</main><!-- #main -->

<?php
get_footer();
