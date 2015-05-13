var CODEBOT = CODEBOT || {};

CODEBOT.page = new function() {
	this.enhance = function() {
		$('a[data-onclick-show]:not([data-onclick-show=""]').each(function(theIndex, theElement) {
			$(theElement).click(function() {
				$(this).hide();
				$('#' + $(this).data('onclick-show')).show();
			});
		});
	};

	this.challenges = {
		init: function() {
			var self = this;

			$('#category-filter').change(function() {
				self.load('active-challenges', {type: 'actives', page: 0});
			});

			self.load('active-challenges', {type: 'actives', page: 0});
			self.load('answered-challenges', {type: 'answered', page: 0});
		},

		load: function(theContainerId, theData) {
			$('#' + theContainerId).html('Carregando... <img src="./ajax-loader.gif" title="Loading" align="absmiddle">');

			// Get filtering criteria
			theData.fk_category = $('#category-filter').val() | 0;

			$.ajax({
			  type: 'POST',
			  url: 'ajax-challenges.php',
			  data: theData
			})
			.done(function( msg ) {
				$('#' + theContainerId).html(msg);
			})
			.fail(function(jqXHR, textStatus) {
				$('#' + theContainerId).html('<strong>Oops!</strong> Algum erro aconteceu. Tente novamente.');
			});
		},
	};
};
