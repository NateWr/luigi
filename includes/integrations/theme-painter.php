<?php
/**
 * Functions used to integrate with the theme-painter library
 *
 * @package    luigi
 */
if ( !function_exists( 'luigi_get_theme_painter_args' ) ) {
	function luigi_get_theme_painter_args() {

		$args = array(

			// URL path to the theme-painter library
			'lib_url' => get_template_directory_uri() . '/lib/theme-painter',

			// The handle of the stylesheet to add inline styles to
			'stylesheet' => 'luigi',

			// Panels
			'panels' => array(

				'theme-colors' => array(
					'title' => __( 'Theme Colors', 'luigi' ),
					'priority' => 30,

					'sections' => array(

						'general' => array(
							'title' => __( 'General Colors', 'luigi' ),
							'priority' => 20,
							'colors' => array(
								'background' => array(
									'label' => __( 'Background Color', 'luigi' ),
									'selectors' => luigi_tp( 'background' ),
									'attributes' => 'background',
									'default' => '#fafafa',
								),
								'background-highlight' => array(
									'label' => __( 'Background Highlight Color', 'luigi' ),
									'description' => __( 'A background color used to bring attention to a section or a panel on your site. Often a slightly lighter shade of the Background Color.', 'luigi' ),
									'selectors' => array( luigi_tp( 'background-highlight' ), luigi_tp( 'background-highlight-important' ) ),
									'attributes' => array( 'background', 'background' ),
									'important' => array( false, true ),
									'default' => '#ffffff',
								),
								'accent' =>array(
									'label' => __( 'Accent Color', 'luigi' ),
									'description' => __( 'A dominant offset color used throughout the theme for links, buttons and other attention-grabbing items.', 'luigi' ),
									'selectors' => array( luigi_tp( 'accent' ), luigi_tp( 'accent-border-color' ) ),
									'attributes' => array( 'color', 'border-color' ),
									'default' => '#9a8f45',
								),
								'accent-hover' =>array(
									'label' => __( 'Accent Hover Color', 'luigi' ),
									'description' => __( 'A lighter shade of the Accent Color used for hover effects.', 'luigi' ),
									'selectors' => array( luigi_tp( 'accent-hover' ) ),
									'attributes' => array( 'color' ),
									'default' => '#9a8f45',
								),
								'text' => array(
									'label' => __( 'Text Color', 'luigi' ),
									'description' => __( 'The main text color. This should stand out clearly from the Background Color and Background Highlight Color so it is easy to read.', 'luigi' ),
									'selectors' => array( luigi_tp( 'text' ), luigi_tp( 'text-important' ) ),
									'attributes' => array( 'color', 'color' ),
									'important' => array( false, true ),
									'default' => '#242424',
								),
								'text-light' => array(
									'label' => __( 'Light Text Color', 'luigi' ),
									'description' => __( 'A shade used for text that should be less prominent. Often a slightly lighter shade of the Text Color.', 'luigi' ),
									'selectors' => luigi_tp( 'text-light' ),
									'attributes' => 'color',
									'default' => '#999999',
								),
							),
						),
					),
				),
			),
		);

		return apply_filters( 'luigi_theme_painter_args', $args );
	}
}

if ( !function_exists( 'luigi_tp' ) ) {
	/**
	 * Get the requested selectors
	 *
	 * @since 0.1
	 */
	function luigi_tp( $color ) {

		$selectors = array();

		switch( $color ) {

			case 'background' :

				$selectors[] = 'html';
				$selectors[] = 'body';
				$selectors[] = '.site-header';
				$selectors[] = '.clc-component-luigi-hero-block .links a';
				break;

			case 'background-highlight' :

				$selectors[] = '.site-footer';
				$selectors[] = '.post-summary.sticky';
				$selectors[] = 'pre';
				$selectors[] = '.comments-area .comment-content';
				$selectors[] = '.comments-area .pingback .comment-body';
				$selectors[] = '.luigi-modal-panel';
				$selectors[] = 'input[type="text"]';
				$selectors[] = 'input[type="search"]';
				$selectors[] = 'input[type="email"]';
				$selectors[] = 'input[type="url"]';
				$selectors[] = 'input[type="tel"]';
				$selectors[] = 'input[type="number"]';
				$selectors[] = 'input[type="date"]';
				$selectors[] = 'input[type="month"]';
				$selectors[] = 'input[type="week"]';
				$selectors[] = 'input[type="datetime"]';
				$selectors[] = 'input[type="datetime-local"]';
				$selectors[] = 'input[type="color"]';
				$selectors[] = 'input[type="password"]';
				$selectors[] = 'select';
				$selectors[] = 'textarea';
				$selectors[] = '.bp-contact-card';
				$selectors[] = '.bp-opening-hours .bp-weekday:nth-child(even)';
				$selectors[] = '.fc-agenda-view .fc-day-grid';
				$selectors[] = '.fc-month-view .fc-bg .fc-day:not(.fc-past):not(.fc-other-moth)';
				break;

			case 'background-highlight-important' :

				$selectors[] = '.fc-agenda-view .fc-time-grid .fc-event';
				$selectors[] = '.fc-agenda-view .fc-time-grid .fc-event[class*="eo-event-cat"]';
				$selectors[] = '.rtb-booking-form .rtb-checkbox label:not(:first-child)';
				$selectors[] = '.rtb-booking-form .rtb-radio label:not(:first-child)';
				break;

			case 'accent' :

				$selectors[] = 'a';
				$selectors[] = 'button';
				$selectors[] = 'input[type="button"]';
				$selectors[] = '.luigi-social-menu a:hover';
				$selectors[] = '.luigi-social-menu a:focus';
				$selectors[] = '.luigi-button';
				$selectors[] = '.comments-area .submit';
				$selectors[] = '.search-form .seach-submit';
				break;

			case 'accent-border-color' :

				$selectors[] = '.luigi-social-menu a:hover';
				$selectors[] = '.luigi-social-menu a:focus';
				break;

			case 'accent-hover' :

				$selectors[] = 'a:hover';
				$selectors[] = 'a:focus';
				$selectors[] = '.luigi-button:hover';
				$selectors[] = '.luigi-button:focus';
				$selectors[] = '.comments-area .comment-metadata > a:hover';
				$selectors[] = '.comments-area .comment-metadata > a:focus';
				$selectors[] = '.search-form .seach-submit:hover';
				$selectors[] = '.search-form .seach-submit:focus';
				$selectors[] = 'button:hover';
				$selectors[] = 'button:focus';
				$selectors[] = 'input[type="button"]:hover';
				$selectors[] = 'input[type="button"]:focus';
				break;

			case 'text' :

				$selectors[] = 'body';
				$selectors[] = '.primary-menu a';
				$selectors[] = '.luigi-social-menu a';
				$selectors[] = '.luigi-button';
				$selectors[] = '.clc-component-luigi-hero-block .links a';
				$selectors[] = '.post-summary .entry-title a';
				$selectors[] = '.gr-reviews .gr-review-body';
				$selectors[] = '.gr-reviews .gr-author';
				$selectors[] = '.eo-agenda-widget-nav>span:before';
				$selectors[] = '.navigation a';
				$selectors[] = '.luigi-button-wire';
				$selectors[] = '.fc-toolbar .fc-center button';
				$selectors[] = '.fc-toolbar .fc-center .fc-prev-button';
				$selectors[] = '.fc-toolbar .fc-center .fc-next-button';
				$selectors[] = '.widget_rss .widgettitle a';
				break;

			case 'text-important' :

				$selectors[] = '.fc-view .fc-event';
				break;

			case 'text-light' :

				$selectors[] = 'blockquote';
				$selectors[] = '.comments-area .comment-metadata > a';
				$selectors[] = '.luigi-social-menu a';
				$selectors[] = '.site-footer .copyright';
				$selectors[] = '.site-header .bp-contact-card';
				$selectors[] = '.post-summary .entry-date';
				$selectors[] = '.widget_calendar table caption';
				$selectors[] = '.widget_rss .rss-date';
				$selectors[] = '.fc-view .fc-day-header';
				$selectors[] = '.fc-listMonth-view .fc-content-skeleton thead td';
				$selectors[] = '.fc-month-view .fc-past';
				$selectors[] = '.fdm-section-header p';
				$selectors[] = '.fdm-item-has-price-discount .fdm-item-price';
				$selectors[] = '.fdm-src-panel';
				$selectors[] = '.gr-reviews .gr-review-date';
				$selectors[] = '.gr-reviews .gr-author-affiliation';
				$selectors[] = '.ninja-forms-cont .label-below label';
				$selectors[] = '.picker .picker__day--outfocus';
				$selectors[] = '.picker .picker__day--disabled';
				break;

		}

		return join( ',', $selectors );
	}
}
