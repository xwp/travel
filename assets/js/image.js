/* global wp */

/**
 * JS Functions for extended images in adventure post type.
 */

(function() {
  'use strict';

  jQuery( document ).ready( function( $ ) {

    // Uploading files
    let fileFrame;
    let template = $( '#travel-images-tmpl' ).html();
    jQuery( document ).on( 'click', '.travel-image-select', function( event ) {

      event.preventDefault();

      let title = $( this ).data( 'title' );
      let text = $( this ).data( 'text' );

      // If the media frame already exists, reopen it.
      if ( fileFrame ) {
        // Open frame
        fileFrame.open();
        return;
      }

      // Create the media frame.
      fileFrame = wp.media.frames.fileFrame = wp.media( {
        title: title,
        button: {
          text: text,
        },
        multiple: 'add',
      } );

      fileFrame.on( 'open', function() {
        $( '.travel-images-preview' ).each( function() {
          fileFrame.state().get( 'selection' ).add( new wp.media.attachment( $( this ).data( 'id' ) ) );
        } );
        // Set window to browse tab.
        fileFrame.content.mode('browse');
      } );

      // When an image is selected, run a callback.
      fileFrame.on( 'select', function() {

        let images = fileFrame.state().get( 'selection' );
        let wrapper = $( '#amp-travel-images-wrap' );
        // Clear selection from metabox to use the new selection order.
        wrapper.empty();
        images.each( function( image ) {
          let attachment = image.toJSON();

          if ( ! $( '#travel-image-' + attachment.id ).length ) {

            let url = attachment.url;
            let imageTemplate = template;
            if ( attachment.sizes.medium ) {
              url = attachment.sizes.medium.url;
            }
            imageTemplate = imageTemplate.replace( /\{\{id\}\}/g, attachment.id ).replace( /\{\{url\}\}/g, url );
            wrapper.append( imageTemplate );
          }
        } );

      } );

      // Open the modal.
      fileFrame.open();
    } );

    // Bind, image remove button to remove the image.
    jQuery( document ).on( 'click', '.travel-image-control-remove', function( event ) {
      event.preventDefault();
      let image = $( this ).data( 'target' );
      $( '#' + image ).remove();
    } );

  } );

})( window );