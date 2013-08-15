var IDE = new function() {
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
			
			$('#info-overlay').html('Salvando...').fadeIn();

			$.ajax({
			  type: 'POST',
			  url: 'ajax-code.php',
			  dataType: 'json',
			  data: $('#formCode').serialize()
			})
			.done(function( msg ) {
				$('#info-overlay').html('Ok, salvo!').delay(1000).fadeOut();
			})
			.fail(function(jqXHR, textStatus) {
				$('#info-overlay').html('Oops, não salvou!').delay(1000).fadeOut();
			});
		}
	};
	
	this.init = function() {
		setInterval(autoSaveCode, 5000);
	};
	
	this.onCodingKeyEvent = function(editor, e) {
		if(e.type == "keydown") {
			mAutoSaveDirty = true;
			$('#btn-save').html('[B*]');
		}
		
		editor.save();
	};
	
	this.build = function() {
		$('#build-info').attr('class', 'alert alert-warning').html('Salvando... <img src="./ajax-loader.gif" title="Loading" align="absmiddle">').fadeIn();

		$.ajax({
		  type: 'POST',
		  url: 'ajax-code.php',
		  dataType: 'json',
		  data: {'programId': $('#formCode input[name=programId]').val(), 'action': 'build' }
		})
		.done(function( msg ) {
			$('#build-info').attr('class', 'alert alert-success').html('Salvo no arquivo <code>'+msg.file+'</code> na pasta <code>'+msg.path+'</code>');
			$('#btn-save').html('[B]');
		})
		.fail(function(jqXHR, textStatus) {
			$('#build-info').attr('class', 'alert alert-error').html('<strong>Oops!</strong> Algum erro aconteceu. Tente novamente.');
		});
	};
	
	this.openTerminal = function(theUrl) {
		window.open(theUrl, '_blank', 'toolbar=0,location=0,menubar=0,width=600,height=400');
	};
};

$(IDE.init);