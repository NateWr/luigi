<?php
/**
 * Layout template for the luigi-post component
 *
 * @param $this->post_id int Post ID
 * @since 0.1
 */
?>

<div class="clc-wrapper">
	<?php print_r( get_post( $this->post_id ) ); ?>
</div>
<?php
