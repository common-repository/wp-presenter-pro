jQuery( function( $ ) {
	// Handle on click per gradient.
	$( '#wppp-gradients' ).on( 'click', '.wppp-gradient', function( e ) {
		e.preventDefault();
		$button = $( this );
		if ( $button.hasClass( 'unchecked' ) ) {
			$button.removeClass( 'unchecked' ).addClass( 'checked' );
		} else {
			$button.removeClass( 'checked' ).addClass( 'unchecked' );
		}
	} );
	// Handle select all anchor.
	$( '#wppp-gradients' ).on( 'click', '#wppp-gradient-select-all', function( e ) {
		e.preventDefault();
		$( '.wppp-gradient' ).removeClass( 'unchecked' ).addClass( 'checked' );
	} );
	// Handle deselect all anchor.
	$( '#wppp-gradients' ).on( 'click', '#wppp-gradient-deselect-all', function( e ) {
		e.preventDefault();
		$( '.wppp-gradient' ).removeClass( 'checked' ).addClass( 'unchecked' );
	} );
	// Handle submit handler.
	$( '#wppp-gradients-form' ).on( 'submit', function( e ) {
		e.preventDefault();
		var $submit_button = $( '#wppp-save-gradients' );
		$submit_button.val( wp_presenter_gradients.saving ).prop( 'disabled', 'disabled' );
		var selected = {};
		$('#wppp-gradients .checked' ).each( function() {
			var $button = $( this );
			selected[ $button.data( 'title' ) ] = {
				name: $button.data( 'name' ),
				gradient: $button.data( 'style' )
			};
		} );
		$.post(
			ajaxurl,
			{
				action: 'wppp_save_gradients',
				gradients: selected,
				nonce: $('#wppp_ajax_gradients_nonce').val()
			},
			function( response ) {
				$submit_button.val( wp_presenter_gradients.saved ).removeAttr( 'disabled' );
			}
		);
	} );
} );