var Luigi_Selector_Cache;
( function( $ ) {
	/**
	 * Selector cache to reduce DOM lookups
	 *
	 * @since 0.0.1
	 */
	Luigi_Selector_Cache = {

		// Cache
		objs: {},

		/**
		 * Fetch an object
		 *
		 * @param string id Object cache id
		 * @param string selector jQuery selector for DOM lookup
		 * @since 0.0.1
		*/
		get: function( id, selector ) {

			if ( typeof this.objs[id] == 'undefined' ) {
				this.objs[id] = $( selector );
			}

			return this.objs[id];
		},

		/**
		 * Clear one or all cached selections
		 *
		 * @param string id Object cache id
		 * @since 0.0.1
		 */
		clear: function( id ) {
			if ( typeof id === 'undefined' ) {
				this.objs = {};
			} else if ( typeof this.objs[ id ] !== 'undefined' ) {
				delete this.objs[id];
			}
		}
	};
} )( jQuery );
