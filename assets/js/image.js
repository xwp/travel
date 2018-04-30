/* global wp */

/**
 * JS Functions for extended images in adventure post type.
 */

(function() {
  'use strict';

  jQuery( document ).ready( function( $ ) {

    // Uploading files
    let file_frame;
    let template = $( '#travel-images-tmpl' ).html();
    jQuery( document ).on( 'click', '.travel-image-select', function( event ) {

      event.preventDefault();

      let title = $( this ).data( 'title' );
      let text = $( this ).data( 'text' );

      // If the media frame already exists, reopen it.
      if ( file_frame ) {
        // Open frame
        file_frame.open();
        return;
      }

      // Create the media frame.
      file_frame = wp.media.frames.file_frame = wp.media( {
        title: title,
        button: {
          text: text,
        },
        multiple: true,
      } );

      // When an image is selected, run a callback.
      file_frame.on( 'select', function() {

        let images = file_frame.state().get( 'selection' );
        let wrapper = $( '#amp-travel-images-wrap' );

        images.each( function( image ) {
          let attachment = image.toJSON();

          if ( !$( '#travel-image-' + attachment.id ).length ) {

            let url = attachment.url;
            let image_template = template;
            if ( attachment.sizes.medium ) {
              url = attachment.sizes.medium.url;
            }
            image_template = image_template.replace( /\{\{id\}\}/g, attachment.id ).replace( /\{\{url\}\}/g, url );
            wrapper.append( image_template );
          }
        } );

      } );

      // Finally, open the modal
      file_frame.open();
    } );
    jQuery( document ).on( 'click', '.travel-image-control-remove', function( event ) {
      event.preventDefault();
      let image = $( this ).data( 'target' );
      $( '#' + image ).remove();
    } );

  } );

})( window );