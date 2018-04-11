jQuery( function ( $ ) {

	let fileFrame = [],
		uploadButton = $( '#location-cover-image' ),
		removeButton = $( '#location-cover-image-remove' ),
		imgContainer = $( '#location-cover-image-preview' ),
		imgIdInput = $( '#location-cover-image-value' );

	uploadButton.on( 'click', function ( event ) {

		event.preventDefault();

		let self = $( this ),
			id = self.attr( 'id' );

		// If the media frame already exists, reopen it.
		if ( fileFrame[ id ] ) {
			fileFrame[ id ].open();

			return;
		}

		// Create the media frame.
		fileFrame[ id ] = wp.media.frames.fileFrame = wp.media( {
			title: self.data( 'uploader_title' ),
			button: {
				text: self.data( 'uploader_button_text' )
			},
			multiple: false
		} );

		// When an image is selected, run a callback.
		fileFrame[ id ].on( 'select', function() {
			let attachment = fileFrame[ id ].state().get( 'selection' ).first().toJSON();

			// Set input value.
			imgIdInput.val( attachment.id );
			imgContainer.html( '<img src="' + attachment.url + '" style="max-width: 100%;" />' );

		} );

		// Finally, open the modal
		fileFrame[ id ].open();

	} );

	removeButton.on( 'click', function( event ) {

		event.preventDefault();
		imgIdInput.val( '' );
		imgContainer.html( '' );

	} );

} );
