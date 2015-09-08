// Define variables needed by core/core.js
var _wrs_int_conf_file = "integration/configurationjs.php";
var _wrs_int_conf_async = true;
var _wrs_baseURL;

// Stats editor (needed by core/editor.js)
var _wrs_conf_editor = "TinyMCE";

// Define _wrs_conf_path (path where configuration is found)
if (typeof _wrs_isMoodle24 == 'undefined') {
	_wrs_baseURL = tinymce.baseURL;
	_wrs_conf_path = _wrs_baseURL + '/plugins/tiny_mce_wiris/'; // TODO use the same variable name always
}else{
	var base = tinymce.baseURL;
	var search = 'lib/editor/tinymce';
	var pos = base.indexOf(search);
	_wrs_baseURL = tinymce.baseURL.substr(0, pos + search.length);
	_wrs_conf_path = _wrs_baseURL + '/plugins/tiny_mce_wiris/tinymce/'; // TODO use the same variable name always
	_wrs_int_conf_async = false; // For sure!
}

var _wrs_int_path = _wrs_int_conf_file.split("/");
_wrs_int_path.pop();
_wrs_int_path = _wrs_int_path.join("/");
_wrs_int_path =  _wrs_int_path.indexOf("/")==0 || _wrs_int_path.indexOf("http")==0 ? _wrs_int_path : _wrs_conf_path + "/" + _wrs_int_path;

// Load configuration synchronously
if (!_wrs_int_conf_async) {
	var httpRequest = typeof XMLHttpRequest != 'undefined' ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
	var configUrl = (_wrs_int_conf_file.indexOf('/')==0 || _wrs_int_conf_file.indexOf('http') == 0) ? _wrs_int_conf_file : _wrs_conf_path + '/' + _wrs_int_conf_file;
	httpRequest.open('GET', configUrl, false);
	httpRequest.send(null);
	eval(httpRequest.responseText);
}

/* Including core.js */
tinymce.ScriptLoader.load(_wrs_conf_path + 'core/core.js');

var _wrs_conf_pluginBasePath = _wrs_conf_path; // _wrs_baseURL + '/plugins/tiny_mce_wiris';

/* Vars */
var _wrs_int_editorIcon = _wrs_conf_path + 'core/icons/tiny_mce/formula.gif';
var _wrs_int_CASIcon = _wrs_conf_path + 'core/icons/tiny_mce/cas.gif';
var _wrs_int_temporalIframe;
var _wrs_int_temporalElementIsIframe;
var _wrs_int_window;
var _wrs_int_window_opened = false;
var _wrs_int_temporalImageResizing;
var _wrs_int_wirisProperties;
var _wrs_int_directionality; 

/* Plugin integration */
(function () {
	tinymce.create('tinymce.plugins.tiny_mce_wiris', {
		init: function (editor, url) {
			var element;
			
			//Fix a Moodle 2.4 bug. data-mathml was lost without this.
			if (typeof _wrs_isMoodle24 !== 'undefined' && _wrs_isMoodle24){
				editor.settings.extended_valid_elements += ',img[*]';
			}

			// On inline mode, we can't recover unfiltered text
			// mathml tags must be added to editor valid_elements.
			if (editor.inline) {
				editor.settings.extended_valid_elements += ",math[*],menclose[*],merror[*],mfenced[*],mfrac[*],mglyph[*],mi[*],mlabeledtr[*],mmultiscripts[*],mn[*],mo[*],mover[*],mpadded[*],mphantom[*],mroot[*],mrow[*],ms[*],mspace[*],msqrt[*],mstyle[*],msub[*],msubsup[*],msup[*],mtable[*],mtd[*],mtext[*],mtr[*],munder[*],munderover[*],semantics[*],maction[*]";
				editor.settings.extended_valid_elements += ",annotation[*]"; // LaTeX parse
			}
			
			var onInit = function (editor) {
				var editorElement = editor.getElement();
				var content = ('value' in editorElement) ? editorElement.value : editorElement.innerHTML;
				
				function whenDocReady() {
					if (window.wrs_initParse && typeof _wrs_conf_plugin_loaded != 'undefined') {
						var language = editor.getParam('language');
						_wrs_int_directionality = editor.getParam('directionality');
				
						if (editor.settings['wirisformulaeditorlang']) {
							language = editor.settings['wirisformulaeditorlang'];
						}
						
						//Bug fix: In Moodle2.x when TinyMCE is set to full screen 
						//the content doesn't need to be filtered.
						if (!editor.getParam('fullscreen_is_enabled')){
							editor.setContent(wrs_initParse(content, language));
						}

						if (!editor.inline) {
							element = editor.getContentAreaContainer().firstChild;
							wrs_initParseImgToIframes(element.contentWindow);
							wrs_addIframeEvents(element, function (iframe, element) {
							wrs_int_doubleClickHandler(editor, iframe, true, element);
						}, wrs_int_mousedownHandler, wrs_int_mouseupHandler);
						} else { // Inline
							element = editorElement;
							wrs_addElementEvents(element, function (div, element) {
							wrs_int_doubleClickHandler(editor, div, false, element);
						},  wrs_int_mousedownHandler, wrs_int_mouseupHandler);
						}

					}
					else {
						setTimeout(whenDocReady, 50);
					}
				}
				
				whenDocReady();
			}
			
			if ('onInit' in editor) {
				editor.onInit.add(onInit);
			}
			else {
				editor.on('init', function () {
					onInit(editor);
				});
			}
			
			var onSave = function (editor, params) {
				_wrs_int_wirisProperties = {
					'bgColor': editor.settings['wirisimagebgcolor'],
					'symbolColor': editor.settings['wirisimagesymbolcolor'],
					'transparency': editor.settings['wiristransparency'],
					'fontSize': editor.settings['wirisimagefontsize'],
					'numberColor': editor.settings['wirisimagenumbercolor'],
					'identColor': editor.settings['wirisimageidentcolor'],
					'color' : editor.settings['wirisimagecolor'],
					'dpi' : editor.settings['wirisdpi'],
					'backgroundColor' : editor.settings['wirisimagebackgroundcolor'],
					'fontFamily' : editor.settings['wirisfontfamily']
				};
				
				var language = editor.getParam('language');
				_wrs_int_directionality = editor.getParam('directionality');
				
				if (editor.settings['wirisformulaeditorlang']) {
					language = editor.settings['wirisformulaeditorlang'];
				}
				
				params.content = wrs_endParse(params.content, _wrs_int_wirisProperties, language);
			}
			
			if ('onSaveContent' in editor) {
				editor.onSaveContent.add(onSave);
			}
			else {
				editor.on('saveContent', function (params) {
					onSave(editor, params);
				});
			}
			
			if (_wrs_int_conf_async || _wrs_conf_editorEnabled) {
				editor.addCommand('tiny_mce_wiris_openFormulaEditor', function () {
					_wrs_int_wirisProperties = {
						'bgColor': editor.settings['wirisimagebgcolor'],
						'symbolColor': editor.settings['wirisimagesymbolcolor'],
						'transparency': editor.settings['wiristransparency'],
						'fontSize': editor.settings['wirisimagefontsize'],
						'numberColor': editor.settings['wirisimagenumbercolor'],
						'identColor': editor.settings['wirisimageidentcolor'],
						'color' : editor.settings['wirisimagecolor'],
						'dpi' : editor.settings['wirisdpi'],
						'backgroundColor' : editor.settings['wirisimagebackgroundcolor'],
						'fontFamily' : editor.settings['wirisfontfamily']
					};

					var language = editor.getParam('language');
					_wrs_int_directionality = editor.getParam('directionality');
					
					if (editor.settings['wirisformulaeditorlang']) {
						language = editor.settings['wirisformulaeditorlang'];
					}
					
					wrs_int_openNewFormulaEditor(element, language, editor.inline ? false : true);
				});
			
				editor.addButton('tiny_mce_wiris_formulaEditor', {
					title: 'WIRIS editor',
					cmd: 'tiny_mce_wiris_openFormulaEditor',
					image: _wrs_int_editorIcon
				});
			}

			if (_wrs_int_conf_async || _wrs_conf_CASEnabled) {
				editor.addCommand('tiny_mce_wiris_openCAS', function () {
					var language = editor.settings.language;
				
					if (editor.settings['wirisformulaeditorlang']) {
						language = editor.settings['wirisformulaeditorlang'];
					}
					
					wrs_int_openNewCAS(element, language, editor.inline ? false : true);
				});
			
				editor.addButton('tiny_mce_wiris_CAS', {
					title: 'WIRIS cas',
					cmd: 'tiny_mce_wiris_openCAS',
					image: _wrs_int_CASIcon
				});
			}
		},
		
		// all versions
		getInfo: function () {
			return {
				longname : 'tiny_mce_wiris',
				author : 'Maths for More',
				authorurl : 'http://www.wiris.com',
				infourl : 'http://www.wiris.com',
				version : '1.0'
			};
		}	
	});

	tinymce.PluginManager.add('tiny_mce_wiris', tinymce.plugins.tiny_mce_wiris);
})();

/**
 * Opens formula editor.
 * @param object element Target
 * @param string language 
 * @param bool isIframe
 */
function wrs_int_openNewFormulaEditor(element, language, isIframe) {
	if (_wrs_int_window_opened) {
		_wrs_int_window.focus();
	}
	else {
		_wrs_int_window_opened = true;
		_wrs_isNewElement = true;
		_wrs_int_temporalIframe = element;
		_wrs_int_temporalElementIsIframe = isIframe;
		_wrs_int_window = wrs_openEditorWindow(language, element, isIframe);
	}
}

/**
 * Opens CAS.
 * @param object element Target
 * @param string language
 * @param bool isIframe
 */
function wrs_int_openNewCAS(element, language, isIframe) {
	if (_wrs_int_window_opened) {
		_wrs_int_window.focus();
	}
	else {
		_wrs_int_window_opened = true;
		_wrs_isNewElement = true;
		_wrs_int_temporalIframe = element;
		_wrs_int_temporalElementIsIframe = isIframe;
		_wrs_int_window = wrs_openCASWindow(element, isIframe, language);
	}
}

/**
 * Handles a double click on the target.
 * @param object editor tinymce active editor
 * @param object target Target
 * @param object element Element double clicked
 * @param bool isIframe target is an iframe or not
 */
function wrs_int_doubleClickHandler(editor, target, isIframe, element) {
	// This loop allows the double clicking on the formulas represented with span's.
	
	while (!wrs_containsClass(element, 'Wirisformula') && !wrs_containsClass(element, 'Wiriscas') && element.parentNode) {
		element = element.parentNode;
	}
	
	var elementName = element.nodeName.toLowerCase();
	
	if (elementName == 'img' || elementName == 'iframe' || elementName == 'span') {
		if (wrs_containsClass(element, 'Wirisformula')) {
			_wrs_int_wirisProperties = {
				'bgColor': editor.settings['wirisimagebgcolor'],
				'symbolColor': editor.settings['wirisimagesymbolcolor'],
				'transparency': editor.settings['wiristransparency'],
				'fontSize': editor.settings['wirisimagefontsize'],
				'numberColor': editor.settings['wirisimagenumbercolor'],
				'identColor': editor.settings['wirisimageidentcolor'],
				'color' : editor.settings['wirisimagecolor'],
				'dpi' : editor.settings['wirisdpi'],
				'backgroundColor' : editor.settings['wirisimagebackgroundcolor'],
				'fontFamily' : editor.settings['wirisfontfamily']
			};
			
			if (!_wrs_int_window_opened) {
				var language = editor.settings.language;
			
				if (editor.settings['wirisformulaeditorlang']) {
					language = editor.settings['wirisformulaeditorlang'];
				}
				
				_wrs_temporalImage = element;
				wrs_int_openExistingFormulaEditor(target, isIframe, language);
			}
			else {
				_wrs_int_window.focus();
			}
		}
		else if (wrs_containsClass(element, 'Wiriscas')) {
			if (!_wrs_int_window_opened) {
				var language = editor.settings.language;
			
				if (editor.settings['wirisformulaeditorlang']) {
					language = editor.settings['wirisformulaeditorlang'];
				}
				
				_wrs_temporalImage = element;
				wrs_int_openExistingCAS(target, isIframe, language);
			}
			else {
				_wrs_int_window.focus();
			}
		}
	}
}

/**
 * Opens formula editor to edit an existing formula.
 * @param object element Target
 * @param bool isIframe
 */
function wrs_int_openExistingFormulaEditor(element, isIframe, language) {
	_wrs_int_window_opened = true;
	_wrs_isNewElement = false;
	_wrs_int_temporalIframe = element;
	_wrs_int_temporalElementIsIframe = isIframe;
	_wrs_int_window = wrs_openEditorWindow(language, element, isIframe);
}

/**
 * Opens CAS to edit an existing formula.
 * @param object element Target
 * @param bool isIframe
 * @param string language
 */
function wrs_int_openExistingCAS(element, isIframe, language) {
	_wrs_int_window_opened = true;
	_wrs_isNewElement = false;
	_wrs_int_temporalIframe = element;
	_wrs_int_temporalElementIsIframe = isIframe;
	_wrs_int_window = wrs_openCASWindow(element, isIframe, language);
}

/**
 * Handles a mouse down event on the iframe.
 * @param object iframe Target
 * @param object element Element mouse downed
 */
function wrs_int_mousedownHandler(iframe, element) {
	if (element.nodeName.toLowerCase() == 'img') {
		if (wrs_containsClass(element, 'Wirisformula') || wrs_containsClass(element, 'Wiriscas')) {
			_wrs_int_temporalImageResizing = element;
		}
	}
}

/**
 * Handles a mouse up event on the iframe.
 */
function wrs_int_mouseupHandler() {
	if (_wrs_int_temporalImageResizing) {
		setTimeout(function () {
			wrs_fixAfterResize(_wrs_int_temporalImageResizing);
		}, 10);
	}
}

/**
 * Calls wrs_updateFormula with well params.
 * @param string mathml
 */
function wrs_int_updateFormula(mathml, editMode, language) {
	if (_wrs_int_temporalElementIsIframe) {
		wrs_updateFormula(_wrs_int_temporalIframe.contentWindow, _wrs_int_temporalIframe.contentWindow, mathml, _wrs_int_wirisProperties, editMode, language);
	}
	else {
		wrs_updateFormula(_wrs_int_temporalIframe, window, mathml, _wrs_int_wirisProperties, editMode, language);
	}
}

/**
 * Calls wrs_updateCAS with well params.
 * @param string appletCode
 * @param string image
 * @param int width
 * @param int height
 */
function wrs_int_updateCAS(appletCode, image, width, height) {
	if (_wrs_int_temporalElementIsIframe) {
		wrs_updateCAS(_wrs_int_temporalIframe.contentWindow, _wrs_int_temporalIframe.contentWindow, appletCode, image, width, height);
	} else {
		wrs_updateCAS(_wrs_int_temporalIframe, window, appletCode, image, width, height);
	}
}

/**
 * Handles window closing.
 */
function wrs_int_notifyWindowClosed() {
	_wrs_int_window_opened = false;
}
