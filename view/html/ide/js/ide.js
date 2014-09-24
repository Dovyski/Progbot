var IDE = new function() {
	var mAutoSaveLast 	= 0;
	var mAutoSaveDirty 	= false;
	
	var showLoading = function() {
	    $('#auraPainelResposta').slideDown();
	    $('#auraPainelResposta').html('<img src="./img/ajax-loader.gif" align="absmiddle" title="Pensando..."/> <small>Pensando...</small>');
	};
	
	var autoSaveCode = function(theForce) {
		var aNow = new Date().getTime();

		if((aNow - mAutoSaveLast >= 2000 && mAutoSaveDirty) || theForce) {
			mAutoSaveDirty = false;
			mAutoSaveLast = aNow;

			$('#info-overlay').html('<i class="fa fa-circle-o-notch fa-spin"></i>').fadeIn();

			$.ajax({
			  type: 'POST',
			  url: 'ajax-code.php',
			  dataType: 'json',
			  data: $('#formCode').serialize()
			})
			.done(function( msg ) {
				$('#info-overlay').html(msg.status ? '<i class="fa fa-check-circle-o fa-lg"></i> O código foi salvo com sucesso!' : '<i class="fa fa-exclamation-triangle fa-lg"></i> O código não foi salvo.').delay(1000).fadeOut();
			})
			.fail(function(jqXHR, textStatus) {
				$('#info-overlay').html('<i class="fa fa-exclamation-triangle fa-lg"></i>').delay(1000).fadeOut();
			});
		}
	};
	
	this.init = function() {
		setInterval(autoSaveCode, 5000);
	};
	
	this.onCodingKeyEvent = function(editor, e) {
		if(e.type == "keydown") {
			mAutoSaveDirty = true;
			$('#btn-save').attr('class', 'ide-button ide-button-dirty');
		}
		
		editor.save();
	};
	
	this.save = function() {
		autoSaveCode(true);
		$('#btn-save').attr('class', 'ide-button');
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
			$('#build-info').attr('class', 'alert-success').html(msg.status ? 'O código foi salvo com sucesso!' : 'O código não foi salvo.');
			$('#btn-save').attr('class', 'ide-button');
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