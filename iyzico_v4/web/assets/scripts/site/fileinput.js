$(document).ready(function() {
  var $fileInput = $('.js-file-input');
  var $fileLabel = $('.js-file-label')

  $fileInput.on('change', function(e) {
    this.value = null
    var $fileName = e.target.files[0].name;
    $fileLabel.val($fileName);
  });
});

var inputs = document.querySelectorAll( '.inputfile' );
Array.prototype.forEach.call( inputs, function( input )
{
    var label	 = input.nextElementSibling;
    var labelVal = label.innerHTML;

    input.addEventListener( 'change', function( e )
    {
        var fileName = '';
        if( this.files && this.files.length > 1 )
            fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
        else
            fileName = e.target.value.split( '\\' ).pop();

        if( fileName ) {
            $('#fake-file').data('org-placeholder',$('#fake-file').attr('placeholder'));
            $('#fake-file').attr('placeholder',fileName);
        } else {
            $('#fake-file').attr('placeholder',$('#fake-file').data('org-placeholder'));

        }

    });
    input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
    input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
});