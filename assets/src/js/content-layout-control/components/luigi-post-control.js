( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	if ( !clc ) {
		return;
	}

	/**
	 * Model class for the Luigi Post component
	 *
	 * @augments Backbone.Model
	 * @since 0.1
	 */
	clc.Models.components['luigi-post'] = clc.Models.Component.extend({
		defaults: {
			name:           '',
			description:    '',
			type:           'luigi-post',
			post_id:        0,
			order:          0
		}
	});

	/**
	* View class for the Luigi Post form
	*
	* @augments wp.customize.ContentLayoutControl.Views.BaseComponentForm
	* @augments wp.Backbone.View
	* @since 0.1
	*/
	clc.Views.component_controls['luigi-post'] = clc.Views.BaseComponentForm.extend({
		template: wp.template( 'clc-component-luigi-post' ),

		className: 'clc-component-luigi-post',

		events: _.extend({}, clc.Views.BaseComponentForm.prototype.events, {
			'click .add-post': 'toggleSearchPanel'
		}),

		/**
		 * Open or close the post search panel
		 *
		 * @since 0.1
		 */
		toggleSearchPanel: function( event ) {
			event.preventDefault();

			if ( !this.$el.hasClass( 'clc-control-search-open' ) ) {
				this.control.closeComponentPanel();
				this.openLinkPanel();
			} else {
				this.closeLinkPanel();
			}

		},

		/**
		 * Open the link panel
		 *
		 * @since 0.1
		 */
		openLinkPanel: function() {
			this.search_panel = new clc.Views.SearchPanel({
				collection: new Backbone.Collection(),
				component: this
			});
			this.search_panel.render();
			// Append directly so that we can call .remove() on the view
			// without losing the .clc-secondary-content div element
			this.search_panel.$el.appendTo( '#clc-secondary-panel .clc-secondary-content' );
			$( 'body' ).addClass( 'clc-secondary-open' );
			this.$el.addClass( 'clc-control-search-open' );
		},

		/**
		 * Close the link panel
		 *
		 * @since 0.1
		 */
		closeLinkPanel: function() {
			$( 'body' ).removeClass( 'clc-secondary-open' );
			this.$el.removeClass( 'clc-control-search-open' );
			if ( this.search_panel ) {
				this.search_panel.remove();
			}
		},

	});

	/**
	* Panel for searching for and selecting posts
	*
	* @augments wp.Backbone.View
	* @since 0.1
	*/
	clc.Views.SearchPanel = wp.Backbone.View.extend({
		template: wp.template( 'clc-component-luigi-post-post-selection' ),

		events: {
			'keyup .clc-post-search': 'keyupSearch',
		},

		initialize: function( options ) {
			// Store reference to component
			_.extend( this, _.pick( options, 'component' ) );
			this.state = 'waiting';
		},

		render: function() {
			$( '#clc-secondary-panel .clc-secondary-content' ).empty();

			wp.Backbone.View.prototype.render.apply( this );

			this.updateState();

			this.renderCollection();

			this.search_field = this.$el.find( '.clc-post-search' );
		},

		/**
		 * Render collection of links
		 *
		 * @since 0.1
		 */
		renderCollection: function() {
			var list = this.$el.find( '.clc-post-selection-list' );
			list.empty();
			this.collection.each( function( model ) {
				list.append( new clc.Views.PostSummary( { model: model, component: this.component } ).render().el );
			}, this );
		},

		/**
		 * Respond to typiing in the search field
		 *
		 * @since 0.1
		 */
		keyupSearch: function( event ) {
			event.preventDefault();

			var search = this.search_field.val();
			if ( search.length < 3 ) {
				this.resetSearch();
				return;
			}

			if ( this.search == search ) {
				return;
			}

			this.fetchLinks( search );
		},

		/**
		 * Reset the currently searched string
		 *
		 * @since 0.1
		 */
		resetSearch: function() {
			this.search = '';
			this.updateState( 'waiting' );
		},

		/**
		 * Fetch a list of links
		 *
		 * @since 0.1
		 */
		fetchLinks: function( search ) {
			this.search = search.replace( /\s+/g, '+' );
			this.updateState( 'fetching' );

			$.ajax({
				url: CLC_Control_Settings.root + '/content-layout-control/v1/components/luigi-post/post/' + this.search,
				type: 'GET',
				beforeSend: function( xhr ) {
					xhr.setRequestHeader( 'X-WP-Nonce', CLC_Control_Settings.nonce );
				},
				complete: _.bind( this.handleResponse, this )
			});
		},

		/**
		 * Handle response from search query
		 *
		 * @since 0.1
		 */
		handleResponse: function( response ) {
			if ( typeof response === 'undefined' || response.status !== 200 ) {
				return;
			}

			var data = response.responseJSON;
			if ( typeof data.search === 'undefined' || data.search != this.search ) {
				return;
			}

			this.updateState( 'waiting' );
			this.collection.reset( data.links );
			this.renderCollection();
		},

		/**
		 * Update view state
		 *
		 * @since 0.1
		 */
		updateState: function( state ) {
			if ( state ) {
				this.state = state;
			}

			this.$el.removeClass( 'waiting fetching' );
			this.$el.addClass( this.state );
		},

		/**
		 * Check if details about the link are sufficient
		 *
		 * @since 0.1
		 */
		isLinkValid: function() {
			return this.url.val() && this.link_text.val();
		},
	});

	/**
	* Link selection view
	*
	* @augments wp.Backbone.View
	* @since 0.1
	*/
	clc.Views.PostSummary = wp.Backbone.View.extend({
		tagName: 'li',

		template: wp.template( 'clc-component-luigi-post-post-summary' ),

		events: {
			'click': 'select',
		},

		initialize: function( options ) {
			// Store reference to link panel
			_.extend( this, _.pick( options, 'component' ) );
		},

		/**
		 * Select this link
		 *
		 * @since 0.1
		 */
		select: function() {
			this.component.trigger( 'post-add-post.clc', this.model );
		}
	});

} )( jQuery );
