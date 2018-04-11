'use strict';

module.exports = {
	theme: {
    name: 'Travel',
    domain: 'travel',
		author: 'XWP',
		browserslist: [ // See https://github.com/browserslist/browserslist
			'> 1%',
			'last 2 versions'
		]
	},
	browserSync: {
		live: false,
		proxyURL: 'ptsk.test:8888',
		bypassPort: '8181'
	},
	themeSupports: {
		amp: true
	},
	export: {
		compress: true
	},
	debug: {
		styles: false, // Render verbose CSS for debugging.
		scripts: false // Render verbose JS for debugging.
	}
};
