/* CSS for Boxify Plugin
 * Written by Nimrod Tsabari
 * Since Version 0.1b
 */
(function() {
    tinymce.create('tinymce.plugins.boxifyplugin', {
        init : function(ed, url) {
		   ed.addCommand('boxifyAct', function() {
                ed.windowManager.open({
                        file : url + '/boxify.htm',
                        width : 465,
                        height : 450,
                        inline : 1
                }, {
                        plugin_url : url, // Plugin absolute URL
                        some_custom_arg : 'custom arg' // Custom argument
                });
	        });          
	        ed.addButton('boxifyplugin', {
                title : 'Add A Boxify Box',
                image : url + '/img/boxify.png',
                cmd : 'boxifyAct',
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Boxify",
                author : 'Nimrod Tsabari',
                authorurl : 'http://dev.nimrodtsabari.com/',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('boxifyplugin', tinymce.plugins.boxifyplugin);
})();