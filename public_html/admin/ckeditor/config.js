/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
function getCSRFTOKEN() { 
   var metas = document.getElementsByTagName('meta'); 

   for (var i=0; i<metas.length; i++) { 
      if (metas[i].getAttribute("name") == "csrf-token") { 
         return metas[i].getAttribute("content"); 
      } 
   } 

    return "";
} 

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	// Simplify the dialog windows.
	// config.removeDialogTabs = 'image:advanced;link:advanced';
	//upload path server
	config.filebrowserUploadUrl = '/admin/upload_user/index?_token='+getCSRFTOKEN();
	//config.extraPlugins = 'jsplus_image_editor';

	//config.extraPlugins = 'some_other_plugin,one_more_plugin,jsplus_image_editor';

};


