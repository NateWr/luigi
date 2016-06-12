<?php
/**
 * Layout template for the luigi-hero-block component
 *
 * @param $this->title_line_one string Top title text string
 * @param $this->title string Bottom title text string
 * @param $this->links array List of links [ url: 'http://...', link_text: 'Click Here']
 * @param $this->image int Image attachment ID
 * @param $this->image_transparency int Image transparancy, 0-100 (0 = opacity: 1)
 * @param $this->contact string What kind of contact detail to display: phone|find (or empty string)
 * @param $this->contact_text string Text string used in combination with the `find` contact type
 * @since 0.1
 */
global $bpfwp_controller;
if ( $this->image ) {
	$background_style = "background-image: url('" . luigi_get_attachment_img_src_url( $this->image, 'full' ) . "');";
	if ( $this->image_transparency ) {
		$background_style .= "opacity: " . $this->get_image_opacity() . ";";
	}
}
?>

<div class="clc-wrapper">
	<?php if ( $this->image ) : ?>
		<div class="background" style="<?php echo $background_style; ?>"></div>
	<?php endif; ?>
	<div class="text">
		<h2><span class="title_line_one"><?php echo $this->title_line_one; ?></span><span class="title"><?php echo luigi_wrap_first_word( $this->title ); ?></span></h2>
		<?php if ( !empty( $this->links ) ) : ?>
			<ul class="links">
				<?php foreach( $this->links as $link ) : ?>
					<li>
						<a href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['link_text'] ); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<?php if ( luigi_print_hero_contact( $this->contact ) ) : ?>
			<div class="contact">
				<?php if ( $this->contact == 'phone' ) : ?>
					<div class="phone">
						<span class="luigi-icon luigi-icon-w-phone"></span> <?php echo esc_html( $bpfwp_controller->settings->get_setting( 'phone' ) ); ?>
					</div>
				<?php elseif ( $this->contact == 'find' ) : ?>
					<?php if ( post_type_exists( 'location' ) ) : ?>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'location' ) ); ?>">
							<span class="luigi-icon luigi-icon-w-location"></span> <span class="contact_text"><?php echo esc_html( $this->contact_text ); ?></span>
						</a>
					<?php else : ?>
						<a href="#" class="luigi-load-contact-card"><span class="luigi-icon luigi-icon-w-location"></span> <span class="contact_text"><?php echo esc_html( $this->contact_text ); ?></span></a>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php
