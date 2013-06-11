var CODEBOT = new function() {
	var mAutoSaveLast 	= 0;
	var mAutoSaveDirty 	= false;
	
	var showLoading = function() {
	    $('#auraPainelResposta').slideDown();
	    $('#auraPainelResposta').html('<img src="./img/ajax-loader.gif" align="absmiddle" title="Pensando..."/> <small>Pensando...</small>');
	};
	
	var autoSaveCode = function() {
		var aNow = new Date().getTime();
		
		if(aNow - mAutoSaveLast >= 2000 && mAutoSaveDirty) {
			mAutoSaveDirty = false;
			mAutoSaveLast = aNow;

			$.ajax({
			  type: 'POST',
			  url: 'ajax-code.php',
			  dataType: 'json',
			  data: $('#formCode').serialize()
			})
			.done(function( msg ) {
			  console.log( "Data Saved: " + msg );
			  
			})
			.fail(function(jqXHR, textStatus) {
			  console.log( "Request failed: " + textStatus );
			});
		}
	};
	
	this.initAutoSave = function() {
		$('#code').on('keydown', function() {
			mAutoSaveDirty = true;
		});
		
		setInterval(autoSaveCode, 1000);
	}
};