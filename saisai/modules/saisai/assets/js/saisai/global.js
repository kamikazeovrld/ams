function initSaisaiNamespace(){
	var f;
	if (window.saisai == undefined){
		if (top.window.saisai != undefined){
			f = top.window.saisai;
		} else {
			f = {};
		}
	} else {
		f = window.saisai;
	}
	return f;
}
//saisai = initSaisaiNamespace();
//console.log(saisai)
if (typeof(window.saisai) == 'undefined'){
	window.saisai = {};
}

saisai.lang = function(key){
	return __SAISAI_LOCALIZED__[key];
}

// used to get id values in case the form fields are namespaced
saisai.getFieldId = function(field, context){
	if (window.__SAISAI_INLINE_EDITING != undefined){
		var val = $('.__saisai_module__', context).attr('id');
		var prefix = val.split('--')[0];
		return prefix + '--' + field;
	} else {
		return field;
	}
}

saisai.getModule = function(context){
	// inline editing
	if (window.__SAISAI_INLINE_EDITING != undefined){
		return $('.__saisai_module__', context).val();
	} else {
		// jqx controller instance name is "page"
		return page.module;
	}
}


saisai.modalWindow = function(html, cssClass, autoResize, onLoadCallback, onCloseCallback){

	var modalId = '__SAISAI_modal__';
	if (!cssClass) cssClass = '';
	var $context = $('body', window.document);
	if (!$('#' + modalId, $context).length){
		var modalHTML = '<div id="' + modalId + '"><div class="loader"></div><a href="#" class="modal_close jqmClose"></a><div class="modal_content"></div></div>';
	} else {
		$('#' + modalId, $context).html('<div class="loader"></div><a href="#" class="modal_close jqmClose"></a><div class="modal_content"></div>');
	}
	

	
	var modalOnHide = function(){
		$('#' + modalId, $context).hide();
		$('.jqmOverlay', $context).remove();
		if (onCloseCallback) onCloseCallback();
	}	
	
	$context.append(modalHTML);
	$modal = $('#' + modalId, $context);
	$modal.attr('class', '__saisai__ __saisai_modal__ jqmWindow ' + cssClass)
	
	var modalWidth = $modal.outerWidth();
	var centerWidth = -((modalWidth/2));
	$modal.css('marginLeft', centerWidth + 'px');

	
	// show it first so we don't get the cancellation error in the console
	
	// set jqm window options
	var jqmOpts = { onHide: modalOnHide, toTop:true };
	if (onLoadCallback){
		jqmOpts.onLoad = onLoadCallback;
	}
	
	$modal.jqm(jqmOpts).jqmShow();
	$modal.find('.modal_content').empty().append(html);
	$modal.find('iframe').load(function(){
		$('.jqmWindow .loader', $context).hide();
		var iframe = this;
		var contentDoc = iframe.contentDocument;

		$('.cancel', contentDoc).add('.modal_close').click(function(e){
			e.preventDefault();
			$modal.jqmHide();
		})

		if (autoResize){
			setTimeout(function(){
					docHeight = saisai.calcHeight(contentDoc);
					$(iframe.contentWindow.parent.document).find('#' + modalId + 'iframe').height(docHeight);
					saisai.cascadeIframeWindowSize(docHeight);
					$(iframe).height(docHeight);
			}, 250);
		}
		
	})
	
	return $modal;
}

saisai.closeModal = function(){
	var modalId = '__SAISAI_modal__';
	$('#' + modalId).jqmHide();
}

saisai.getModule = function(context){
	if (window.saisai && window.saisai.module){
		return window.saisai.module;
	}
	if (context == undefined) context = null;
	var module = ($('.__saisai_module__', context).length) ? $('.__saisai_module__', context).val() : null;
	return module;
}

saisai.getModuleURI = function(context){
	if (context == undefined) context = null;
	var module = ($('.__saisai_module_uri__').length) ? $('.__saisai_module_uri__').val() : null;
	return module;
}

saisai.isTop = function(){
	return self == top;
}

saisai.windowLevel = function(){
	var level = 0;
	var win = window;
	while (win != top && win.parent != null){ 
		level++; 
		win = win.parent;
	}
	return level;
}

saisai.calcHeight = function(context){
	var height = 0;
	if ($('#login', context).length){
		var elems = '#login'; 
	} else {
		var elems = '#saisai_main_top_panel, #saisai_actions, #saisai_notification, #saisai_main_content_inner, #list_container, .instructions';
	}
	$(elems, context).each(function(i){
		// must use false to get around bug with jQuery 1.8
		var outerHeight = parseInt($(this).outerHeight(false));
		if (outerHeight) height += outerHeight;
	})
	if (height > 480) {
		height = 480;
	} else {
		height += 30;
	}
	return height;
}

saisai.adjustIframeWindowSize = function(){
	var iframe = $('.inline_iframe', top.window.document);
	if (iframe.length){
		iframe = iframe[0];
		var contentDoc = iframe.contentDocument;
		var height = parseInt(saisai.calcHeight(contentDoc));
		var width = parseInt($('#saisai_main_content_inner .form', contentDoc).width()) + 50;
		$(iframe).height(height);
		$(iframe).width(width);
	}
}

saisai.cascadeIframeWindowSize = function(height){
	var level = 0;
	if (height) height = height + 100;
	//var win = window;
	// console.log(win.document.title)
	$('.inline_iframe', top.window.document).height(height);
	
	// do 
	// {
	// 	level++;
	// 	//height = saisai.calcHeight(win.document);
	// 	console.log($('.inline_iframe', win.document))
	// 	$('.inline_iframe', win.document).height(height);
	// 	win = win.parent;
	// 	console.log(win.document.title)
	// 
	// } while (win != top && win.parent != null)
//	return level;
}