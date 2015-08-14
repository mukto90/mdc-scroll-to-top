<?php
/*
Plugin Name: MDC Scroll To Top
Author: Nazmul Ahsan
Description: MDC Scroll To Top adds a 'Scroll To Top' button to your WordPress site. It includes around a hundred built-in icons. You can select any of them or add your own icon also.
Author URI: http://mukto.medhabi.com
Plugin URI: https://wordpress.org/plugins/mdc-scroll-to-top/
Version: 1.1
*/
function mdc_scroll_to_top(){
$method = get_option('mdc_select_method');
if($method == "preset"){
	$icon = plugin_dir_url(__FILE__).'images/'.get_option('mdc_icon_name');
}
elseif($method == "uploaded"){
	$icon = get_option('mdc_icon_url');
}
?>
<script>
var scrolltotop={
    //startline: Integer. Number of pixels from top of doc scrollbar is scrolled before showing control
    //scrollto: Keyword (Integer, or "Scroll_to_Element_ID"). How far to scroll document up when control is clicked on (0=top).
    setting: {startline:100, scrollto: 0, scrollduration:1000, fadeduration:[500, 100]},
    controlHTML: '<img src="<?php echo $icon; ?>" style="max-height: 150px; max-weight: 150px" />', //HTML for control, which is auto wrapped in DIV w/ ID="topcontrol"
    controlattrs: {offsetx:5, offsety:5}, //offset of control relative to right/ bottom of window corner
    anchorkeyword: '#top', //Enter href value of HTML anchors on the page that should also act as "Scroll Up" links
	state: {isvisible:false, shouldvisible:false},
    scrollup:function(){
        if (!this.cssfixedsupport) //if control is positioned using JavaScript
            this.$control.css({opacity:0}) //hide control immediately after clicking it
        var dest=isNaN(this.setting.scrollto)? this.setting.scrollto : parseInt(this.setting.scrollto)
        if (typeof dest=="string" && jQuery('#'+dest).length==1) //check element set by string exists
            dest=jQuery('#'+dest).offset().top
        else
            dest=0
        this.$body.animate({scrollTop: dest}, this.setting.scrollduration);
    },
    keepfixed:function(){
        var $window=jQuery(window)
        var controlx=$window.scrollLeft() + $window.width() - this.$control.width() - this.controlattrs.offsetx
        var controly=$window.scrollTop() + $window.height() - this.$control.height() - this.controlattrs.offsety
        this.$control.css({left:controlx+'px', top:controly+'px'})
    },
    togglecontrol:function(){
        var scrolltop=jQuery(window).scrollTop()
        if (!this.cssfixedsupport)
            this.keepfixed()
        this.state.shouldvisible=(scrolltop>=this.setting.startline)? true : false
        if (this.state.shouldvisible && !this.state.isvisible){
            this.$control.stop().animate({opacity:1}, this.setting.fadeduration[0])
            this.state.isvisible=true
        }
        else if (this.state.shouldvisible==false && this.state.isvisible){
            this.$control.stop().animate({opacity:0}, this.setting.fadeduration[1])
            this.state.isvisible=false
        }
    },
    init:function(){
        jQuery(document).ready(function($){
            var mainobj=scrolltotop
            var iebrws=document.all
            mainobj.cssfixedsupport=!iebrws || iebrws && document.compatMode=="CSS1Compat" && window.XMLHttpRequest //not IE or IE7+ browsers in standards mode
            mainobj.$body=(window.opera)? (document.compatMode=="CSS1Compat"? $('html') : $('body')) : $('html,body')
            mainobj.$control=$('<div id="topcontrol">'+mainobj.controlHTML+'</div>')
                .css({position:mainobj.cssfixedsupport? 'fixed' : 'absolute', bottom:mainobj.controlattrs.offsety, right:mainobj.controlattrs.offsetx, opacity:0, cursor:'pointer'})
                .attr({title:'Scroll to Top'})
                .click(function(){mainobj.scrollup(); return false})
                .appendTo('body')
            if (document.all && !window.XMLHttpRequest && mainobj.$control.text()!='') //loose check for IE6 and below, plus whether control contains any text
                mainobj.$control.css({width:mainobj.$control.width()}) //IE6- seems to require an explicit width on a DIV containing text
            mainobj.togglecontrol()

			$('a[href="' + mainobj.anchorkeyword +'"]').click(function(){
                mainobj.scrollup()
                return false
            })
            $(window).bind('scroll resize', function(e){
                mainobj.togglecontrol()
            })
        })
    }
}
scrolltotop.init()
</script>
<?php
}
add_action('wp_head', 'mdc_scroll_to_top');
add_action('admin_head', 'mdc_scroll_to_top');


function mdc_admin_scripts() {
	wp_enqueue_style( 'mdc-admin', plugin_dir_url(__FILE__)."css/admin-css.css" );
	wp_enqueue_script( 'mdc-admin', plugin_dir_url(__FILE__) . 'js/admin-js.js', array(), '1.0.0', true );
}
add_action( 'admin_enqueue_scripts', 'mdc_admin_scripts' );

function mdc_scroll_to_top_option_page(){
	add_menu_page( 'MDC Scroll To Top', 'Scroll To Top', 'administrator', 'scroll-to-top', 'mdc_scroll_to_top_option_page_content', plugin_dir_url(__FILE__).'images/menu-icon.png', 61.56 );
}
add_action('admin_menu', 'mdc_scroll_to_top_option_page');

function mdc_scroll_to_top_option_page_content(){
$selected = get_option('mdc_icon_name');
$uploaded = get_option('mdc_icon_url');
$medhod = get_option('mdc_select_method');
?>
	<div class="wrap">
		<h2>MDC Scroll To Top</h2>
		<form action="" method="POST">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							<label for="select-an-image">Choose an Icon</label>
						</th>
						<td>
							<div class="select-method">
								<input type="radio" name="mdc_select_method" value="preset" class="mdc_preset" id="mdc_preset" <?php if("preset" == $medhod){echo "checked";}?> /><label for="mdc_preset">Use From Preset Icons</label>
								<input type="radio" name="mdc_select_method" value="uploaded" class="mdc_upload" id="mdc_upload" <?php if("uploaded" == $medhod){echo "checked";}?> /><label for="mdc_upload">Upload an Icon</label>
							</div>
							<div class="upload-an-image mdc-img-blk" style="display: <?php if(get_option('mdc_select_method') != "uploaded"){echo 'none';}else{echo 'block';}?>">
								<label for="upload_image">
									<input id="upload_image" type="text" size="64" name="mdc_icon_url" value="<?php if($uploaded != ''){echo $uploaded;} else{ echo "http://";} ?>" />
									<input id="upload_image_button" class="button" type="button" value="Upload Image" />
									<br />Enter a URL or upload an image
								</label>
							</div>
							<div id="select-an-image" class="select-an-image mdc-img-blk" style="display: <?php if(get_option('mdc_select_method') != "preset"){echo 'none';}else{echo 'block';}?>">
							<?php for($i=1;$i<=79;$i++){?>
								<div class="each-scroll-icon-div <?php if($selected == "arrow".$i.".png"){echo "checked";}?>">
									<div class="scroll-icon-img">
										<img src= "<?php echo plugin_dir_url(__FILE__).'images/arrow'.$i.'.png'; ?>" />
									</div>
									<div class="scroll-icon-inpt">
									<input type="radio" name="mdc_icon_name" value="arrow<?php echo $i;?>.png" <?php if("arrow".$i.".png" == $selected){echo "checked";}?> />
									</div>
								</div>
							<?php } ?>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<p class="submit">
								<!--input type="button" value="Preview" class="is_preview button button-primary" /-->
								<input type="submit" value="Save Changes" class="button button-primary" />
							</p>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
<?php
	if($_POST){
		update_option('mdc_select_method', $_POST['mdc_select_method']);
		update_option('mdc_icon_name', $_POST['mdc_icon_name']);
		update_option('mdc_icon_url', $_POST['mdc_icon_url']);
		echo "<script>
			window.location.href= '".get_admin_url()."admin.php?page=scroll-to-top';
		</script>";
	}
}

add_action('admin_enqueue_scripts', 'my_admin_scripts');
 
function my_admin_scripts() {
    if (isset($_GET['page']) && $_GET['page'] == 'scroll-to-top') {
        wp_enqueue_media();
        wp_register_script('mdc-image-uploader', plugin_dir_url(__FILE__) . 'js/admin-js.js', array('jquery'));
        wp_enqueue_script('mdc-image-uploader');
    }
}