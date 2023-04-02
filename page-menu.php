<?php
/**
 * The template for displaying the Menu page
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
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header>
			
				<section class="menu-container">
					<section class="menu">
					<?php
					$terms = get_terms( 
						array(
							'taxonomy' => 'product_cat',
							'order'      => 'ASC',
							'parent' => 0,
						) 
					);
					if ( $terms && ! is_wp_error( $terms ) ) { ?>
						<div class="menu-tab-btn-container">
						<?php
						foreach ( $terms as $term ) { ?>
							<button class="menu-tab-btn" id="<?php echo esc_html($term->slug) ?>-tab-btn"><?php echo esc_html($term->name)?></button>
						<?php
						}
						?> 
						</div>
						<?php
							foreach ($terms as $term) { ?>
							<section id="<?php echo esc_html($term->slug)?>-section" class="menu-category-container">
							<h2><?php echo esc_html( $term->name ); ?></h2>
							<?php
							$args = array(
								'post_type'      => 'product',
								'posts_per_page' => -1,
								'order'          => 'ASC',
								'orderby'        => 'title',
								'tax_query'      => array (
									array (
										'taxonomy' => 'product_cat',
										'field'    => 'slug',
										'terms'    => $term->slug, 
									), 	array (
										'taxonomy' => 'cafe-product-type',
										'field'    => 'slug',
										'terms'    => 'type-menu', 
										'operator' => 'IN',
									), 
								),
							);

							$query = new WP_Query( $args );
							
							if ( $query -> have_posts() ){
								while ( $query -> have_posts() ) {
									$query -> the_post();
									?>
									<article class="menu-item">
									<h3 class="menu-item-name"><?php the_title(); ?></h3> 
									<div class="menu-item-description"><?php the_content(); ?></div> 
									<div class="menu-item-image-container" style="width: 150px;"><?php the_post_thumbnail(); ?></div> 
									</article>
									<?php
									}
								}
								wp_reset_postdata(); ?>
								</section>
						<?php
						}
						?>
						<?php
					}
					?>
					</section>
				</section>
	
        <?php
		endwhile; // End of the loop.
		?>
	</main><!-- #main -->

<?php
get_footer();
