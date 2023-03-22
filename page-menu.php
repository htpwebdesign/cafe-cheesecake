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
			
				<div class="menu-container">
				<?php
                $ids_to_exclude = array();
                $get_terms_to_exclude = get_terms(
                    array(
                        'fields' => 'ids',
                        'slug' => array (
                            'baked-cheesecakes', 'other-cakes', 'specialty-cheesecakes', 'coffee', 'specialty', 'tea'
                        ),
                        'taxonomy' => 'product_cat', 
                    )
                    );
                if( !is_wp_error( $get_terms_to_exclude ) && count($get_terms_to_exclude) > 0){
                    $ids_to_exclude = $get_terms_to_exclude; 
                }

				$terms = get_terms( 
					array(
						'taxonomy' => 'product_cat',
                        'order'      => 'ASC',
                        'exclude' => $ids_to_exclude,
                        'include_children' => false

					) 
				);
				if ( $terms && ! is_wp_error( $terms ) ) {
					foreach ( $terms as $term ) {
						?>
                        <div class="menu-category-container">
						<h2><?php echo esc_html( $term->name ); ?></h2>
						<?php
						$args = array(
							'post_type'      => 'product',
							'posts_per_page' => -1,
							'order'          => 'ASC',
							'orderby'        => 'title',
							// 'tax_query'      => array (
							// 	array (
							// 		'taxonomy' => 'cafe-product-type',
							// 		'field'    => 'slug',
							// 		'terms'    => 'type-menu',
                            //     ),
							// ),
                            'tax_query'      => array (
								array (
									'taxonomy' => 'product_cat',
									'field'    => 'slug',
									'terms'    => $term->slug, 
                                ), 	array (
									'taxonomy' => 'cafe-product-type',
									'field'    => 'slug',
									'terms'    => 'type-shop', 
                                    'operator' => 'NOT IN',
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
                                <p class="menu-item-description"><?php the_content(); ?></p> 
                                <div class="menu-item-image-container" style="width: 150px;"><?php the_post_thumbnail(); ?></div> 
                                </article>
                                <?php
                                
								}
							}
							wp_reset_postdata(); ?>
                            </div>
                    <?php
					}
					?>

					<?php
				}
				?>
				</div>
	
        <?php
		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
