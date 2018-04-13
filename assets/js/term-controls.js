/* global wp */

/**
 * JS functions for terms in admin UI.
 */

( function( $ ) {
	'use strict';

	let component = {};

	/**
	 * Init.
	 */
	component.init = function init() {
		_.extend( component, {
			fileFrame: [],
			uploadButton: $( '#location-cover-image' ),
			removeButton: $( '#location-cover-image-remove' ),
			imgContainer: $( '#location-cover-image-preview' ),
			imgIdInput: $( '#location-cover-image-value' )
		} );

		component.setupLocationMediaUploader();
	};

	/**
	 * Add media uploader for location cover image.
	 */
	component.setupLocationMediaUploader = function() {
		component.uploadButton.on( 'click', function ( event ) {

			event.preventDefault();

			let self = $( this ),
				id = self.attr( 'id' );

			// If the media frame already exists, reopen it.
			if ( component.fileFrame[ id ] ) {
				component.fileFrame[ id ].open();

				return;
			}

			// Create the media frame.
			component.fileFrame[ id ] = wp.media.frames.fileFrame = wp.media( {
				title: self.data( 'uploader_title' ),
				button: {
					text: self.data( 'uploader_button_text' )
				},
				multiple: false
			} );

			// When an image is selected, run a callback.
			component.fileFrame[ id ].on( 'select', function() {
				let attachment = component.fileFrame[ id ].state().get( 'selection' ).first().toJSON();

				// Set input value.
				component.imgIdInput.val( attachment.id );
				component.imgContainer.html( '<img src="' + attachment.url + '" style="max-width: 100%;" />' );

			} );

			// Finally, open the modal
			component.fileFrame[ id ].open();

		} );

		component.removeButton.on( 'click', function( event ) {

			event.preventDefault();
			component.imgIdInput.val( '' );
			component.imgContainer.html( '' );

		} );
	};

	$( document ).ready( function() {
		component.init();
	} );

})( jQuery );
