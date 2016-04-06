'use strict';

module.exports = function(grunt) {

	// Project configuration.
	grunt.initConfig({

		// Load grunt project configuration
		pkg: grunt.file.readJSON('package.json'),

		// Configure less CSS compiler
		less: {
			build: {
				options: {
					ieCompat: true
				},
				files: {
					'style.css': 'assets/src/less/style.less',
					'assets/css/customizer-preview.css': 'assets/src/less/customizer/customizer-preview.less',
					'assets/css/customizer-control.css': 'assets/src/less/customizer/customizer-control.less'
				}
			},
		},

		// Configure the CSS minifier
		cssmin: {
			build: {
				files: [
					{
						src: 'style.css',
						dest: 'style.min.css',
					},
					{
						src: 'assets/css/customizer-preview.css',
						dest: 'assets/css/customizer-preview.min.css',
					},
					{
						src: 'assets/css/customizer-control.css',
						dest: 'assets/css/customizer-control.min.css',
					}
				]
			}
		},

		// Configure JSHint
		jshint: {
			test: {
				src: [
					'assets/src/js/**/*.js',
					'!assets/src/js/content-layout-control/templates/**/*.js',
					'lib/WAI-ARIA-Walker_Nav_Menu/*.js'
				]
			}
		},

		// Concatenate scripts
		concat: {
			build: {
				files: {
					'assets/js/frontend.js': [
						'lib/WAI-ARIA-Walker_Nav_Menu/wai-aria.js',
						'assets/src/js/selector-cache.js',
						'assets/src/js/frontend.js',
						'assets/src/js/frontend-*.js'
					],
					'assets/js/customizer-preview.js': [
						'assets/src/js/content-layout-control/components/model/luigi-content-block.js',
						'assets/src/js/content-layout-control/components/model/luigi-hero-block.js',
						'assets/src/js/content-layout-control/components/model/luigi-posts-reviews.js',
						'assets/src/js/content-layout-control/components/model/luigi-mixer.js',
						'assets/src/js/content-layout-control/components/model/luigi-map.js',
						'assets/src/js/content-layout-control/components/model/luigi-eo-calendar.js',
						'assets/src/js/content-layout-control/components/preview/luigi-content-block.js',
						'assets/src/js/content-layout-control/components/preview/luigi-hero-block.js',
						'assets/src/js/content-layout-control/components/preview/luigi-posts-reviews.js',
						'assets/src/js/content-layout-control/components/preview/luigi-mixer.js',
						'assets/src/js/content-layout-control/components/preview/luigi-map.js',
						'assets/src/js/content-layout-control/components/preview/luigi-eo-calendar.js',
						'assets/src/js/customizer-preview-*.js',
						'assets/src/js/customizer-preview.js'
					],
					'assets/js/customizer-control.js': [
						'assets/src/js/content-layout-control/components/model/luigi-content-block.js',
						'assets/src/js/content-layout-control/components/model/luigi-hero-block.js',
						'assets/src/js/content-layout-control/components/model/luigi-posts-reviews.js',
						'assets/src/js/content-layout-control/components/model/luigi-mixer.js',
						'assets/src/js/content-layout-control/components/model/luigi-map.js',
						'assets/src/js/content-layout-control/components/model/luigi-eo-calendar.js',
						'assets/src/js/content-layout-control/components/control/luigi-content-block.js',
						'assets/src/js/content-layout-control/components/control/luigi-hero-block.js',
						'assets/src/js/content-layout-control/components/control/luigi-posts-reviews.js',
						'assets/src/js/content-layout-control/components/control/luigi-mixer.js',
						'assets/src/js/content-layout-control/components/control/luigi-map.js',
						'assets/src/js/content-layout-control/components/control/luigi-eo-calendar.js',
						'assets/src/js/customizer-control-*.js',
						'assets/src/js/customizer-control.js'
					],
					'assets/js/content-layout-control/templates/components/luigi-content-block.js': 'assets/src/js/content-layout-control/templates/components/luigi-content-block.js',
					'assets/js/content-layout-control/templates/components/luigi-hero-block.js': 'assets/src/js/content-layout-control/templates/components/luigi-hero-block.js',
					'assets/js/content-layout-control/templates/components/luigi-posts-reviews.js': 'assets/src/js/content-layout-control/templates/components/luigi-posts-reviews.js',
					'assets/js/content-layout-control/templates/components/luigi-mixer.js': 'assets/src/js/content-layout-control/templates/components/luigi-mixer.js',
					'assets/js/content-layout-control/templates/components/luigi-map.js': 'assets/src/js/content-layout-control/templates/components/luigi-map.js',
					'assets/js/content-layout-control/templates/components/luigi-eo-calendar.js': 'assets/src/js/content-layout-control/templates/components/luigi-eo-calendar.js',
				}
			}
		},

		// Minimize scripts
		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
			},
			build: {
				files: {
					'assets/js/frontend.min.js' : 'assets/js/frontend.js',
					'assets/js/customizer-preview.min.js' : 'assets/js/customizer-preview.js',
					'assets/js/customizer-control.min.js' : 'assets/js/customizer-control.js'
				}
			}
		},

		// Watch for changes on some files and auto-compile them
		watch: {
			less: {
				files: ['assets/src/less/**/*.less'],
				tasks: ['less', 'cssmin']
			},
			js: {
				files: ['assets/src/js/**', 'lib/WAI-ARIA-Walker_Nav_Menu/*.js'],
				tasks: ['jshint', 'concat', 'uglify']
			}
		},

		// Create a .pot file
		makepot: {
			target: {
				options: {
					cwd: '',                          // Directory of files to internationalize.
					domainPath: 'languages',                   // Where to save the POT file.
					exclude: [],                      // List of files or directories to ignore.
					include: [],                      // List of files or directories to include.
					i18nToolsPath: '/media/Storage/projects/wordpress/trunk/tools/i18n',                // Path to the i18n tools directory.
					mainFile: 'functions.php',                     // Main project file.
					potComments: '',                  // The copyright at the beginning of the POT file.
					potFilename: 'luigi.pot',                  // Name of the POT file.
					potHeaders: {
						poedit: true,                 // Includes common Poedit headers.
						'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
					},                                // Headers to add to the generated POT file.
					processPot: function( pot, options ) {
						pot.headers['report-msgid-bugs-to'] = 'http://themeofthecrop.com';
						return pot;
					},
					type: 'wp-theme',                // Type of project (wp-plugin or wp-theme).
					updateTimestamp: true             // Whether the POT-Creation-Date should be updated without other changes.
				}
			}
		},

		// Build a package for distribution
		compress: {
			main: {
				options: {
					archive: 'luigi-<%= pkg.version %>.zip'
				},
				files: [
					{
						src: [
							'*', '**/*',
							'!luigi-<%= pkg.version %>.zip',
							'!.*', '!Gruntfile.js', '!package.json', '!node_modules', '!node_modules/**/*',
							'!**/.*', '!**/Gruntfile.js', '!**/package.json', '!**/node_modules', '!**/node_modules/**/*',
							'!assets/src', '!assets/src/**/*',
							'!lib/content-layout-control/src', '!lib/content-layout-control/src/**/*',
						],
						dest: 'luigi/',
					}
				]
			}
		}

	});

	// Load tasks
	grunt.loadNpmTasks('grunt-contrib-compress');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-nodeunit');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-wp-i18n');

	// Default task(s).
	grunt.registerTask('default', ['watch']);

	grunt.registerTask('build', ['less', 'jshint', 'concat', 'uglify']);

	grunt.registerTask('package', ['build', 'compress']);

};
