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
			imgIdInput: $( '#location-cover-image-value' ),
			saveNewTermButton: $( '#addtag #submit' )
		} );

		component.setupLocationMediaUploader();
		component.setupAddTerm();
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
				title: wp.i18n.__( 'Select Location Cover Image' ),
				button: {
					text: wp.i18n.__( 'Select Image' )
				},
				multiple: false
			} );

			// When an image is selected, run a callback.
			component.fileFrame[ id ].on( 'select', function() {
				let attachment = component.fileFrame[ id ].state().get( 'selection' ).first().toJSON();

				// Set input value.
				component.imgIdInput.val( attachment.id );
				component.imgContainer.html( '<img src="' + attachment.url + '" style="max-width: 100%;" />' );
				component.removeButton.removeClass( 'hidden' );

			} );

			// Finally, open the modal
			component.fileFrame[ id ].open();

		} );

		component.removeButton.on( 'click', function( event ) {
			event.preventDefault();
			component.imgIdInput.val( '' );
			component.imgContainer.html( '' );
			component.removeButton.addClass( 'hidden' );

		} );
	};

	/**
	 * Set up events when adding new term.
	 */
	component.setupAddTerm = function() {
		component.saveNewTermButton.on( 'click', function() {

			if ( ! validateForm( $( this ).parents( 'form' ) ) ) {
				return;
			}

			// Wait for ajax save stopping.
			$( document ).ajaxStop( function() {
				if ( 0 === $( '#ajax-response .error' ).length ) {
					component.imgIdInput.val( '' );
					component.imgContainer.html( '' );
					component.removeButton.addClass( 'hidden' );
					$( '.location-is-featured-wrap input[type="checkbox"]' ).prop( 'checked', false );
				}
			} );
		} );
	};

	$( document ).ready( function() {
		component.init();
	} );

})( jQuery );
