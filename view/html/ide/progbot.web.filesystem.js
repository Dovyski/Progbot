var ProgbotWebFilesystem = function() {
	// Constants
	const API_URL = '../../../../ajax-code.php';

	// Public properties
	this.driver = 'Progbot Web Disk FileSystem';

	var runCommand = function(theAction, theParams, theCallback) {
		$.ajax({
			url: API_URL + '?action=' + theAction,
			method: 'post',
			data: theParams,
			dataType: 'json'
		}).done(function(theData) {
			theCallback(theData);

		}).fail(function(theJqXHR, theTextStatus, theError) {
			console.error('Error: ' + theTextStatus + ', ' + theError);
		});
	};

	this.init = function() {
		console.debug('ProgbotWebDiskFilesystem::init()');
	};

    this.move = function(theOldNode, theNewNode, theCallback) {
		theCallback();
    };

    this.getTempDirectory = function(theCallback) {
        theCallback({title: "tmp", path: "/tmp", name: "tmp", folder: true, key: "tmp"});
    };

    this.readDirectory = function(theNode, theCallback) {
		if(theNode.path.indexOf('codebot://') != -1) {
			var aPath = theNode.path.replace(/codebot:\/\//, '');

			if(aPath == './plugins') {
				theCallback([{
					'name':'Project',
					'title':'Project',
					'path':'/',
					'folder':'true',
					'key':'root',
					'expanded':true,
					'children': [
						{'name':'progbot.ide.web.js', 'title':'progbot.ide.web.js', 'path':'../progbot.ide.web.js'}
					]
				}]);
			}
		} else {
			theCallback();
		}
    };

	this.chooseDirectory = function(theCallback) {
        theCallback({path: 'chosenDir', title: 'chosenDir', name: 'chosenDir'});
	};

	this.readFile = function(theNode, theCallback) {
		if(theNode.path.indexOf('codebot://') != -1) {
			theCallback(null);

		} else {
			runCommand('readcode', {programId: theNode.path}, function(theData) {
				theCallback(theData.code);
			});
		}
	};

	this.writeFile = function(theNode, theData, theCallback) {
		if(theNode.path.indexOf('codebot://') != -1) {
			runCommand({method: 'write-codebot', path: theNode.path.replace(/codebot:\/\//, ''), data: theData}, 'json', theCallback);

		} else {
			runCommand('savecode', {programId: theNode.path, code: theData}, function(theResponse) {
				console.log(theResponse);
				theCallback();
			});
		}
	};

	this.createFile = function(theName, theNode, theData, theCallback) {
		theCallback();
	};

    this.delete = function(theNode, theCallback) {
		theCallback();
	};

	this.createDirectory = function(theName, theNode, theCallback) {
		theCallback();
	};
};
