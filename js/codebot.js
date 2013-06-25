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
	
	this.initCodePage = function(theShouldAutoSave) {
		if(theShouldAutoSave) {
			$('#code').on('keydown', function() {
				mAutoSaveDirty = true;
			});
			
			setInterval(autoSaveCode, 1000);
		}
		
		$('#formReview').on('submit', function() {
			$.ajax({
			  type: 'POST',
			  url: 'ajax-code.php',
			  dataType: 'json',
			  data: $('#formReview').serialize()
			})
			.done(function( msg ) {
				console.log( "Data Saved: " + msg );
				window.location.reload(true);
			})
			.fail(function(jqXHR, textStatus) {
				console.log( "Request failed: " + textStatus );
			});
			
			return false;
		});
	};
	
	this.createMarkdownTextare = function() {
		$('a[data-toggle="tab"]').on('shown', function (e) {
			alert(e.target) // activated tab
			alert(e.relatedTarget) // previous tab
		});
	};
};