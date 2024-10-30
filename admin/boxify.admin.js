/* jQuery Action for Boxify's Admin Section
 * Written by : Nimrod Tsabari | omniWP
 * @ 07.08.2012
 */

jQuery(function($) {
	
	var box_spacing = $('input#box_spacing').val().trim();
	var padding = $('input#padding').val().trim();
	var bg_col = $('input#background_color').val();
	var bg_op = $('input#background_opacity').val()/100;
	var bor_style = $('#border_style').val();
	var bor_wid = $('input#border_width').val().trim();
	var bor_col = $('input#border_color').val().trim();
	var bor_rad = $('input#border_radius').val().trim();
	var height = $('input#height').val().trim();
	var width = $('input#width').val().trim();
	var boxText = $('textarea#box_text').val();
	var textColor = $('input#text_color').val();

	$('.boxify').
		css('width',width + 'px');

	$('.boxify-container').
		css('padding',padding + 'px').
		css('margin',box_spacing + 'px').
		css('borderWidth',bor_wid + 'px').
		css('borderStyle',bor_style).
		css('borderColor',bor_col).
		css('borderRadius',bor_rad + 'px').
		css('height',height + 'px').
		css('color',textColor).
		text(boxText);
		
	$('.boxify-background').
		css('borderRadius',bor_rad + 'px').
		css('margin',box_spacing + 'px').
		css('backgroundColor',bg_col).
		css('opacity',bg_op);

	var shortcode = '[boxify box_spacing = "' +
			box_spacing + '" padding = "' +
			padding + '" background_color = "' +
			bg_col + '" background_opacity = "' + 
			bg_op*100 + '" border_width = "' +
			bor_wid + '" border_color = "' + 
			bor_col + '" radius = "' +
			bor_rad + '" border_style = "' +  
			bor_style + '" height = "' +
			height + '"]Add Text Here[/boxify]'; 
		
	$('.shortcode').text(shortcode);

	$('input').blur(function() {
		var box_spacing = $('input#box_spacing').val().trim();
		var padding = $('input#padding').val().trim();
		var bg_col = $('input#background_color').val();
		var bg_op = $('input#background_opacity').val()/100;
		var bor_style = $('#border_style').val();
		var bor_wid = $('input#border_width').val().trim();
		var bor_col = $('input#border_color').val();
		var bor_rad = $('input#border_radius').val().trim();
		var height = $('input#height').val().trim();
		var width = $('input#width').val().trim();
		var boxText = $('textarea#box_text').val();
		var textColor = $('input#text_color').val();
		
		if (height === '') height = 'auto';

		$('.boxify').
			css('width',width + 'px');

		$('.boxify-container').
			css('padding',padding + 'px').
			css('margin',box_spacing + 'px').
			css('borderWidth',bor_wid + 'px').
			css('borderStyle',bor_style).
			css('borderColor',bor_col).
			css('borderRadius',bor_rad + 'px').
			css('height',height + 'px').
			css('color',textColor).
			text(boxText);

		$('.boxify-background').
			css('borderRadius',bor_rad + 'px').
			css('margin',box_spacing + 'px').
			css('backgroundColor',bg_col).
			css('opacity',bg_op);

		var shortcode = '[boxify box_spacing = "' +
				box_spacing + '" padding = "' +
				padding + '" background_color = "' +
				bg_col + '" background_opacity = "' + 
				bg_op*100 + '" border_width = "' +
				bor_wid + '" border_color = "' + 
				bor_col + '" border_radius = "' +
				bor_rad + '" border_style = "' +  
				bor_style + '" height = "' +
				height + '"]Add Text Here[/boxify]'; 
			
		$('.shortcode').text(shortcode);
	});
});