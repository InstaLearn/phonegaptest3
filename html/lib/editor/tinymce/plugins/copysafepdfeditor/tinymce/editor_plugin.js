(function() {
    
        // Load plugin specific language pack
        tinymce.PluginManager.requireLangPack('copysafepdfeditor');

        tinymce.create('tinymce.plugins.Copysafepdfeditor', {
                /**
                 * Initializes the plugin, this will be executed after the plugin has been created.
                 * This call is done before the editor instance has finished it's initialization so use the onInit event
                 * of the editor instance to intercept that event.
                 *
                 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
                 * @param {string} url Absolute URL to where the plugin is located.
                 */
                init : function(ed, url) {

                        // Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
                        ed.addCommand('mceCopysafepdfeditor', function() {
                                ed.windowManager.open({
                                        file : cfgroot + '/mod/copysafepdf/media-upload.php', 
                                        width : 600 + ed.getLang('copysafepdfeditor.delta_width', 0),
                                        height : 400 + ed.getLang('copysafepdfeditor.delta_height', 0),
                                        inline : 1
                                }, {
                                        plugin_url : url
                                    });
                        });

                        // Register example button
                        ed.addButton('copysafepdfeditor', {
                                title : 'Copysafepdfeditor Plugin',
                                cmd : 'mceCopysafepdfeditor',
                                image : url + '/img/copysafepdfeditor.png'
                        });
                        
                },

                /**
                 * Returns information about the plugin as a name/value array.
                 * The current keys are longname, author, authorurl, infourl and version.
                 *
                 * @return {Object} Name/value array containing information about the plugin.
                 */
                getInfo : function() {
                        return {
                                longname : 'Copysafepdfeditor plugin',
                                author : 'Some author',
                                authorurl : '',
                                infourl : '',
                                version : "1.0"
                        };
                }
        });

        // Register plugin
        tinymce.PluginManager.add('copysafepdfeditor', tinymce.plugins.Copysafepdfeditor);
})();
