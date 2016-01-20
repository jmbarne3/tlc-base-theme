var shortcodeInterfaceTool = function($) {
	var $cls                   = shortcodeInterfaceTool;
	$cls.shortcodeForm         = $('#select-shortcode-form');
	$cls.shortcodeButton       = $cls.shortcodeForm.find('button');
	$cls.shortcodeSelect       = $cls.shortcodeForm.find('#shortcode-select');
	$cls.shortcodeEditors      = $cls.shortcodeForm.find('#shortcode-editors');
	$cls.shortcodeDescriptions = $cls.shortcodeForm.find('#shortcode-descriptions');

	$cls.shortcodeInsert = function(shortcode, parameters, enclosingText) {
		console.log(shortcode);
		var text = '[' + shortcode;

		if (parameters) {
			for (var key in parameters) {
				text += " " + key + "=\"" + parameters[key] + "\"";
			}
		}

		text += "]";

		if (enclosingText) {
			text += enclosingText;
		}
		text += "[/" + shortcode + "]";

		send_to_editor(text);
	};

	$cls.shortcodeAction = function() {
		var $selected = $cls.shortcodeSelect.find(':selected');
		if ($selected.length < 1 || $selected.val() === '') { return; }

		var editor = $cls.shortcodeEditors.find('li.shortcode-' + $cls.shortcodeSelected),
				dummyText = $selected.attr('data-enclosing') || null,
				highlightedWysiwigText = tinymce.activeEditor ? tinymce.activeEditor.selection.getContent() : null,
				enclosingText = null;

		if (dummyText && highlightedWysiwigText) {
			enclosingText = highlightedWysiwigText;
		} else {
			enclosingText = dummyText;
		}

		var parameters = {};

		if (editor.length === 1) {
			editor.children().each(function() {
				var $formElement = $(this);
				switch($formElement.prop('tagName')) {
					case 'INPUT':
					case 'TEXTAREA':
					case 'SELECT':
						parameters[$formElement.attr('data-parameter')] = $formElement.val();
						break;
				}
			});
		}

		$cls.shortcodeInsert($selected.val(), parameters, enclosingText);
	};

	$cls.shortcodeSelectAction = function() {
		$cls.shortcodeSelected = $cls.shortcodeSelect.val();
		$cls.shortcodeEditors.find('li').hide();
		$cls.shortcodeDescriptions.find('li').hide();
		$cls.shortcodeEditors.find('.shortcode-' + $cls.shortcodeSelected).show();
		$cls.shortcodeDescriptions.find('.shortcode-' + $cls.shortcodeSelected).show();
	};

	$cls.shortcodeSelectAction();

	$cls.shortcodeSelect.change($cls.shortcodeSelectAction);

	$cls.shortcodeButton.click($cls.shortcodeAction);

};

var initColorPicker = function($) {
	if ($('input[type=color]')) {
		$('input[type=color]').spectrum({
			flat: true,
			showInput: true
		});
	}
};

if (typeof jQuery !== 'undefined') {
	jQuery(document).ready(function($) {
		shortcodeInterfaceTool($);
		initColorPicker($);
	});
}