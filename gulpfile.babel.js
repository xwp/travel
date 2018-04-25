/* eslint-env es6 */
'use strict';

/**
 * To start theme building process, define the theme name below,
 * then run "gulp" in command line.
 */

import gulp from 'gulp';
import autoprefixer from 'autoprefixer';
import browserSync from 'browser-sync';
import cssnano from 'gulp-cssnano';
import babel from 'gulp-babel';
import cssnext from 'postcss-cssnext';
import eslint from 'gulp-eslint';
import log from 'fancy-log';
import gulpif from 'gulp-if';
import image from 'gulp-image';
import newer from 'gulp-newer';
import partialImport from 'postcss-partial-import';
import phpcs from 'gulp-phpcs';
import postcss from 'gulp-postcss';
import print from 'gulp-print';
import replace from 'gulp-string-replace';
import requireUncached from 'require-uncached';
import sass from 'gulp-sass';
import sourcemaps from 'gulp-sourcemaps';
import sort from 'gulp-sort';
import tabify from 'gulp-tabify';
import uglify from 'gulp-uglify';
import wppot from 'gulp-wp-pot';
import zip from 'gulp-zip';

// Import theme-specific configurations.
var config = require( './dev/config/themeConfig.js' );

// Project paths
const paths = {
  config: {
    cssVars: './dev/config/cssVariables.json'
  },
  php: {
    src: [ 'dev/**/*.php', '!dev/optional/**/*.*' ],
    dest: './'
  },
  styles: {
    src: [ 'dev/**/*.css', '!dev/optional/**/*.*' ],
    dest: './',
    sass: [ 'dev/**/*.scss' ]
  },
  scripts: {
    src: [ 'dev/**/*.js', '!dev/js/libs/**/*.js', '!dev/optional/**/*.*', '!dev/config/**/*' ],
    dest: './',
    libs: 'dev/js/libs/**/*.js',
    libsDest: './js/libs/'
  },
  images: {
    src: [ 'dev/**/*.{jpg,JPG,png}', '!dev/optional/**/*.*' ],
    dest: './'
  },
  languages: {
    src: [ './**/*.php', '!dev/**/*.php', '!verbose/**/*.php' ],
    dest: './languages/' + config.theme.name + '.pot'
  },
  verbose: './verbose/',
  export: {
    src: [ '**/*', '!dev/**/*', '!node_modules', '!node_modules/**/*', '!vendor', '!vendor/**/*', '!.*', '!composer.*', '!gulpfile.*', '!package*.*', '!phpcs.*', '!*.zip' ],
    dest: './'
  }
};

/**
 * Conditionally set up BrowserSync.
 * Only run BrowserSync if config.browserSync.live = true.
 */

// Create a BrowserSync instance:
const server = browserSync.create();

// Initialize the BrowserSync server conditionally:
function serve( done ) {
  if ( config.browserSync.live ) {
    server.init( {
      proxy: config.browserSync.proxyURL,
      port: config.browserSync.bypassPort,
      liveReload: true
    } );
  }
  done();
}

// Reload the live site:
function reload( done ) {
  config = requireUncached( './dev/config/themeConfig.js' );
  if ( config.browserSync.live ) {
    if ( server.paused ) {
      server.resume();
    }
    server.reload();
  }
  else {
    server.pause();
  }
  done();
}

/**
 * PHP via PHP Code Sniffer.
 */

const themeSupportsArray = `// Add custom theme supports.
		add_theme_support( 'amp' );`;

export function php() {
  config = requireUncached( './dev/config/themeConfig.js' );
  return gulp.src( paths.php.src )
    .pipe( newer( paths.php.dest ) )
    .pipe( gulpif( config.themeSupports.amp, replace( '// customThemeSupports.', themeSupportsArray ) ) )
    .pipe( phpcs( {
      bin: 'vendor/bin/phpcs',
      standard: 'WordPress',
      warningSeverity: 0
    } ) )
    // Log all problems that was found
    .pipe( phpcs.reporter( 'log' ) )
    .pipe( gulp.dest( paths.verbose ) )
    .pipe( gulp.dest( paths.php.dest ) );
}

/**
 * Sass, if that's being used.
 */
export function sassStyles() {
  return gulp.src( paths.styles.sass, {base: './'} )
    .pipe( sourcemaps.init() )
    .pipe( sass().on( 'error', sass.logError ) )
    .pipe( tabify( 2, true ) )
    .pipe( sourcemaps.write( './maps' ) )
    .pipe( gulp.dest( '.' ) );
}

/**
 * CSS via PostCSS + CSSNext (includes Autoprefixer by default).
 */
export function styles() {
  config = requireUncached( './dev/config/themeConfig.js' );

  // Reload cssVars every time the task runs.
  let cssVars = requireUncached( paths.config.cssVars );

  return gulp.src( paths.styles.src )
    .pipe( print() )
    .pipe( phpcs( {
      bin: 'vendor/bin/phpcs',
      standard: 'WordPress',
      warningSeverity: 0
    } ) )
    // Log all problems that was found
    .pipe( phpcs.reporter( 'log' ) )
    .pipe( postcss( [
      cssnext( {
        browsers: config.theme.browserslist,
        features: {
          customProperties: {
            variables: cssVars.variables,
          },
          customMedia: {
            extensions: cssVars.queries,
          }
        }
      } )
    ] ) )
    .pipe( gulp.dest( paths.verbose ) )
    .pipe( gulpif( !config.debug.styles, cssnano() ) )
    .pipe( gulp.dest( paths.styles.dest ) );
}

/**
 * JavaScript via Babel, ESlint, and uglify.
 */
export function scripts() {
  config = requireUncached( './dev/config/themeConfig.js' );
  return gulp.src( paths.scripts.src )
    .pipe( newer( paths.scripts.dest ) )
    .pipe( eslint() )
    .pipe( eslint.format() )
    .pipe( babel() )
    .pipe( gulp.dest( paths.verbose ) )
    .pipe( gulpif( !config.debug.styles, uglify() ) )
    .pipe( gulp.dest( paths.scripts.dest ) );
}

/**
 * Copy JS libraries without touching them.
 */
export function jsCopy() {
  return gulp.src( paths.scripts.libs )
    .pipe( newer( paths.scripts.libsDest ) )
    .pipe( gulp.dest( paths.verbose ) )
    .pipe( gulp.dest( paths.scripts.libsDest ) );
}

/**
 * Optimize images.
 */
export function images() {
  return gulp.src( paths.images.src )
    .pipe( newer( paths.images.dest ) )
    .pipe( image() )
    .pipe( gulp.dest( paths.images.dest ) );
}

/**
 * Watch everything
 */
export function watch() {
  gulp.watch( paths.php.src, gulp.series( php, reload ) );
  gulp.watch( paths.config.cssVars, gulp.series( styles, reload ) );
  gulp.watch( paths.styles.sass, sassStyles );
  gulp.watch( paths.styles.src, gulp.series( styles, reload ) );
  gulp.watch( paths.scripts.src, gulp.series( gulp.parallel( scripts, jsCopy ), reload ) );
  gulp.watch( paths.images.src, gulp.series( images, reload ) );
}

/**
 * Map out the sequence of events on first load:
 */
const firstRun = gulp.series( php, gulp.parallel( scripts, jsCopy ), sassStyles, styles, images, serve, watch );

/**
 * Run the whole thing.
 */
export default firstRun;

/**
 * Generate translation files.
 */
export function translate() {
  return gulp.src( paths.languages.src )
    .pipe( sort() )
    .pipe( wppot( {
      domain: config.theme.name,
      package: config.theme.name,
      bugReport: config.theme.name,
      lastTranslator: config.theme.author
    } ) )
    .pipe( gulp.dest( paths.languages.dest ) );
}

/**
 * Create zip archive from generated theme files.
 */
export function bundle() {
  return gulp.src( paths.export.src )
    .pipe( print() )
    .pipe( gulpif( config.export.compress, zip( config.theme.name + '.zip' ), gulp.dest( paths.export.dest + config.theme.name ) ) )
    .pipe( gulpif( config.export.compress, gulp.dest( paths.export.dest ) ) );
}

/**
 * Export theme for distribution.
 */
const bundleTheme = gulp.series( php, gulp.parallel( scripts, jsCopy ), styles, images, translate, bundle );

export { bundleTheme };
