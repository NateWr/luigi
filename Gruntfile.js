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
					compress: true,
					cleancss: true,
					ieCompat: true
				},
				files: {
					'style.css': 'assets/src/less/style.less',
					'assets/css/customizer-preview.css': 'assets/src/less/customizer/customizer-preview.less',
					'assets/css/customizer-control.css': 'assets/src/less/customizer/customizer-control.less'
				}
			}
		},

		// Configure JSHint
		jshint: {
			test: {
				src: [
					'assets/src/js/*.js',
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
						'assets/src/js/customizer-ajax.js',
						'assets/src/js/customizer-preview.js',
						'assets/src/js/customizer-preview-*.js'
					],
					'assets/js/customizer-control.js': [
						'assets/src/js/customizer-control.js',
					]
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
				tasks: ['less']
			},
			js: {
				files: ['assets/src/js/*.js', 'lib/WAI-ARIA-Walker_Nav_Menu/*.js'],
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
		}

	});

	// Load tasks
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-nodeunit');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-wp-i18n');

	// Default task(s).
	grunt.registerTask('default', ['watch']);

};
