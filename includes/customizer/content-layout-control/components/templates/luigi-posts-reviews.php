<?php
/**
 * Layout template for the reviews component
 *
 * @param $this->posts array List of posts
 * @since 0.1
 */
?>

<div class="clc-wrapper">
	<?php foreach( $this->posts as $post_id ) : ?>
        [good-reviews review=<?php echo absint( $post_id ); ?>]
	<?php endforeach; ?>
</div>
<?php
