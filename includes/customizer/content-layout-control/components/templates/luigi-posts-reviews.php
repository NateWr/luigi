<?php
/**
 * Layout template for the reviews component
 *
 * @param $this->posts array List of posts
 * @since 0.1
 */
?>

<div class="clc-wrapper">
	<?php foreach( $this->items as $post ) : ?>
		<?php if ( empty( $post['ID'] ) ) { continue; } ?>
		[good-reviews review=<?php echo absint( $post['ID'] ); ?>]
	<?php endforeach; ?>
</div>
<?php
