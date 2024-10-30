tinyMCEPopup.requireLangPack();

var BoxifyDialog = {
	init : function() {
		var f = document.forms[0];

		// Get the selected contents as text and place it in the input
		f.cols.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.cols_use.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.position.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.order.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.box_spacing.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.padding.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.background_color.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.background_opacity.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.border_width.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.border_color.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.border_style.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.border_radius.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.height.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.width.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.boxify_class.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.icon.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.icon_position.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.boxify_import.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.import_name.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.import_post.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
	},

	insert : function() {
		// Insert the contents from the input into the document
		var f = document.forms[0];
		var s = ' ';
		var t0 = ' ="';
		var t1 = '" ';
		var begin = '[boxify ';
		var end = '[/boxify]';
		var param = '';
		
		for(i=0; i<f.elements.length; i++) {
			if (f.elements[i].type != 'button') {
				if (f.elements[i].value !== '') {
					param += s + f.elements[i].id + t0 + f.elements[i].value + t1;
				}
			}
		}

		var shortcode = begin + param + ']Add Your Content Here' + end;

		tinyMCEPopup.editor.execCommand('mceInsertContent', false, shortcode);
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add(BoxifyDialog.init, BoxifyDialog);
