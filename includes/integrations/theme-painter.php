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
									'description' => __( 'The primary background color on your site.', 'luigi' ),
									'selectors' => array(
										luigi_tp( 'background' ),
										luigi_tp( 'background-adjust-border-automatically' ),
										luigi_tp( 'background-adjust-border-light-automatically' ),
										luigi_tp( 'background-adjust-background-automatically' ),
										luigi_tp( 'background-adjust-color-automatically' ),
									),
									'attributes' => array(
										'background',
										'border-color',
										'border-color',
										'background-color',
										'color',
									),
									'set_values' => array(
										false,
										'rgba(255,255,255,0.3)',
										'rgba(255,255,255,0.12)',
										'rgba(255,255,255,0.85)',
										false,
									),
									'default' => '#fafafa',
								),
								'background-highlight' => array(
									'label' => __( 'Background Highlight Color', 'luigi' ),
									'description' => __( 'A background color used to bring attention to a section or a panel on your site. Often a slightly lighter shade of the Background Color.', 'luigi' ),
									'selectors' => array(
										luigi_tp( 'background-highlight' ),
										luigi_tp( 'background-highlight-important' ),
									),
									'attributes' => array( 'background', 'background' ),
									'important' => array( false, true ),
									'default' => '#ffffff',
								),
								'accent' =>array(
									'label' => __( 'Accent Color', 'luigi' ),
									'description' => __( 'A dominant offset color used throughout the theme for links, buttons and other attention-grabbing items.', 'luigi' ),
									'selectors' => array(
										luigi_tp( 'accent' ),
										luigi_tp( 'accent-important' ),
										luigi_tp( 'accent-background-color' ),
										luigi_tp( 'accent-border-color' ),
									),
									'attributes' => array(
										'color',
										'color',
										'background-color',
										'border-color',
									),
									'important' => array(
										false,
										true,
										false,
										false,
									),
									'default' => '#9a8f45',
								),
								'accent-lift' =>array(
									'label' => __( 'Accent Hover Color', 'luigi' ),
									'description' => __( 'A lighter shade of the Accent Color used for hover effects.', 'luigi' ),
									'selectors' => array(
										luigi_tp( 'accent-lift' ),
										luigi_tp( 'accent-lift-background'),
										luigi_tp( 'accent-lift-background-screen-sm'),
									),
									'attributes' => array(
										'color',
										'background-color',
										'background-color',
									),
									'queries' => array(
										'',
										'',
										'@media(min-width: 768px)',
									),
									'default' => '#9a8f45',
								),
								'text' => array(
									'label' => __( 'Text Color', 'luigi' ),
									'description' => __( 'The main text color. This should stand out clearly from the Background Color and Background Highlight Color so it is easy to read.', 'luigi' ),
									'selectors' => array(
										luigi_tp( 'text' ),
										luigi_tp( 'text-important' ),
									),
									'attributes' => array(
										'color',
										'color'
									),
									'important' => array(
										false,
										true
									),
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

		$background_is_dark = theme_painter_is_color_dark( get_theme_mod( 'theme_painter_setting_background', '#fafafa'  ) );

		set_theme_mod( 'is_dark_background', $background_is_dark );

		$selectors = array();

		switch( $color ) {

			case 'background' :

				$selectors[] = 'html';
				$selectors[] = 'body';
				$selectors[] = '.site-header';
				$selectors[] = '.clc-component-luigi-hero-block .links a';
				break;

			// Swap rgba borders from dark to light for dark backgrounds
			case 'background-adjust-border-automatically' :

				if ( !$background_is_dark ) {
					break;
				}

				$selectors[] = 'hr';
				$selectors[] = 'table';
				$selectors[] = 'tr';
				$selectors[] = 'pre';
				$selectors[] = '.comments-area comments-title + .comment-navigation';
				$selectors[] = '.luigi-social-menu a';
				$selectors[] = '.navigation';
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
				$selectors[] = '.fc-agenda-view > table';
				$selectors[] = '.fc-agenda-view .fc-bg td';
				$selectors[] = '.fc-agenda-view .fc-day-grid';
				$selectors[] = '.fc-agenda-view .fc-slats .fc-minor';
				$selectors[] = '.fc-basic-view .fc-bg td';
				$selectors[] = '.fc-basic-view .fc-event.eo-multi-day';
				$selectors[] = '.fc-basic-view .fc-event.eo-multi-day .fc-content';
				$selectors[] = '.fc-basicWeek-view > table';
				$selectors[] = '.fc-basicDay-view > table';
				$selectors[] = '.fc-basicWeek-view > table > tbody';
				$selectors[] = '.fc-basicDay-view > table > tbody';
				$selectors[] = '.fc-month-view > table';
				$selectors[] = '.fc-month-view > table > tbody > tr > td td';
				$selectors[] = '.fc-month-view .fc-event.eo-multi-day .fc-content';
				$selectors[] = '.ninja-forms-response-msg > div';
				$selectors[] = '.rtb-booking-form label';
				$selectors[] = '.rtb-booking-form rtb-checkbox';
				$selectors[] = '.rtb-booking-form rtb-radio';
				$selectors[] = '.rtb-booking-form rtb-checkbox label:first-child';
				$selectors[] = '.rtb-booking-form rtb-radio label:first-child';
				break;

			// Swap rbga borders from dark to light for dark backgrounds
			case 'background-adjust-border-light-automatically' :

				if ( !$background_is_dark ) {
					break;
				}

				$selectors[] = 'blockquote';
				$selectors[] = '.comments-area .comment-content';
				$selectors[] = '.comments-area .pingback .comment-body';
				$selectors[] = '.site-footer';
				$selectors[] = '.post-summary.sticky';
				$selectors[] = '.widget-area > li';
				$selectors[] = '.footer-widget-container';
				$selectors[] = '.footer-full-widget-container';
				$selectors[] = '.clc-component-layout + .clc-component-layout:not(.clc-component-luigi-hero-block)';
				$selectors[] = '.bp-contact-card';
				$selectors[] = '.bp-opening-hours:not(:first-child)';
				$selectors[] = '.bp-opening-hours:not(:last-child)';
				$selectors[] = '.fc-listMonth-view .fc-content-skeleton thead td';
				$selectors[] = '.fc-agenda-view .fc-slats tr';
				$selectors[] = '.event-meta-item.recurrence-description';
				$selectors[] = '.fdm-section-header h3';
				$selectors[] = '.fdm-item-image';
				$selectors[] = '.clc-component-luigi-content-block .content:before';
				break;

			// Swap rbga backgrounds from dark to light for dark backgrounds
			case 'background-adjust-background-automatically' :

				if ( !$background_is_dark ) {
					break;
				}

				// Default button
				$selectors[] = '.luigi-button';
				$selectors[] = '.comments-area .submit';
				$selectors[] = '.search-form .search-submit';
				$selectors[] = 'input[type="button"]';
				$selectors[] = 'input[type="submit"]';
				$selectors[] = 'button';
				$selectors[] = '.post-summary .more';
				$selectors[] = '.post-password-form input[type="submit"]';
				$selectors[] = '.clc-component-layout .links a';
				$selectors[] = '.luigi-contact-card-links a';
				$selectors[] = '.ninja-forms-cont .submit-wrap input[type="submit"]';
				$selectors[] = '.clc-component-luigi-hero-block .links a';
				$selectors[] = '.luigi-clc-mixer-opening_hours .booking';
				break;

			// Swap rbga text color from light to dark for light buttons on
			// dark backgrounds
			case 'background-adjust-color-automatically' :

				if ( !$background_is_dark ) {
					break;
				}

				// Default button
				$selectors[] = '.luigi-button';
				$selectors[] = '.comments-area .submit';
				$selectors[] = '.search-form .search-submit';
				$selectors[] = 'input[type="button"]';
				$selectors[] = 'input[type="submit"]';
				$selectors[] = 'button';
				$selectors[] = '.post-summary .more';
				$selectors[] = '.post-password-form input[type="submit"]';
				$selectors[] = '.clc-component-layout .links a';
				$selectors[] = '.luigi-contact-card-links a';
				$selectors[] = '.ninja-forms-cont .submit-wrap input[type="submit"]';
				$selectors[] = '.clc-component-luigi-hero-block .links a';
				$selectors[] = '.luigi-clc-mixer-opening_hours .booking';
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
				$selectors[] = '.luigi-social-menu a:hover';
				$selectors[] = '.luigi-social-menu a:focus';
				$selectors[] = '.luigi-button-wire:hover';
				$selectors[] = '.luigi-button-wire:focus';
				$selectors[] = '.comments-area .submit';
				$selectors[] = '.search-form .seach-submit';
				$selectors[] = '.luigi-button-link-primary';
				$selectors[] = '.luigi-list-item:before';
				$selectors[] = '.site-header .home-link';
				$selectors[] = '.site-footer .home-link';
				$selectors[] = '.widget_recent_entries .more';
				$selectors[] = '.clc-component-layout .title_line_one';
				$selectors[] = '.fdm-item-price-wrapper';
				$selectors[] = '.fdm-item-flag-text';
				$selectors[] = '.gr-reviews .gr-rating-stars .dashicons';
				$selectors[] = '.gr-reviews .gr-rating-numbers';
				$selectors[] = '.ninja-forms-star-rating-on:before';
				$selectors[] = '.ninja-forms-star-rating-hover:before';
				$selectors[] = '.fc-toolbar .fc-center button:hover';
				$selectors[] = '.fc-toolbar .fc-center button:focus';
				$selectors[] = '.fc-toolbar .fc-prev-button:hover';
				$selectors[] = '.fc-toolbar .fc-prev-button:focus';
				$selectors[] = '.fc-toolbar .fc-next-button:hover';
				$selectors[] = '.fc-toolbar .fc-next-button:focus';
				$selectors[] = '.post-edit-link';
				break;

			case 'accent-important' :

				$selectors[] = '.fc-view .fc-event:hover';
				$selectors[] = '.fc-view .fc-event:focus';
				break;

			case 'accent-background-color' :

				$selectors[] = '.luigi-button:active';
				$selectors[] = '.luigi-button-primary';
				$selectors[] = '.primary-menu a:hover';
				$selectors[] = '.primary-menu a:focus';
				$selectors[] = '#luigi-primary-nav-control';
				$selectors[] = '.comments-area .submit:active';
				$selectors[] = '.search-form .search-submit:active';
				$selectors[] = 'input[type="button"]:active';
				$selectors[] = 'input[type="submit"]:active';
				$selectors[] = 'button:active';
				$selectors[] = '.post-summary .more:active';
				$selectors[] = '.post-password-form input[type="submit"]:active';
				$selectors[] = '.clc-component-layout .links a:active';
				$selectors[] = '.luigi-contact-card-links a:active';
				$selectors[] = '.ninja-forms-cont .submit-wrap input[type="submit"]:active';
				$selectors[] = '.clc-component-luigi-hero-block .links a:active';
				$selectors[] = '.luigi-clc-mixer-opening_hours .booking:active';
				$selectors[] = '.clc-component-layout .links li:first-child a';
				$selectors[] = '.luigi-contact-card-links > div:first-child a';
				$selectors[] = '.luigi-clc-mixer-opening_hours .booking';
				$selectors[] = '.widget_archive li:before';
				$selectors[] = '.widget_categories li:before';
				$selectors[] = '.widget_pages li:before';
				$selectors[] = '.widget_meta li:before';
				$selectors[] = '.widget_nav_menu li:before';
				$selectors[] = '.widget_recent_comments li:before';
				$selectors[] = '.EO_Event_List_Widget li:before';
				$selectors[] = '.eo__event_categories li:before';
				$selectors[] = '.eo-agenda-widget li:before';
				$selectors[] = '.eo-events-shortcode li:before';
				break;

			case 'accent-border-color' :

				$selectors[] = '.luigi-social-menu a:hover';
				$selectors[] = '.luigi-social-menu a:focus';
				$selectors[] = '.luigi-button-wire:hover';
				$selectors[] = '.luigi-button-wire:focus';
				$selectors[] = 'input[type="text"]:hover';
				$selectors[] = 'input[type="text"]:focus';
				$selectors[] = 'input[type="search"]:hover';
				$selectors[] = 'input[type="search"]:focus';
				$selectors[] = 'input[type="email"]:hover';
				$selectors[] = 'input[type="email"]:focus';
				$selectors[] = 'input[type="url"]:hover';
				$selectors[] = 'input[type="url"]:focus';
				$selectors[] = 'input[type="tel"]:hover';
				$selectors[] = 'input[type="tel"]:focus';
				$selectors[] = 'input[type="number"]:hover';
				$selectors[] = 'input[type="number"]:focus';
				$selectors[] = 'input[type="date"]:hover';
				$selectors[] = 'input[type="date"]:focus';
				$selectors[] = 'input[type="month"]:hover';
				$selectors[] = 'input[type="month"]:focus';
				$selectors[] = 'input[type="week"]:hover';
				$selectors[] = 'input[type="week"]:focus';
				$selectors[] = 'input[type="datetime"]:hover';
				$selectors[] = 'input[type="datetime"]:focus';
				$selectors[] = 'input[type="datetime-local"]:hover';
				$selectors[] = 'input[type="datetime-local"]:focus';
				$selectors[] = 'input[type="color"]:hover';
				$selectors[] = 'input[type="color"]:focus';
				$selectors[] = 'input[type="password"]:hover';
				$selectors[] = 'input[type="password"]:focus';
				$selectors[] = 'select:hover';
				$selectors[] = 'select:focus';
				$selectors[] = 'textarea:hover';
				$selectors[] = 'textarea:focus';
				$selectors[] = '.rtb-booking-form .picker__input.picker__input--active';
				$selectors[] = '.fc-toolbar .fc-center button:hover';
				$selectors[] = '.fc-toolbar .fc-center button:focus';
				$selectors[] = '.fc-toolbar .fc-prev-button:hover';
				$selectors[] = '.fc-toolbar .fc-prev-button:focus';
				$selectors[] = '.fc-toolbar .fc-next-button:hover';
				$selectors[] = '.fc-toolbar .fc-next-button:focus';
				break;

			case 'accent-lift' :

				$selectors[] = 'a:hover';
				$selectors[] = 'a:focus';
				$selectors[] = '.luigi-button-link-primary:hover';
				$selectors[] = '.luigi-button-link-primary:focus';
				$selectors[] = '.comments-area .comment-metadata > a:hover';
				$selectors[] = '.comments-area .comment-metadata > a:focus';
				$selectors[] = '.ui-datepicker-calendar a:hover';
				$selectors[] = '.ui-datepicker-calendar a:focus';
				$selectors[] = '.post-summary .entry-title a:hover';
				$selectors[] = '.post-summary .entry-title a:focus';
				$selectors[] = '.widget_recent_entries .more:hover';
				$selectors[] = '.widget_recent_entries .more:focus';
				$selectors[] = '.post-edit-link:hover';
				$selectors[] = '.post-edit-link:focus';
				break;

			case 'accent-lift-background' :

				$selectors[] = '.luigi-button:hover';
				$selectors[] = '.luigi-button:focus';
				$selectors[] = '.comments-area .submit:hover';
				$selectors[] = '.comments-area .submit:focus';
				$selectors[] = '.search-form .search-submit:hover';
				$selectors[] = '.search-form .search-submit:focus';
				$selectors[] = 'button:hover';
				$selectors[] = 'button:focus';
				$selectors[] = 'input[type="button"]:hover';
				$selectors[] = 'input[type="button"]:focus';
				$selectors[] = 'input[type="submit"]:hover';
				$selectors[] = 'input[type="submit"]:focus';
				$selectors[] = '.post-summary .more:hover';
				$selectors[] = '.post-summary .more:focus';
				$selectors[] = '.post-edit-link:hover';
				$selectors[] = '.post-edit-link:focus';
				$selectors[] = '.clc-component-layout .links a:hover';
				$selectors[] = '.clc-component-layout .links a:focus';
				$selectors[] = '.clc-component-layout .links li:first-child a:hover';
				$selectors[] = '.clc-component-layout .links li:first-child a:focus';
				$selectors[] = '.luigi-contact-card-links a:hover';
				$selectors[] = '.luigi-contact-card-links a:focus';
				$selectors[] = '.luigi-contact-card-links > div:first-child a:hover';
				$selectors[] = '.luigi-contact-card-links > div:first-child a:focus';
				$selectors[] = '.ninja-forms-cont .submit-wrap input[type="submit"]:hover';
				$selectors[] = '.ninja-forms-cont .submit-wrap input[type="submit"]:focus';
				$selectors[] = '.clc-component-luigi-hero-block .links a:hover';
				$selectors[] = '.clc-component-luigi-hero-block .links a:focus';
				$selectors[] = '.luigi-clc-mixer-opening_hours .booking:hover';
				$selectors[] = '.luigi-clc-mixer-opening_hours .booking:focus';
				$selectors[] = '.luigi-social-menu a:hover';
				$selectors[] = '.luigi-social-menu a:focus';
				break;

			case 'accent-lift-background-screen-sm' :

				$selectors[] = '.primary-menu [aria-expanded=true] a:hover';
				$selectors[] = '.primary-menu [aria-expanded=true] a:focus';
				break;

			case 'text' :

				$selectors[] = 'body';
				$selectors[] = '.primary-menu a';
				$selectors[] = '.luigi-social-menu a';
				$selectors[] = '.luigi-button';
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
				$selectors[] = '.primary-menu [aria-expanded=true] a:hover';
				$selectors[] = '.primary-menu [aria-expanded=true] a:focus';
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
				$selectors[] = '.fdm-item-flag-text';
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

if ( !function_exists( 'luigi_theme_painter_add_body_class' ) ) {
	/**
	 * Add a body class if any styles need to be adjusted to compensate for
	 * color selectons
	 *
	 * @since 0.1
	 */
	function luigi_theme_painter_add_body_class( $classes ) {

		$accent_color = get_theme_mod( 'theme_painter_setting_accent', '#9a8f45'  );
		if ( $accent_color != '#9a8f45' ) {
			$classes[] = get_theme_mod( 'is_dark_background', false ) ? 'luigi-bg-dark' : 'luigi-bg-light';
		}

		return $classes;
	}
	add_filter( 'body_class', 'luigi_theme_painter_add_body_class' );
}
