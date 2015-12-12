<div class="header">
	<h4 class="name">
		<?php esc_html_e( $this->name ); ?>
		<span class="title">{{ data.model.get( 'title' ) }}</span>
	</h4>
	<a href="#" class="clc-toggle-component-form"><?php esc_html_e( CLC_Content_Layout_Control::$i18n['control-toggle'] ); ?></a>
</div>
<div class="control">
	<div class="setting">
		<span class="customize-control-title"><?php echo $this->i18n['image']; ?></span>
		<# if ( !data.model.get( 'image' ) ) { #>
			<div class="placeholder">
				<?php echo $this->i18n['image_placeholder']; ?>
			</div>
		<# } else { #>
			<div class="thumb loading"></div>
			<div class="darken">
				<div class="description">
					<?php echo $this->i18n['image_transparency']; ?>
				</div>
				<input type="range" value="{{ data.model.get('image_transparency') }}" data-clc-setting-link="image_transparency" min="0" max="100" >
			</div>
		<# } #>
		<div class="buttons">
			<# if ( !data.model.get( 'image' ) ) { #>
				<button class="select-image button-secondary">
					<?php echo $this->i18n['image_select_button']; ?>
				</button>
			<# } else { #>
				<button class="select-image button-secondary">
					<?php echo $this->i18n['image_change_button']; ?>
				</button>
				<button class="remove-image button-secondary">
					<?php echo $this->i18n['image_remove_button']; ?>
				</button>
			<# } #>
		</div>
	</div>
	<label>
		<span class="customize-control-title"><?php echo $this->i18n['title_line_one']; ?></span>
		<input type="text" value="{{ data.model.get( 'title_line_one' ) }}" data-clc-setting-link="title_line_one">
	</label>
	<label>
		<span class="customize-control-title"><?php echo $this->i18n['title']; ?></span>
		<input type="text" value="{{ data.model.get( 'title' ) }}" data-clc-setting-link="title">
	</label>
	<div class="setting">
		<span class="customize-control-title"><?php echo $this->i18n['links']; ?></span>
		<# if ( data.model.get( 'links' ).length ) { #>
			<ul class="content-block-links">
				<# for ( var i in data.model.get( 'links' ) ) { #>
					<li>
						<a href="{{ data.model.get( 'links' )[i].url }}" class="link" target="_blank">
							{{ data.model.get( 'links' )[i].link_text }}
						</a>
						<a href="#" class="remove-link" data-index="{{ i }}">
							<?php echo $this->i18n['links_remove_button']; ?>
						</a>
					</li>
				<# } #>
			</ul>
		<# } #>
		<div class="buttons">
			<button class="add-link button-secondary">
				<?php echo $this->i18n['links_add_button']; ?>
			</button>
		</div>
	</div>
	<# if ( luigi_theme_customizer_control.business_profile_active ) { #>
		<div class="setting">
			<fieldset class="contact">
				<legend class="customize-control-title">
					<?php echo $this->i18n['contact']; ?>
				</legend>
				<label>
					<input type="radio" name="contact_{{data.model.get( 'id' ) }}" data-clc-setting-link="contact" value=""<# if ( data.model.get( 'contact' ) == '' ) { #> checked<# } #>>
					<?php echo $this->i18n['none']; ?>
				</label>
				<label>
					<input type="radio" name="contact_{{data.model.get( 'id' ) }}" data-clc-setting-link="contact" value="phone"<# if ( data.model.get( 'contact' ) == 'phone' ) { #> checked<# } #>>
					<?php echo $this->i18n['phone']; ?>
				</label>
				<div class="option">
					<label>
						<input type="radio" name="contact_{{data.model.get( 'id' ) }}" data-clc-setting-link="contact" value="find"<# if ( data.model.get( 'contact' ) == 'find' ) { #> checked<# } #>>
						<?php echo $this->i18n['find']; ?>
					</label>
					<# if ( data.model.get( 'contact' ) == 'find' ) { #>
						<input type="text" class="contact-text" data-clc-setting-link="contact_text" value="{{ data.model.get( 'contact_text' ) }}" placeholder="<?php echo $this->i18n['find_text_default']; ?>">
					<# } #>
				</div>
			</fieldset>
		</div>
	<# } #>
</div>
<div class="footer">
	<a href="#" class="delete"><?php esc_html_e( CLC_Content_Layout_Control::$i18n['delete'] ); ?></a>
</div>
