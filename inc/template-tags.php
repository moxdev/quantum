<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Quantum_Property_Management
 */

if ( ! function_exists( 'quantum_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function quantum_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'quantum' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'quantum_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function quantum_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'quantum' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'quantum_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function quantum_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'quantum' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'quantum' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'quantum' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'quantum' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'quantum' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'quantum' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'quantum_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function quantum_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;

/**
 * Page Titles
 */
if ( ! function_exists( 'quantum_page_titles' ) ) :
	/**
	 * Output custom page titles for SEO
	 */
	function quantum_page_titles() {
		if ( function_exists( 'get_field' ) ) {
			$on_page_title = get_field( 'on_page_title' );
			if ( $on_page_title ) {
				?>
				<header class="entry-header">
					<h1 class="entry-title">
						<?php
						echo wp_kses(
							$on_page_title,
							array(
								'span'   => array(),
								'em'     => array(),
								'strong' => array(),
								'br' => array(),
							)
						);
						?>
					</h1>
				</header><!-- .entry-header -->
			<?php } else { ?>
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header><!-- .entry-header -->
				<?php
			}
		} else {
			?>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header><!-- .entry-header -->
			<?php
		}
	}
endif;

/**
 * Page Feature Image
 */
if ( ! function_exists( 'quantum_page_feature' ) ) :
	/**
	 * Output feature image for pages and main blog page
	 */
	function quantum_page_feature() {
		/**
		 * Enqueue objectfit library and output js in footer
		 */
		function enqueue_feature_scripts() {
			wp_enqueue_script( 'quantum-object-fit-library', get_template_directory_uri() . '/js/vendor/ofi.min.js', array(), '20181127', true );
			add_action( 'wp_footer', 'quantum_object_fit_js', 100 );
		}

		if ( has_post_thumbnail() && ! is_home() ) {
			?>
			<figure class="page-feature">
				<?php the_post_thumbnail(); ?>
				<?php
				global $post;
				$ancestors = get_post_ancestors( $post->ID );
				if ( count( $ancestors ) === 0 ) {
					?>
					<div class="wrapper">
						<span class="parent-name"><?php the_title(); ?></span><br>
					</div>
					<?php
				} else {
					$parent = array_pop( $ancestors );
					?>
					<div class="wrapper">
						<span class="parent-name"><?php echo get_the_title( $parent ); ?></span><br>
						<?php foreach ( $ancestors as $ancestor ) { ?>
							<span class="page-name"><?php echo get_the_title( $ancestor ); ?> &mdash;</span>
						<?php } ?>
						<span class="page-name"><?php the_title(); ?></span>
					</div>
				<?php } ?>
			</figure>
			<?php
			enqueue_feature_scripts();
		} elseif ( is_home() ) {
			$blog_id = get_option( 'page_for_posts' );
			if ( has_post_thumbnail( $blog_id ) ) {
				?>
				<figure class="page-feature">
					<?php echo get_the_post_thumbnail( $blog_id ); ?>
					<div class="wrapper">
						<span class="parent-name"><?php echo get_the_title( $blog_id ); ?></span>
					</div>
				</figure>

				<?php
				enqueue_feature_scripts();
			}
		}
	}
endif;