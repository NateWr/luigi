<?php
/**
 * Layout template for the mixer component
 *
 * @param $this->left string Left panel selection
 * @param $this->right string Right panel selection
 * @since 0.1
 */
?>

<div class="clc-wrapper">
	<?php if ( !empty( $this->left ) ) : ?>
		<div class="luigi-clc-mixer">
			<?php if ( !empty( $this->left_title ) ) : ?>
				<h2><?php echo luigi_wrap_first_word( $this->left_title ); ?></h2>
			<?php endif; ?>
			<?php luigi_print_mixer_content( $this->left ); ?>
		</div>
	<?php endif; ?>
	<?php if ( !empty( $this->right ) ) : ?>
		<div class="luigi-clc-mixer">
			<?php if ( !empty( $this->right_title ) ) : ?>
				<h2><?php echo luigi_wrap_first_word( $this->right_title ); ?></h2>
			<?php endif; ?>
			<?php luigi_print_mixer_content( $this->right ); ?>
		</div>
	<?php endif; ?>
</div>
<?php
