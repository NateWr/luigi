<div class="header">
	<h4 class="name">
		<?php esc_html_e( $this->name ); ?>
		<span class="title">{{ data.model.get( 'post_id' ) }}</span>
	</h4>
	<a href="#" class="clc-toggle-component-form"><?php esc_html_e( CLC_Content_Layout_Control::$i18n['control-toggle'] ); ?></a>
</div>
<div class="control">
	<div class="setting">
		<span class="customize-control-title"><?php echo $this->i18n['post_label']; ?></span>
		<# if ( data.model.get( 'post_id' ) ) { #>
			<div class="post loading"></div>
		<# } else { #>
			<div class="placeholder">
				<?php echo $this->i18n['post_placeholder']; ?>
			</div>
		<# } #>
		<div class="buttons">
			<# if ( !data.model.get( 'post_id' ) ) { #>
				<button class="add-post button-secondary">
					<?php echo $this->i18n['add_post_button']; ?>
				</button>
			<# } else { #>
				<button class="add-post button-secondary">
					<?php echo $this->i18n['change_post_button']; ?>
				</button>
				<button class="remove-post button-secondary">
					<?php echo $this->i18n['remove_post_button']; ?>
				</button>
			<# } #>
		</div>
	</div>
</div>
<div class="footer">
	<a href="#" class="delete"><?php esc_html_e( CLC_Content_Layout_Control::$i18n['delete'] ); ?></a>
</div>
