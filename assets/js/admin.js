$ = new jQuery.noConflict();
$(document).ready(function(){
	$("#mdc_scroll_to_top_icon table tr:last-child td fieldset label input:checked").parent().addClass('icon-choosen');
	$("#mdc_scroll_to_top_icon table tr:last-child td fieldset label").click(function(){
		$("#mdc_scroll_to_top_icon table tr:last-child td fieldset label").removeClass('icon-choosen')
		$(this).addClass('icon-choosen');
	})
})