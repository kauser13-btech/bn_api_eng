/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.versionCheck = false;
	config.fontSize_defaultLabel = '28px';
	config.extraPlugins = ['image2', 'socialembed']; //, 'youtube', 'embed', 'autoembed'
	config.image2_altRequired = true;
	config.allowedContent = true;
	config.entities_latin = false;
	config.extraAllowedContent = 'iframe[*]';
	config.iframe_attributes = {
		// sandbox: 'allow-scripts allow-same-origin',
	}
};
