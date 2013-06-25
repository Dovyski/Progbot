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
	
	this.createMarkdownTextarea = function(theTextId) {
		$('a[data-toggle="tab"]').on('shown', function (e) {
			var aActiveTab 	= e.target + '';
			var aOldTab 	= e.relatedTarget + '';
			
			aActiveTab 		= aActiveTab.substr(aActiveTab.lastIndexOf('#'));
			aOldTab 		= aOldTab.substr(aOldTab.lastIndexOf('#'));
			
			if(aActiveTab.indexOf('view-markdown') != -1) {
				$(aActiveTab).html('<img src="./img/ajax-loader.gif" title="Loading" align="absmiddle"> Loading...');

				$.ajax({
				  type: 'POST',
				  url: 'ajax-markdown.php',
				  data: {'text': $('#' + theTextId).val() }
				})
				.done(function( msg ) {
					$(aActiveTab).html(msg);
				})
				.fail(function(jqXHR, textStatus) {
					$(aActiveTab).html('Oops, algum erro aconteceu. Desculpe =/');
				});
			}
		});
	};
};