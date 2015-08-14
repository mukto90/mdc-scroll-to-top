mdc = jQuery.noConflict();
mdc(document).ready(function(){
	mdc(".each-scroll-icon-div").click(function(){
		mdc("input", this).prop('checked', true);
	});
	mdc(".each-scroll-icon-div").click(function() {
		if(mdc(".each-scroll-icon-div input").is(':checked')) {
			mdc(".each-scroll-icon-div").removeClass("checked");
			mdc(this).addClass("checked");
		}
	});
	mdc(".iblock.checkbox").click(function(){
		var checkBoxes = mdc("input[type=checkbox]", this);
		checkBoxes.prop("checked", !checkBoxes.prop("checked"));
	});
	mdc(".is_preview").click(function(){
		mdc("#topcontrol").fadeToggle();
	});
	mdc(".mdc_preset").click(function(){
		mdc(".mdc-img-blk").hide();
		mdc(".select-an-image").show();
	});
	mdc(".mdc_upload").click(function(){
		mdc(".mdc-img-blk").hide();
		mdc(".upload-an-image").show();
	});
});

jQuery(document).ready(function($){
    var custom_uploader;
    $('#upload_image_button').click(function(e) {
        e.preventDefault();
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#upload_image').val(attachment.url);
        });
        //Open the uploader dialog
        custom_uploader.open();
    });
});