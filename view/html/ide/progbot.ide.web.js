/*
	The MIT License (MIT)

	Copyright (c) 2015 Fernando Bevilacqua

	Permission is hereby granted, free of charge, to any person obtaining a copy of
	this software and associated documentation files (the "Software"), to deal in
	the Software without restriction, including without limitation the rights to
	use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
	the Software, and to permit persons to whom the Software is furnished to do so,
	subject to the following conditions:

	The above copyright notice and this permission notice shall be included in all
	copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
	FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
	COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
	IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
	CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

/**
 * The Progbot IDE.
 */
var ProgbotIdePlugin = function() {
    // Constants
    const API_URL       = 'ajax-code.php';

    this.id             = 'progbot.ide.web';

    var mSelf           = this;
    var mContext        = null;
    var mData           = {};

    this.api = function(theAction, theCallback) {
        $.ajax({
            url: API_URL + '?action=' + theAction,
            method: 'post',
            data: mData,
            dataType: 'json'
        }).done(function(theData) {
            console.debug('web API response', theData);
            theCallback(theData);

        }).fail(function(theJqXHR, theTextStatus, theError) {
            console.error('web API error: ' + theTextStatus + ', ' + theError);
        });
    };

    this.init = function(theContext) {
        console.debug('ProgbotIdePlugin::init()');

        mContext = theContext;
        mContext.ui.addButton({ icon: '<i class="fa fa-floppy-o"></i>', action: mSelf.save });

        mData.challenge   = CODEBOT.utils.getURLParamByName('challenge');
        mData.program     = CODEBOT.utils.getURLParamByName('program');
        mData.assignment  = CODEBOT.utils.getURLParamByName('assignment');
        mData.canEdit     = CODEBOT.utils.getURLParamByName('canEdit');
        mData.code        = '';

        mContext.ui.tabs.openNode({
            data: {
                name: 'main.c',
                path: '/main.c',
            }
        });
    };

    this.save = function(theContext, theButton) {
        var aTab = mContext.ui.tabs.active;

        if(aTab) {
            mContext.writeTabToDisk(aTab);
        }
    };
};

CODEBOT.addPlugin(new ProgbotIdePlugin());
