( function( $ ) {

    'use strict';


/**
 * Apend table row in Add New Table.
 *
 */

$(document).on("click", ".add_field_button_p" , function(){
    $('.nd-table-data').append('\
            <div class="row">\
            <input type="text" style="width: 15%;display: inline-block;background: #f1f1f1;padding: 5px;height: 33px;border-radius: 2px;" name="nd_p_mytext[][nd_p_image]" id="nd_p_image" value="">\
            <input type="text" style="width: 15%;display: inline-block;background: #f1f1f1;padding: 5px;height: 33px;border-radius: 2px;" name="nd_p_mytext[][nd_p_name]" id="nd_p_name" value="">\
            <input type="text" style="width: 15%;display: inline-block;background: #f1f1f1;padding: 5px;height: 33px;border-radius: 2px;" name="nd_p_mytext[][nd_p_description]" id="nd_p_description" value="">\
            <input type="text" style="width: 15%;display: inline-block;background: #f1f1f1;padding: 5px;height: 33px;border-radius: 2px;" name="nd_p_mytext[][nd_p_shop]" id="nd_p_shop" value="">\
            <span class="delete-field_p button-secondary nd-append-btn" style="text-align: center;background: #f41919;color: #fff;position: relative;display: inline-block;vertical-align: super;font-size: 16px;font-weight: bold;border-radius: 5px;padding: 2px 12px 9px 12px;position: relative;top: 4px;line-height: 20px;">x</span>\
            </div>');
}); 

/**
 * Delete table row.
 *
 */

$('.delete-field_p').on("click", function (e) {
    e.preventDefault();

      var x = confirm("Are you sure you want to delete?");
      if (x){
            $(this).parent('div').remove();
            return true;
      }
      else{
        return false;
      }
});
$(document).on("click", ".nd-append-btn" , function(){

    var x = confirm("Are you sure you want to delete?");
    if (x){
            $(this).parent('div').remove();
            return true;
    }
    else{
        return false;
    }
}); 


/**
 * Image Selection url function
 *
 */

$('body').on('click', '.aw_upload_image_button', function(e){
        e.preventDefault();
  
        var button = $(this),
        aw_uploader = wp.media({
            title: 'Custom image',
            library : {
                uploadedTo : wp.media.view.settings.post.id,
                type : 'image'
            },
            button: {
                text: 'Use this image'
            },
            multiple: false
        }).on('select', function() {
            var attachment = aw_uploader.state().get('selection').first().toJSON();
            $('#aw_custom_image').val(attachment.url);
        })
        .open();
    });


/**
 * Copy Selection url function
 *
 */

$(".nd-copy-text").click(function(){
    $("#aw_custom_image").select();
    document.execCommand('copy');
});
} )( jQuery );