<?php
/**
 * Footer Contact Info / Social Media
 *
 * @package Quantum_Property_Management
 *
 * @return void
 */

 /**
	* Contact Info
	*/
	if ( ! function_exists( 'quantum_contact_info' ) ) :
		/**
		* Output contact info from ACF
		*
		* @return void
		*/
		function quantum_contact_info() {
			?>
			<?php
			if ( function_exists( 'acf_add_options_page' ) ) {
				$name  = get_field( 'company_name', 'contact-information' );
				$add1  = get_field( 'address_1', 'contact-information' );
				$add2  = get_field( 'address_2', 'contact-information' );
				$city  = get_field( 'city', 'contact-information' );
				$state = get_field( 'state', 'contact-information' );
				$zip   = get_field( 'zip', 'contact-information' );
				$phone = get_field( 'phone', 'contact-information' );
				$fax   = get_field( 'fax', 'contact-information' );
				$email = get_field( 'email', 'contact-information' );
			}
			?>

			<div class="ftr-contact-info">
				<?php
				if ( $name || $add1 || $add2 || $city || $state || $zip || $phone || $fax || $email ) {
					if ( $name || $add1 || $add2 ) {
						?>
						<div class='address-section'>
							<span class='ftr-company-name'>
								<?php
								if ( $name ) :
									echo $name . '<br>';
								endif;
								?>
							</span>
							<span class="ftr-address">
								<?php
								if ( $add1 ) :
									echo esc_html( $add1 ) . '<br>';
								endif;
								if ( $add2 ) :
									echo esc_html( $add2 ) . '<br>';
								endif;
								?>
							</span>
							<?php
							if ( $city ) :
								?>
								<span class="ftr-city"><?php echo esc_html( $city ); ?></span>
								<?php
							endif;
							if ( $state ) :
								?>
							, <span class="ftr-state"><?php echo esc_html( $state ); ?></span>
								<?php
							endif;
							if ( $zip ) :
								?>
							<span class="ftr-zip"><?php echo ' ' . esc_html( $zip ); ?></span><?php endif; ?>
						</div>
						<?php
					}
					if ( $phone || $fax || $email ) {
						if ( $phone ) :
							?>
						<span class="ftr-phone">Phone: <a class="tel" href="tel:<?php echo esc_attr( $phone ); ?>"><?php echo esc_html( $phone ); ?></a></span>
							<?php
						endif;
						if ( $fax ) :
							?>
						<span class="ftr-fax">Fax: <a class="tel" href="tel:<?php echo esc_attr( $fax ); ?>"><?php echo esc_html( $fax ); ?></a></span>
							<?php
						endif;
						if ( $email ) :
							?>
						<span class="ftr-email"><a href="mailto:<?php echo esc_attr( $email ); ?>" class="ftr-email"><?php echo esc_html( $email ); ?></a></span>
							<?php
						endif;
					}
				}
				?>
			</div>
			<?php
		}
	endif;

	/**
	* Social Media Menu
	*/
	if ( ! function_exists( 'quantum_social_media_menu' ) ) :
		/**
		* Output social media from ACF
		*
		* @return void
		*/
		function quantum_social_media_menu() {
			if ( function_exists( 'acf_add_options_page' ) ) {
				$fb        = get_field( 'facebook_url', 'social-media-channels' );
				$tw        = get_field( 'twitter_url', 'social-media-channels' );
				$goo       = get_field( 'google_plus_url', 'social-media-channels' );
				$linked    = get_field( 'linkedin_url', 'social-media-channels' );
				$yt        = get_field( 'youtube_url', 'social-media-channels' );
				$pinterest = get_field( 'pinterest_url', 'social-media-channels' );
				$insta     = get_field( 'instagram_url', 'social-media-channels' );
				if ( $fb || $tw || $goo || $linked || $yt || $pinterest || $insta ) {
					?>
					<ul class="quantum-social-media">
						<?php
						if ( $fb ) :
							?>
							<li class="fb"><a href="<?php echo esc_url( $fb ); ?>" target="_blank" rel="noopener noreferrer">Find Us On Facebook</a></li>
							<?php
						endif;
						if ( $tw ) :
							?>
						<li class="tw"><a href="<?php echo esc_url( $tw ); ?>" target="_blank" rel="noopener noreferrer">Follow Us On Twitter</a></li>
							<?php
						endif;
						if ( $linked ) :
							?>
						<li class="linked"><a href="<?php echo esc_url( $linked ); ?>" target="_blank" rel="noopener noreferrer">Find Us On LinkedIn</a></li>
							<?php
						endif;
						if ( $goo ) :
							?>
						<li class="goo"><a href="<?php echo esc_url( $goo ); ?>" target="_blank" rel="noopener noreferrer">Find Us Google My Business</a></li>
							<?php
						endif;
						if ( $insta ) :
							?>
						<li class="insta"><a href="<?php echo esc_url( $insta ); ?>" target="_blank" rel="noopener noreferrer">Find Us On Instagram</a></li>
							<?php
						endif;
						if ( $yt ) :
							?>
						<li class="yt"><a href="<?php echo esc_url( $yt ); ?>" target="_blank" rel="noopener noreferrer">Watch Us On YouTube</a></li>
							<?php
						endif;
						if ( $pinterest ) :
							?>
						<li class="pin"><a href="<?php echo esc_url( $pinterest ); ?>" target="_blank" rel="noopener noreferrer">See Us On Pinterest</a></li><?php endif; ?>
					</ul>
					<?php
				}
			}
		}
	endif;