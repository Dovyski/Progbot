var CODEBOT = CODEBOT || {};

CODEBOT.page = new function() {
	this.init = function(thePage) {
		var self = this;

		// Enhance custom-made stuff.
		$('a[data-onclick-show]:not([data-onclick-show=""]').each(function(theIndex, theElement) {
			$(theElement).click(function() {
				$(this).hide();
				$('#' + $(this).data('onclick-show')).show();
			});
		});

		// Per-page init
		var aPages = {
			'challenges.php': this.challenges,
			'groups-manager.php': this.groups,
		};

		if(aPages[thePage]) {
			aPages[thePage].init();
		}
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

	this.groups = {
		init: function() {
			var aSelf = this;

			var aGroupId = document.getElementById('formGroups').elements['id'].value;
			aSelf.load('group-members', aGroupId);

			$('#panel-add-member button').click(function() {
				aSelf.addMember('group-members', aGroupId, 'user-name');
			})
		},

		load: function(theContainerId, theGroupId) {
			$('#' + theContainerId).html('Carregando... <img src="./ajax-loader.gif" title="Loading" align="absmiddle">');

			$.ajax({
			  type: 'POST',
			  url: 'ajax-group-members.php',
			  data: {'group': theGroupId }
			})
			.done(function( msg ) {
				$('#' + theContainerId).html(msg);
			})
			.fail(function(jqXHR, textStatus) {
				$('#' + theContainerId).html('<strong>Oops!</strong> Algum erro aconteceu. Tente novamente.');
			});
		},

		addMember: function(theContainerId, theGroupId, theFieldWhereUserIdIs) {
			var aSelf 		= this;
			var aUserName 	= $('#' + theFieldWhereUserIdIs).val();
			var aDatalist 	= $('#' + theFieldWhereUserIdIs).attr('list');

			var aUserId 	= $('#' + aDatalist).find('option[value="'+aUserName+'"]').data('id');

			if(aUserId) {
				aSelf.changeMember(theContainerId, theGroupId, aUserId, 'add');
			}
		},

		changeMember: function(theContainerId, theGroupId, theUserId, theAction) {
			$.ajax({
			  type: 'POST',
			  url: 'ajax-group-members.php',
			  data: {'action': theAction, 'group': theGroupId, 'user' : theUserId }
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
