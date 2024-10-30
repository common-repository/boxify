<?php  
/* 
Plugin Name: Boxify 
Plugin URI: http://omniwp.com/plugins/boxify-a-wordpress-plugin/ 
Description: Boxify Lets you organize your post/page content in highly modular boxes.
Version: 2.3
Author: Nimrod Tsabari
Author URI: http://omniwp.com
*/  
/*  Copyright 2012  Nimrod Tsabari / omniWP (email : yo@omniwp.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/?>
<?php

define('BOXIFY_VER', '2.3');
define('BOXIFY_DIR', plugin_dir_url( __FILE__ ));

/* Activation */
/* ---------- */

define('BOXIFY_NAME', 'Boxify');
define('BOXIFY_SLUG', 'boxify');

register_activation_hook(__file__,'omni_boxify_admin_activate');
add_action('admin_notices', 'omni_boxify_admin_notices');	

function omni_boxify_admin_activate() {
	$reason = get_option('omni_plugin_reason');
	if ($reason == 'nothanks') { 
		update_option('omni_plugin_on_list',0);
	} else {		
		add_option('omni_plugin_on_list',0);
		add_option('omni_plugin_reason','');
	}
}

function omni_boxify_admin_notices() {
	if ( get_option('omni_plugin_on_list') < 2 ){		
		echo "<div class='updated'><p>" . sprintf(__('<a href="%s">' . BOXIFY_NAME . '</a> needs your attention.'), "options-general.php?page=" . BOXIFY_SLUG). "</p></div>";
	}
} 

/* Boxify : Init */
/* ------------- */

function init_boxify() {

	wp_register_style('boxify-style', BOXIFY_DIR . 'css/boxify.css');
	wp_enqueue_style('boxify-style');
}

add_action('wp_enqueue_scripts', 'init_boxify');

function boxify_admin_load_scripts() {
 if(isset($_GET['page']) && $_GET['page']=='boxify'){
		wp_register_style('boxify_admin_css', BOXIFY_DIR . '/admin/boxify.admin.css', false, '1.0.0' );	    
		wp_register_script('boxify_admin_js', BOXIFY_DIR . '/admin/boxify.admin.js', false, '1.0.0' );
        wp_enqueue_style('boxify_admin_css');
        wp_enqueue_script('boxify_admin_js');
 }
}

add_action('admin_enqueue_scripts', 'boxify_admin_load_scripts');


/*  Boxify : Admin Part  */
/* --------------------- */
/* Inspired by Purwedi Kurniawan's SEO Searchterms Tagging 2 Pluging */

function boxify_admin() {
	if (omni_boxify_list_status()) include('admin/boxify.admin.php');
}            

function boxify_admin_init() {
	add_options_page("Boxify", "Boxify", 1, "boxify", "boxify_admin");
}

add_action('admin_menu', 'boxify_admin_init');

function omni_boxify_list_status() {
	$onlist = get_option('omni_plugin_on_list');
	$reason = get_option('omni_plugin_reason');
	if ( trim($_GET['onlist']) == 1 || $_GET['no'] == 1 ) { 			
		$onlist = 2;
		if ($_GET['onlist'] == 1) update_option('omni_plugin_reason','onlist');
		if ($_GET['no'] == 1) {
			 if ($reason != 'onlist') update_option('omni_plugin_reason','nothanks');
		}
		update_option('omni_plugin_on_list', $onlist);
	} 
	if ( ((trim($_GET['activate']) != '' && trim($_GET['from']) != '') || trim($_GET['activate_again']) != '') && $onlist != 2 ) { 
		update_option('omni_plugin_list_name', $_GET['name']);
		update_option('omni_plugin_list_email', $_GET['from']);
		$onlist = 1;
		update_option('omni_plugin_on_list', $onlist);
	}
	if ($onlist == '0') {
		omni_boxify_register_form_1('boxify_registration');
	} elseif ($onlist == '1') {
		$name = get_option('omni_plugin_list_name');
		$email = get_option('omni_plugin_list_email');
		omni_boxify_do_list_form_2('boxify_confirm',$name,$email);
	} elseif ($onlist == '2') {
		return true;
	}
}

function omni_boxify_register_form_1($fname) {
	global $current_user;
	get_currentuserinfo();
	$name = $current_user->user_firstname;
	$email = $current_user->user_email;
?>
	<div class="register" style="width:50%; margin: 100px auto; border: 1px solid #BBB; padding: 20px;outline-offset: 2px;outline: 1px dashed #eee;box-shadow: 0 0 10px 2px #bbb;">
		<p class="box-title" style="margin: -20px; background: #489; padding: 20px; margin-bottom: 20px; border-bottom: 3px solid #267; color: #EEE; font-size: 30px; text-shadow: 1px 2px #267;">
			Please register the plugin...
		</p>
		<p>Registration is <strong style="font-size: 1.1em;">Free</strong> and only has to be done <strong style="font-size: 1.1em;">once</strong>. If you've register before or don't want to register, just click the "No Thank You!" button and you'll redirected to the Plugin's Page.</p>
		<p>In addition, you'll receive a complimentary subscription to our Email Newsletter which will give you a wealth of tips and advice on Blogging and Wordpress. Of course, you can unsubscribe anytime you want.</p>
		<p><?php omni_boxify_registration_form($fname,$name,$email);?></p>
		<p style="background: #F8F8F8; border: 1px dotted #ddd; padding: 10px; border-radius: 5px; margin-top: 20px;"><strong>Disclaimer:</strong> Your contact information will be handled with the strictest of confidence and will never be sold or shared with anyone.</p>
	</div>	
<?php
}

function omni_boxify_registration_form($fname,$uname,$uemail,$btn='Register',$hide=0, $activate_again='') {
	$wp_url = get_bloginfo('wpurl');
	$wp_url = (strpos($wp_url,'http://') === false) ? get_bloginfo('siteurl') : $wp_url;
	$thankyou_url = $wp_url.'/wp-admin/options-general.php?page='.$_GET['page'];
	$onlist_url   = $wp_url.'/wp-admin/options-general.php?page='.$_GET['page'].'&amp;onlist=1';
	$nothankyou_url   = $wp_url.'/wp-admin/options-general.php?page='.$_GET['page'].'&amp;no=1';
	?>
	
	<?php if ( $activate_again != 1 ) { ?>
	<script><!--
	function trim(str){ return str.replace(/(^\s+|\s+$)/g, ''); }
	function imo_validate_form() {
		var name = document.<?php echo $fname;?>.name;
		var email = document.<?php echo $fname;?>.from;
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		var err = ''
		if ( trim(name.value) == '' )
			err += '- Name Required\n';
		if ( reg.test(email.value) == false )
			err += '- Valid Email Required\n';
		if ( err != '' ) {
			alert(err);
			return false;
		}
		return true;
	}
	//-->
	</script>
	<?php } ?>
	<form name="<?php echo $fname;?>" method="post" action="http://www.aweber.com/scripts/addlead.pl" <?php if($activate_again!=1){;?>onsubmit="return imo_validate_form();"<?php }?> style="text-align:center;" >
		<input type="hidden" name="meta_web_form_id" value="1222167085" />	<!-- I CHANGED THIS -->
		<input type="hidden" name="listname" value="omniwp_plugins" />  <!-- I CHANGED THIS -->
		<input type="hidden" name="redirect" value="<?php echo $thankyou_url;?>">
		<input type="hidden" name="meta_redirect_onlist" value="<?php echo $onlist_url;?>">
		<input type="hidden" name="meta_adtracking" value="omniwp_plugins_adtracking" />  <!-- I CHANGED THIS -->
		<input type="hidden" name="meta_message" value="1">
		<input type="hidden" name="meta_required" value="from,name">
		<input type="hidden" name="meta_forward_vars" value="1">	
		 <?php if ( $activate_again == 1 ) { ?> 	
		 <input type="hidden" name="activate_again" value="1">
		 <?php } ?>		 
		<?php if ( $hide == 1 ) { ?> 
			<input type="hidden" name="name" value="<?php echo $uname;?>">
			<input type="hidden" name="from" value="<?php echo $uemail;?>">
		<?php } else { ?>
			<p>Name: </td><td><input type="text" name="name" value="<?php echo $uname;?>" size="25" maxlength="150" />
			<br />Email: </td><td><input type="text" name="from" value="<?php echo $uemail;?>" size="25" maxlength="150" /></p>
		<?php } ?>
		<input class="button-primary" type="submit" name="activate" value="<?php echo $btn; ?>" style="font-size: 14px !important; padding: 5px 20px;" />
	</form>
    <form name="nothankyou" method="post" action="<?php echo $nothankyou_url;?>" style="text-align:center;">
	    <input class="button" type="submit" name="nothankyou" value="No Thank You!" />
    </form>
	<?php
}

function omni_boxify_do_list_form_2($fname,$uname,$uemail) {
	$msg = 'You have not clicked on the confirmation link yet. A confirmation email has been sent to you again. Please check your email and click on the confirmation link to register the plugin.';
	if ( trim($_GET['activate_again']) != '' && $msg != '' ) {
		echo '<div id="message" class="updated fade"><p><strong>'.$msg.'</strong></p></div>';
	}
	?>
	<div class="register" style="width:50%; margin: 100px auto; border: 1px dotted #bbb; padding: 20px;">
		<p class="box-title" style="margin: -20px; background: #489; padding: 20px; margin-bottom: 20px; border-bottom: 3px solid #267; color: #EEE; font-size: 30px; text-shadow: 1px 2px #267;">Almost Done....</p>
		<p>A confirmation email has been sent to your email "<?php echo $uemail;?>". You must click on the confirmation link inside the email to register the plugin.</p>
		<p>Click on the button below to Verify and Activate the plugin.</p>
		<p><?php omni_boxify_registration_form($fname.'_0',$uname,$uemail,'Verify and Activate',1,1);?></p>
		<p>Disclaimer: Your contact information will be handled with the strictest confidence and will never be sold or shared with third parties.</p>
	</div>	
	<?php
}

/* Adding TinyMCE Button */
/* --------------------- */

add_filter('mce_external_plugins', "boxify_register");
add_filter('mce_buttons', 'boxify_add_button', 0);
function boxify_add_button($buttons){
	array_push($buttons, "|", "boxifyplugin");
	return $buttons;
}
function boxify_register($plugin_array){
	$url = BOXIFY_DIR . "btn/boxify.button.js";
	$plugin_array['boxifyplugin'] = $url;
	return $plugin_array;
}
function boxify_refresh_mce($ver) {
  $ver += 3;
  return $ver;
}

add_filter( 'tiny_mce_version', 'boxify_refresh_mce');

/*  Boxify : Adding a Custom Field to Attachmetns */
/* ------------------------------------------------ */

function boxify_attachment_fields_to_edit($form_fields, $post) {
	$form_fields["boxify_icon"]["label"] = __("Boxify Icon");
	$form_fields["boxify_icon"]["input"] = "text";
	$form_fields["boxify_icon"]["value"] = get_post_meta($post->ID, "_boxify_icon", true);
  	$form_fields["boxify_icon"]["extra_rows"] = array(  
      "ppaw_style" => "Give the icon an identifier to use in box.");
	return $form_fields;
}

add_filter("attachment_fields_to_edit", "boxify_attachment_fields_to_edit", null, 2);

function boxify_attachment_fields_to_save($post, $attachment) {  
  if(isset($attachment['boxify_icon'])){  
    update_post_meta($post['ID'], '_boxify_icon', $attachment['boxify_icon']);  
  }  
  return $post;  
}  

add_filter('attachment_fields_to_save','boxify_attachment_fields_to_save',null,2);


// Caclculate box width (%)
function calc_prec($cols,$cols_use) {
	if (!is_numeric($cols)) return false;
	if (!is_numeric($cols_use)) return false;
	
	return round(($cols_use / $cols)*100,3) - 0.001;	
} 
// is a number >= 0 
function val_param($param) {
	if ((is_numeric($param)) && ($param >= 0)) return true;
	
	return false;
}

function val_num_limit($param, $min, $max) {
	$number = intval($param,10);

	return (($number) && ($number <= $max) && ($number >= $main));
}
// Generate Spacing (margin/padding)  
function gen_box_spacing($spacing, $attr = '') {
	$spacings = explode(' ',$spacing);
	$output = '';
	if (in_array(count($spacings),array(1,2,3,4))) {
			$output .= $attr . ':';	
			foreach ($spacings as $val) {
				$val = trim($val);
				if (!is_numeric($val) && ($val != 'auto')) return '';
				if ($val === 'auto') {
					$output .= 'auto ';
				} else {
					$output .= $val . 'px ';
				}
			}
			$output .= '; ';
	}

	return $output;
}
// generate background-position  
function gen_box_icon_position($position) {
	$poss = explode(' ',$position);
	$output = '';
	if (in_array(count($poss),array(2))) {
			$output .= 'background-position:';	
			foreach ($poss as $val) {
				$val = trim($val);
				if (!is_numeric($val)) return '';
				$output .= $val . 'px ';
			}
			$output .= '; ';
	}

	return $output;
}
// generate icon src
function gen_box_icon($icon) {
	global $post;
	$pid = $post->ID;

	$args = array(
       'post_type' => 'attachment',
       'post_mime_type' => 'image',
       'numberposts' => -1,
       'post_status' => null,
       'post_parent' => $pid
      );
  
    $atts = get_posts($args);
	
	$output = '';
	if ($atts) {
		foreach ($atts as $att) {
			$aid = $att->ID;
	        $agate  = trim(get_post_meta($aid,'_boxify_icon',true));
			
			if ($agate === $icon) {
				$asrc = wp_get_attachment_image_src($aid,'full');
				$output .= "background-image: url('" . esc_url($asrc[0]) . "'); background-repeat: no-repeat; ";
			}
		}
	}
	
	return $output;
}

function remove_p($content) {
	if (strpos($content,'</p>') === 0) $content = substr($content, 4);
	return $content;
}

function save_custom_field($pid,$cfname,$content) {
	update_post_meta($pid, $cfname, $content);
}

//shortcode  
function set_boxify($atts,$content=null) {
	extract(shortcode_atts(array(
      'title'   	=> '',
      'position'	=> 'none',
      'order'		=> '',
      'class'		=> '',
      'box_spacing' => '0',
   	  'title_strip'	=> 'no',
	  'padding'		=> 0,
	  'radius'		=> 0,
	  'border_color' => 'black',
	  'border_width' => 0,
	  'border_style' => 'solid',
	  'background_color'	=> 'transparent',
	  'background_opacity'	=> '100',
	  'cols'		=> 3, 
	  'cols_use'	=> 1,
	  'height'		=> '',
	  'icon'		=> '',
	  'icon_position'	=> '0 0',
	  'import'		=> '', // 'full', 'content'
	  'import_post'	=> '',
	  'import_name'	=> '',
	  'export_name'	=> '',
	  'theme'		=> ''
      ), $atts));

	global $post; 
	$pid = $post->ID;
	
	$code = '';

	$box_style = '';
	$box_class = '';

	$wrap_style = '';
	$wrap_class = '';

	$bg_style = '';
	$bg_class = '';

	$mod_class = '';
	$theme = trim(strtolower($theme));
	$mod_class = ($theme == '' ? '' : 'boxify-theme-' . $theme);

	/* First/Last box in a row */
    $order = trim($order);
	$order_code = '<div style="clear:both"></div>';  
	if ($order == 'first') $code .= $order_code;

	/* Classes */
    $class  = ' ' . trim($class);
	$master_class = 'boxify';
    $box_class	= $master_class . $class;
	if ($mod_class !== '') $box_class .=  ' ' . $mod_class .'-box';
	
	$wrap_class = $master_class . '-container';
	if ($mod_class !== '') $wrap_class .=  ' ' . $mod_class .'-container';
	$bg_class = $master_class . '-background';
	if ($mod_class !== '') $bg_class .= ' ' . $mod_class .'-background'; 
	
	/* Box Styles */
    $cols = trim($cols);  
    $cols_use = trim($cols_use);
    $width = calc_prec($cols,$cols_use);  
	$box_style .= 'width:' . $width . '%; ';
	
	if (val_param(trim($height))) $wrap_style .= 'height:' . trim($height) . 'px; ';
	
	$acc_float = array('none','left','right');
	$float = (in_array(trim(strtolower($position)), $acc_float) ? $position : 'none');
	$box_style .= 'float:' . $float . '; '; 
	
	$border_width = (val_param(trim($border_width)) ? trim($border_width) : 0);
	$border_color = trim(strtolower($border_color));
	$border_style = trim(strtolower($border_style));
	$wrap_style .= 'border: ' . $border_width . 'px ' . $border_style . ' ' . $border_color . '; ';
	
	$radius = (val_param(trim($radius)) ? trim($radius) : 0);
	$wrap_style .= 'border-radius: ' . $radius . 'px; -moz-border-radius: ' . $radius . 'px; -webkit-border-radius: ' . $radius . 'px; ';
	$bg_style .= 'border-radius: ' . $radius . 'px; -moz-border-radius: ' . $radius . 'px; -webkit-border-radius: ' . $radius . 'px; ';	
	
	if ($float === 'none') {
		$box_style .= gen_box_spacing(trim($box_spacing),'margin');
	} else {
		$wrap_style .= gen_box_spacing(trim($box_spacing),'margin');
		$bg_style .= gen_box_spacing(trim($box_spacing),'margin');
	}

	//$padding = (val_param(trim($padding)) ? trim($padding) : 0);
	$wrap_style .= gen_box_spacing(trim($padding),'padding');
	
	$background_color = trim(strtolower($background_color));
	$bg_style .= 'background-color:' . $background_color . '; ';

	$background_opacity = trim($background_opacity); 
	if (val_num_limit($background_opacity, 0, 100)) {
		$bg_style .= 'opacity:' . $background_opacity/100 . '; ';
	}
	
	$icon = trim($icon);
	$icon_position = trim($icon_position);
	if ($icon != '') $wrap_style .= gen_box_icon($icon) . gen_box_icon_position($icon_position);
	
	if ($float == "none") $code .= '<div class="boxify-clearfix"></div>';
	$code .= '<div class="'. $box_class .'" style="' . $box_style . '">';
    $code .= '<div class="'. $bg_class .'" style="' . $bg_style . '"></div>';
    $code .= '<div class="'. $wrap_class .'" style="' . $wrap_style . '">';
	      
    $title = trim($title);
	
	$pless = remove_p($content);
	
	$content_wrap = $code;
	
	$code .= do_shortcode($pless);

	/* Closing Code */
	$code .= '</div></div>' . $last_code;

	if ($order == 'last') $code .= $order_code;

	/* exporting a box */
	$export_name = sanitize_title(trim(strtolower($export_name)));
	
	if ($export_name !== '') {
		$cfname_content = '_boxify_export_content_' . $export_name;
		$cfname_full = '_boxify_export_full_' . $export_name;
		save_custom_field($pid, $cfname_full, $code);
		save_custom_field($pid, $cfname_content, do_shortcode($pless));
	}

	/* importing a box */
	$import = trim(strtolower($import));
	$import_post = trim(strtolower($import_post));
	$import_name = sanitize_title(trim(strtolower($import_name)));
	
	if ($import === 'full') {
		$cfname = '_boxify_export_full_' . $import_name;
		$box_import = get_post_meta($import_post, $cfname);
		return $box_import[0];
	} else if ($import === 'content') {
		$cfname = '_boxify_export_content_' . $import_name;
		$box_import = get_post_meta($import_post, $cfname);
		return $content_wrap . $box_import[0] . do_shortcode($content) . '</div></div>';
	} else {
		return $code;	  
	} 

}

add_shortcode( 'boxify', 'set_boxify' );
?>