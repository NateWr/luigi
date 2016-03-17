<div class="header">
	<h4 class="name">
		<?php echo esc_html( $this->name ); ?>
		<span class="title">
			{{ data.model.get( 'valid_options' )[data.model.get( 'left' )] }}
			<# if ( data.model.get( 'left' ) && data.model.get( 'right' ) ) { #>
				/
			<# } #>
			{{ data.model.get( 'valid_options' )[data.model.get( 'right' )] }}
		</span>
	</h4>
	<a href="#" class="clc-toggle-component-form"><?php echo esc_html( CLC_Content_Layout_Control::$i18n['control-toggle'] ); ?></a>
</div>
<div class="control">
	<div class="setting left_title">
		<label>
			<span class="customize-control-title"><?php echo $this->i18n['left_title']; ?></span>
			<input type="text" value="{{ data.model.get( 'left_title' ) }}" data-clc-setting-link="left_title">
		</label>
	</div>
	<div class="setting left">
		<label>
			<span class="customize-control-title"><?php echo $this->i18n['left']; ?></span>
			<select name="left" data-clc-setting-link="left">
				<option></option>
				<# for( var i in data.model.get( 'valid_options' ) ) { #>
					<option value="{{ i }}"<# if ( i === data.model.get( 'left' ) ) { #> selected<# } #>>
						{{ data.model.get( 'valid_options')[i] }}
					</option>
				<# } #>
			</select>
		</label>
	</div>
	<div class="setting right_title">
		<label>
			<span class="customize-control-title"><?php echo $this->i18n['right_title']; ?></span>
			<input type="text" value="{{ data.model.get( 'right_title' ) }}" data-clc-setting-link="right_title">
		</label>
	</div>
	<div class="setting right">
		<label>
			<span class="customize-control-title"><?php echo $this->i18n['right']; ?></span>
			<select name="right" data-clc-setting-link="right">
				<option></option>
				<# for( var i in data.model.get( 'valid_options' ) ) { #>
					<option value="{{ i }}"<# if ( i === data.model.get( 'right' ) ) { #> selected<# } #>>
						{{ data.model.get( 'valid_options')[i] }}
					</option>
				<# } #>
			</select>
		</label>
	</div>
</div>
<div class="footer">
	<a href="#" class="delete"><?php echo esc_html( CLC_Content_Layout_Control::$i18n['delete'] ); ?></a>
</div>
