/**
 * Gruntfile for compiling theme_shoelace .less files.
 *
 * This file configures tasks to be run by Grunt
 * http://gruntjs.com/ for the current theme.
 *
 *
 * Requirements:
 * -------------
 * nodejs, npm, grunt-cli.
 *
 * Installation:
 * -------------
 * node and npm: instructions at http://nodejs.org/
 *
 * grunt-cli: `[sudo] npm install -g grunt-cli`
 *
 * node dependencies: run `npm install` in the root directory.
 *
 *
 * Usage:
 * ------
 * Call tasks from the theme root directory. Default behaviour
 * (calling only `grunt`) is to run the watch task detailed below.
 *
 *
 * Porcelain tasks:
 * ----------------
 * The nice user interface intended for everyday use. Provide a
 * high level of automation and convenience for specific use-cases.
 *
 * grunt amd     Create the Asynchronous Module Definition JavaScript files.  See: MDL-49046.
 *               Done here as core Gruntfile.js currently *nix only.
 *
 * grunt svg                 Change the colour of the SVGs in pix_core by
 *                           text replacing #999999 with a new hex colour.
 *                           Note this requires the SVGs to be #999999 to
 *                           start with or the replace will do nothing
 *                           so should usually be preceded by copying
 *                           a fresh set of the original SVGs.
 *
 *                           Options:
 *
 *                           --svgcolour=<hexcolour> Hex colour to use for SVGs
 *
 * Plumbing tasks & targets:
 * -------------------------
 * Lower level tasks encapsulating a specific piece of functionality
 * but usually only useful when called in combination with another.
 *
 * grunt replace             Run all text replace tasks.
 *
 * @package theme
 * @subpackage shoelace
 * @author G J Barnard - {@link http://moodle.org/user/profile.php?id=442195}
 * @author Based on code originally written by Joby Harding, Bas Brands, David Scotson and many other contributors.
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

module.exports = function(grunt) { // jshint ignore:line

    // Import modules.
    var path = require('path');

    // Production / development.
    var build = grunt.option('build') || 'd'; // Development for 'watch' task.

    if ((build != 'p') && (build != 'd')) {
        build = 'p';
        console.log('-build switch only accepts \'p\' for production or \'d\' for development,');
        console.log('e.g. -build=p or -build=d.  Defaulting to development.');
    }

    // PHP strings for exec task.
    var moodleroot = path.dirname(path.dirname(__dirname)), // jshint ignore:line
        configfile = '',
        decachephp = '',
        dirrootopt = grunt.option('dirroot') || process.env.MOODLE_DIR || ''; // jshint ignore:line

    // Allow user to explicitly define Moodle root dir.
    if ('' !== dirrootopt) {
        moodleroot = path.resolve(dirrootopt);
    }

    var PWD = process.cwd(); // jshint ignore:line
    configfile = path.join(moodleroot, 'config.php');

    decachephp += 'define(\'CLI_SCRIPT\', true);';
    decachephp += 'require(\'' + configfile + '\');';
    decachephp += 'theme_reset_all_caches();';

    var svgcolour = grunt.option('svgcolour') || '#7575E0';

    grunt.initConfig({
        copy: {
            svg_pix: {
                expand: true,
                cwd:  'pix_originals/',
                src:  '**',
                dest: 'pix/',
            },
            svg_core: {
                expand: true,
                cwd:  'pix_core_originals/',
                src:  '**',
                dest: 'pix_core/',
            },
            svg_plugins: {
                expand: true,
                cwd:  'pix_plugins_originals/',
                src:  '**',
                dest: 'pix_plugins/',
            },
            svg_fp: {
                expand: true,
                cwd:  'pix_fp_originals/',
                src:  '**',
                dest: 'pix/fp/',
            }
        },
        replace: {
            svg_colours_pix: {
                src: 'pix/**/*.svg',
                overwrite: true,
                replacements: [{
                    from: '#999999',
                    to: svgcolour
                }]
            },
            svg_colours_core: {
                src: 'pix_core/**/*.svg',
                overwrite: true,
                replacements: [{
                    from: '#999',
                    to: svgcolour
                }]
            },
            svg_colours_plugins: {
                src: 'pix_plugins/**/*.svg',
                overwrite: true,
                replacements: [{
                    from: '#999',
                    to: svgcolour
                }]
            },
            svg_colours_fp: {
                src: 'pix/fp/**/*.svg',
                overwrite: true,
                replacements: [{
                    from: '#999',
                    to: svgcolour
                }]
            }
        },
        svgmin: {                       // Task.
            options: {                  // Configuration that will be passed directly to SVGO.
                plugins: [{
                    removeViewBox: false
                }, {
                    removeUselessStrokeAndFill: false
                }, {
                    convertPathData: {
                        straightCurves: false // Advanced SVGO plugin option.
                    }
                }]
            },
            dist: {                       // Target.
                files: [{                 // Dictionary of files.
                    expand: true,         // Enable dynamic expansion.
                    cwd: 'pix_core',      // Source matches are relative to this path.
                    src: ['**/*.svg'],    // Actual pattern(s) to match.
                    dest: 'pix_core/',    // Destination path prefix.
                    ext: '.svg'           // Destination file paths will have this extension.
                }, {                      // Dictionary of files.
                    expand: true,         // Enable dynamic expansion.
                    cwd: 'pix_plugins',   // Source matches are relative to this path.
                    src: ['**/*.svg'],    // Actual pattern(s) to match.
                    dest: 'pix_plugins/', // Destination path prefix.
                    ext: '.svg'           // Destination file paths will have this extension.
                }]
            }
        },
        exec: {
            decache: {
                cmd: 'php -r "' + decachephp + '"',
                callback: function(error) {
                    // The 'exec' process will output error messages, just add one to confirm success.
                    if (!error) {
                        grunt.log.writeln("Moodle theme cache reset.");
                    }
                }
            }
        },
        jshint: {
            options: {jshintrc: moodleroot + '/.jshintrc'},
            files: ['**/amd/src/*.js']
        },
        uglify: {
            dynamic_mappings: {
                files: grunt.file.expandMapping(
                    ['**/src/*.js', '!**/node_modules/**'],
                    '',
                    {
                        cwd: PWD,
                        rename: function(destBase, destPath) {
                            destPath = destPath.replace('src', 'build');
                            destPath = destPath.replace('.js', '.min.js');
                            destPath = path.resolve(PWD, destPath);
                            return destPath;
                        }
                    }
                )
            }
        }
    });

    // Load contrib tasks.
    grunt.loadNpmTasks("grunt-exec");
    grunt.loadNpmTasks("grunt-text-replace");
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-svgmin');

    // Load core tasks.
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-jshint');

    // Register tasks.
    grunt.registerTask("default", ["watch"]);
    grunt.registerTask("decache", ["exec:decache"]);

    grunt.registerTask("copy:svg", ["copy:svg_pix", "copy:svg_core", "copy:svg_plugins", "copy:svg_fp"]);
    grunt.registerTask("replace:svg_colours", ["replace:svg_colours_pix", "replace:svg_colours_core",
        "replace:svg_colours_plugins", "replace:svg_colours_fp"]);
    grunt.registerTask("svg", ["copy:svg", "replace:svg_colours", "svgmin"]);
    grunt.registerTask("amd", ["jshint", "uglify", "decache"]);
};
