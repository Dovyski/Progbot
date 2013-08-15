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
	
	this.onCodingKeyEvent = function(editor, e) {
		if(e.type == "keydown") {
			mAutoSaveDirty = true;
		}
		
		editor.save();
	};
	
	this.initCodePage = function() {
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
		
		$('#changeGradeLink').on('click', function() {
			$('#changeGradeLink').hide();
			$('#changeGradePanel').show();
		});
		
		$('#formChangeGrade').on('submit', function() {
			$.ajax({
			  type: 'POST',
			  url: 'ajax-code.php',
			  dataType: 'json',
			  data: $('#formChangeGrade').serialize()
			})
			.done(function( msg ) {
				$('#changeGradeLink strong').html(msg.grade);
				$('#changeGradeLink').show();
				$('#changeGradePanel').hide();
				
				console.log( "Grade changed: " + msg );
			})
			.fail(function(jqXHR, textStatus) {
				$('#changeGradeLink strong').html('Erro');
				$('#changeGradeLink').show();
				$('#changeGradePanel').hide();
				
				console.log( "Request failed grade: " + textStatus );
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
				$(aActiveTab).html('<img src="./ajax-loader.gif" title="Loading" align="absmiddle"> Loading...');

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
	
	this.initCodeTabs = function() {
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
	
	this.openEditor = function(theChallengeId) {
		window.open('ide.php?challenge=' + theChallengeId, '_blank', 'toolbar=0,location=0,menubar=0,width=1024,height=768');
	};
};