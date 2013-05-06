/*global EpicEditor */
$(document).ready(function() {
	var opts = {
		basePath: "/ee",
		clientSideStorage: false,
		theme: {
			editor: "/themes/editor/epic-light.css",
			preview: "/themes/preview/coyote.css"
		}
	};
	if ($('#epiceditor').length > 0) {
		var editor = new EpicEditor(opts);
		var realeditor = $('#realeditor');
		editor.load(function() {
			editor.importFile('file', realeditor.val());
		});
		$('#submit').on('click', function() {
			var content = editor.exportFile();
			$('#realeditor').val(content);
		});
	}
});
