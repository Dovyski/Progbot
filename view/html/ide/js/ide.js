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
		}
		
		editor.save();
	};
	
	this.build = function() {
		$('.codeTab[data-toggle="tab"]').on('shown', function (e) {
			var aActiveTab 	= e.target + '';
			var aOldTab 	= e.relatedTarget + '';
			
			aActiveTab 		= aActiveTab.substr(aActiveTab.lastIndexOf('#'));
			aOldTab 		= aOldTab.substr(aOldTab.lastIndexOf('#'));

			if(aActiveTab == '#tab-code-test') {
				$('#build-info').attr('class', 'alert alert-warning').html('<strong>Atenção!</strong> Seu código está sendo salvo... <img src="./ajax-loader.gif" title="Loading" align="absmiddle">');

				$.ajax({
				  type: 'POST',
				  url: 'ajax-code.php',
				  dataType: 'json',
				  data: {'programId': $('#formCode input[name=programId]').val(), 'action': 'build' }
				})
				.done(function( msg ) {
					$('#build-info').attr('class', 'alert alert-success').html('<strong>Pronto!</strong> Seu código foi salvo no arquivo <code>'+msg.file+'</code> na pasta <code>'+msg.path+'</code>.');
				})
				.fail(function(jqXHR, textStatus) {
					$('#build-info').attr('class', 'alert alert-error').html('<strong>Oops!</strong> Algum erro aconteceu. Tente novamente.');
				});
			}
		});
	};
	
	this.openTerminal = function() {
		window.open('', '_blank', 'toolbar=0,location=0,menubar=0,width=800,height=600');
	};
};

$(IDE.init);