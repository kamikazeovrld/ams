// exposed saisai methods
if (saisai == undefined) var saisai = {};
(function($) {

	var initObj = __SAISAI_INIT_PARAMS__;
	var pageId = initObj.pageId;
	var pageLocation = initObj.pageLocation;
	var basePath = initObj.basePath;
	var cookiePath = initObj.cookiePath;
	var imgPath = initObj.imgPath;
	var cssPath = initObj.cssPath;
	var jsPath = initObj.jsPath;
	var assetsImgPath = initObj.assetsImgPath;
	var assetsPath = initObj.assetsPath;
	var assetsAccept = initObj.assetsAccept;
	var editor = initObj.editor;
	var editorConfig = initObj.editorConfig;

	var markers = null;
	var X_OFFSET = 16;
	var Y_OFFSET = 16;

	var editorsOn = (parseInt($.supercookie('saisai_bar', 'show_editable_areas')) == 1);
	var saisaiBarOn = (parseInt($.supercookie('saisai_bar', 'show_saisai_bar')) == 1);

	var activeEditor;
	var activeField;
	var assetFolder;
	var iconHeight = 16;
	
	var maxAdjustLoops = (saisai.maxAdjustLoops) ? saisai.maxAdjustLoops : 10;
	
	
	// limit it to the most common for performance
	var useAutoAdjust = (saisai.useAutoAdjust === false) ? false : true;
	var resizeTags = (saisai.resizeTags) ? saisai.resizeTags : 'section,div,p,li';

	jQuery.resize.delay = (saisai.resizeDelay) ? saisai.resizeDelay : 1000;
	
	function lang(key){
		return __SAISAI_LOCALIZED__[key];
	}
	
	
	$(document).ready(function(){

		$('body').addClass('__saisai_inline__');
		
		function init(){

			// disable the toolbar if it is being view from within the admin
			if (window.top != window){
				$('#__saisai_edit_bar__').hide();
				return;
			}
			initMarkers();
			initSAISAIBar();
			
			// bind exposed global methods
			saisai.refresh = function(){
				refresh();
			}
			
			saisai.modalWindow = function (html, cssClass, callback){
				var modalId = '__SAISAI_modal__';
				if (!cssClass) cssClass = '';
				var $context = $('body', top.window.document);
				
				var modalHtml = '<a href="#" class="modal_close jqmClose"></a><div class="modal_content"></div>';
				if (!$('#' + modalId).size()){
					var modalHTML = '<div id="' + modalId + '" class="__saisai__ __saisai_modal__ jqmWindow ' + cssClass + '"><a href="#" class="modal_close jqmClose"></a><div class="modal_content"></div></div>';
					$context.append(modalHTML);
				}
				
				// add loading graphic
				$('#' + modalId, $context).append('<div class="loader"></div>');
				

				// add overlay and hide iframe overlay 
				//$('.jqmOverlay', $context).hide();

				$modal = $('#' + modalId, $context);
				$modal.find('.modal_content').empty().append(html);
				$modal.find('iframe').load(function(){
					$('.jqmWindow .loader', $context).remove();
					var iframe = this;
					
					var contentDoc = iframe.contentDocument;

					var actionsHeight = $('#saisai_actions', contentDoc).outerHeight(false);
					var notificationsHeight = $('#saisai_notification', contentDoc).outerHeight(false);
					var mainContentHeight =  $('#saisai_main_content_inner', contentDoc).outerHeight(false);
					var listTableHeight = $('#data_table_container', contentDoc).outerHeight(false);
					docHeight = actionsHeight + notificationsHeight + mainContentHeight + listTableHeight + 30; // 30 is a fudge factor
					
					//docHeight = 100
					// var heightFudge = $('#saisai_notification', contentDoc).outerHeight() + 30; // padding for #saisai_main_content_inner is 15 top and 15 bottom
					// heightFudge += $('#saisai_actions', contentDoc).outerHeight();
					// var docHeight = $('#saisai_main_content_inner', contentDoc).outerHeight() + heightFudge; // bottom margin is added... not sure from what though
					//console.log(docHeight)
					if (docHeight > 450) docHeight = 450;
					var docWidth = 850; // 74 includes the 37 in padding on each side
					$(iframe).height(docHeight);
					$(iframe).width(docWidth);
					
				})
				$modal.jqm({}).jqmShow();
			}
			
			saisai.refreshIframeSize = function(iframe){
				var i = 0;
				// polling
				var interval = setInterval(function(){
					saisai.setIframeSize(iframe);
					if (i > 20) clearInterval(interval);
					i++;
				}, 100);
			}
			
			saisai.setIframeSize = function(iframe){
				var MIN_WIDTH = 850;
				var contentDoc = iframe.contentDocument;
				var docHeight = saisai.calcHeight(contentDoc);
				
				if ($('#saisai_main_content_inner .form, #saisai_actions', contentDoc).size()){
					var width1 = $('#saisai_main_content_inner .form', contentDoc).outerWidth(false) + 74; // 74 includes the 37 in padding on each side
					var width2 = $('#saisai_actions', contentDoc).outerWidth(false);
					var docWidth = (width1 > width2) ? width1 : width2;

					// check if saisai_actions is there so that we don't make it too wide for single variables being edited
					if (docWidth < MIN_WIDTH && $('#saisai_actions', contentDoc).size()) docWidth = MIN_WIDTH;
				} else if ($('#login', contentDoc).size()){
					docWidth = $('#login', contentDoc).width();
				} else {
					docWidth = $(contentDoc).width();
				}

				if (docHeight == 0){
					docHeight = $(contentDoc).height();
				}

				$(iframe).height(docHeight);
				$(iframe).width(docWidth);
			}
			
		}
		
		
		function initMarkers(){
			$('.__saisai_edit__').remove();
			var markers = $(".__saisai_marker__");
			var toggleEditOff = true;
			if (markers.size() > 0){
				$body = $('body');
				markers.each(function(i){
					var $this = $(this);
					var module = $this.attr('data-module');
					if ((module == 'pagevariables' && pageId != 0) || module != 'pagevariables'){
						$this.attr('id', '__saisai_marker__' + i);
						var coords = getMarkerPosition($this);
						var varName = $this.attr('title');
						var newClass = ($this.attr('data-rel').substr(0, 6) == 'create') ? ' __saisai_edit_marker_new__' : '';
						var publishedClass = ($this.attr('data-published') == '0') ? ' __saisai_edit_marker_unpublished__' : '';
						var html = '<div id="__saisai_edit__' + i + '" style="left:' + coords.x + 'px; top:' + coords.y + 'px;" class="__saisai__ __saisai_edit__" title="' + varName + '" data-module="' + module + '">';
						var dataHref = $this.attr('data-href').replace(/\|/, '/');
						html += '<a href="' + dataHref + '" rel="' + $this.attr('data-rel') + '" class="__saisai_edit_marker__'+ newClass + publishedClass + '">';
						html += '<span class="__saisai_edit_marker_inner__">' + varName + '</span>';
						html += '</a>';
						html += '<div class="__saisai_edit_form__" style="display: none;"><img src="' + imgPath + 'spinner_sm.gif" width="16" height="16" alt="loading"></div>';
						
						
						html += '</div>';
						$body.append(html);
						toggleEditOff = false;
					}
				});
				$('.__saisai_edit_marker_inner__').hide();
				initEditors();
			}
			if (toggleEditOff) $('#__saisai_page_edit_toggle__').parent().hide();
		}
		
		function refresh(){
			if (editorsOn){
				moveMarkers();
				if (activeEditor){
					var iframe = activeEditor.find('iframe')[0];
					//saisai.setIframeSize(iframe);
				}
			}
		}
		
		function moveMarkers(){
			var markers = $(".__saisai_marker__");
			markers.each(function(i){
				var $this = $(this);
				var coords = getMarkerPosition($this);
				
				$('#__saisai_edit__' + i).css({left: coords.x, top: coords.y});
				
				// determine if it is visible so that we can filter out the hidden to speed things up
				if ($this.filter(':hidden').size() != 0) {
					$('#__saisai_edit__' + i).hide();
				} else {
					$('#__saisai_edit__' + i).show();
				}
			});

			// re-adjust markers so they don't overlap
			var editors = $(".__saisai_edit__:visible");
			editors.each(function(i){
				adjustPosition(editors, $(this), 0);
			});

		}

		function getMarkerPosition(marker){
			var offset = marker.offset();
			var xCoord = offset.left;
			var yCoord = offset.top + iconHeight; // 16 is the icon height
			var x = (xCoord <= X_OFFSET) ? 0 : xCoord - X_OFFSET;
			var y = (yCoord <= Y_OFFSET) ? 0 : yCoord - Y_OFFSET;
			return {x:x, y:y};
		}
		
		// used to prevent overlaps of editors
		function adjustPosition(editors, $obj, counter){
			editors.each(function(i){
				var $compareObj = $(this);
				var topPos = parseInt($obj.css('top'));
				var leftPos = parseInt($obj.css('left'));
				
				var objAttrsId = $obj.attr('id');
				var objCompareAttrsId = $compareObj.attr('id');
				if (counter <= maxAdjustLoops && $obj.attr('id') != $compareObj.attr('id') && 
					Math.abs(topPos - parseInt($compareObj.css('top'))) < Y_OFFSET && 
					Math.abs(leftPos - parseInt($compareObj.css('left'))) < X_OFFSET){
					$compareObj.css('top', (topPos + Y_OFFSET) + 'px');
					counter++;
					adjustPosition(editors, $obj, counter);
					return false;
				}
			});
		}
		
		function initEditors(){
			
			var formAction = '';
			
			var editors = $('.__saisai_edit__');

			var resetCss = {height: 'auto', width: 'auto', opacity: 1, display: 'block'};

			var closeEditor = function(){
				
				// turn off inline editing mode
				if (activeEditor){

					var iframe = activeEditor.find('iframe')[0];
					var contentDoc = iframe.contentDocument;
					// if there was a successful save, then we need to refresh the page
					if ($('.success', contentDoc).size()){
						top.window.location.reload();
					} else {
						activeEditor.removeClass('__saisai_edit_active__');
						activeEditor.find('.__saisai_edit_marker_inner__, .__saisai_edit_form__').stop().css(resetCss).hide();
						activeEditor = null;
					}
				}
			}
			
			var ajaxSubmit = function($form){
				$form.attr('action', formAction).ajaxSubmit(function(html){
					if ($(html).is('error')){
						var msg = $(html).html();
						if (msg != '' || msg != '1'){
							$form.find('.inline_errors').html(msg).animate( { backgroundColor: '#ee6060'}, 1500);
							$.scrollTo($form);
						}
					} else {
						closeEditor();
						window.location.reload(true);
					}
					return false;
				});
			}
			
			// set up cancel button
			$('.__saisai_edit__ .ico_cancel').on('click', function(){
				closeEditor();
				return false;
			});

			// set up save
			$('.__saisai_edit__ .ico_save').on('click', function(){
				$form = $(this).parents('.__saisai_edit_form__').find('form');
				ajaxSubmit($form);
				return false;
			});
			$('.__saisai_edit__ .delete').on('click', function(){
				if (confirm(lang('confirm_delete'))){
					$form = $(this).parents('.__saisai_edit_form__').find('form');
					$form.find('.__saisai_inline_action__').val('delete');
					ajaxSubmit($form);
				}
				return false;
			});
			
			editors.each(function(i){
				var $this = $(this);
				var module = $this.attr('data-module');
				var _anchor = $('.__saisai_edit_marker__', this);

				_anchor.mouseover(function(){
					$('.__saisai_edit_marker_inner__', this).stop().css(resetCss).show();
				});

				_anchor.mouseout(function(){
					if ((activeEditor && activeEditor.attr('title') == $this.attr('title'))){
						return;
					} else {
						$('.__saisai_edit_marker_inner__', this).stop().css(resetCss).hide();
					}
				});
				
				_anchor.click(function(e){
					if (!activeEditor || activeEditor != $this){
						
						
						if ($('.__saisai_edit_form__', $this).children().not('img').size() == 0){
							
							var relArr = $(this).attr('rel').split('|');
							var param1 = relArr[0];
							if (module == 'pagevariables'){
								var param2 = pageId;
							} else {
								var param2 = (relArr.length >= 2) ? relArr[1] : '';
							}
							if (param1.substr(0, 6) == 'create'){
								var qString = (param2.length) ? '?' + param2 : param1;
								var url = $(this).attr('href') + qString;
							} else {
								var url = $(this).attr('href') + param1 + '/' + param2;
							}
							var lang = $('#__saisai_language__').val();
							if (lang && lang.length){
								url = url + '?lang=' + $('#__saisai_language__').val();
							}
							

							if (_anchor.next('.__saisai_edit_form__').find('iframe').size() == 0){
								var iframeId = '__saisai_iframe__' + $this.attr('id');
								_anchor.next('.__saisai_edit_form__').html('<div class="loader"></div><iframe src="' + url +'" id="' + iframeId +'" frameborder="0" scrolling="no" class="inline_iframe"></iframe>');
								
								$('#' + iframeId).load(function(){
									var iframe = this;
									var contentDoc = iframe.contentDocument;
									
									// we check for the variable "saved" on the child windo
									// if set to true, then we refresh the entire window so the changes can be seen
									if (iframe.contentWindow.saved){
										closeEditor();
										window.location.reload();
									} else {
										$('.cancel', contentDoc).click(function(e){
											closeEditor();
											
											return false;
										});

										$('#' + iframeId).prev().hide();
										saisai.refreshIframeSize(iframe);
									}
									
								})
								
							} else {
								
								// set the frame size just in case it wasn't set
								var iframe = _anchor.next('.__saisai_edit_form__').find('iframe');
								saisai.setIframeSize(iframe);
							}
							_anchor.next('.__saisai_edit_form__').show();
						} else { 
							_anchor.next('.__saisai_edit_form__').show();
						}
						$('.__saisai_edit_marker_inner__', this).css(resetCss);
						$(this).find('.__saisai_edit_marker_inner__, .__saisai_edit_form__').show();

						$this.addClass('__saisai_edit_active__');

						if (activeEditor && (activeEditor.attr('title') != $this.attr('title'))) {
							closeEditor();
						}
						activeEditor = $this;
					} else {
						closeEditor();
					}
					return false;

				});
			});
		}
		
		function initSAISAIBar(){

			var hideEditors = function(){
				if (useAutoAdjust) $(resizeTags).unbind('resize', refresh);
				
				var elem = $('#__saisai_page_edit_toggle__');
				$('.__saisai_edit__').hide();
				editorsOn = false;

				//elem.text('Show Editable Areas');
				elem.parent('li').removeClass('active');
				$.supercookie('saisai_bar', 'show_editable_areas', '0', {path: cookiePath});
			}

			var showEditors = function(){
				// use the great resize plugin to accomplish this... 
				if (useAutoAdjust) $(resizeTags).bind('resize', refresh);
				refresh(); // just in case things have moved since they were last turned off
				var elem = $('#__saisai_page_edit_toggle__');
				$('.__saisai_edit__').show();
				
				editorsOn = true;
				//elem.text('Hide Editable Areas');
				elem.parent('li').addClass('active');
				$.supercookie('saisai_bar', 'show_editable_areas', '1', {path: cookiePath});
			}
			
			var toggleEditors = function(shown){
				if (shown){
					hideEditors();
				} else {
					showEditors();
				}
			}
			
			$('#__saisai_page_edit_toggle__').click(
				function(){
					toggleEditors(editorsOn);
					return false;
				}
			);

			$('#__saisai_page_tools__').change(function(){
				var url = $(this).val();
				if (url == '') return;
				var html = '<iframe src="' + url +'?id=' + pageId + '&amp;location=' + pageLocation + '" id="tool_output_iframe" frameborder="0" scrolling="no" style="border: none; height: 0px; width: 0px;"></iframe>';
				saisai.modalWindow(html);
				$(this).val('  '); // reset it back to top
				return false;
			});

			$('#__saisai_page_layout__').change(function(){
				$('#__saisai_edit_bar_form__').ajaxSubmit(function(){
					window.location.reload();
				});
				return false;
			});

			$('#__saisai_language__').change(function(){
				var param = $(this).attr('name');
				var lang = $(this).val();
				if ($('#__saisai_language_mode__').val() == 'segment'){
					if ($('#__saisai_language_default__').val() != lang){
						var url = basePath + lang + '/' + pageLocation;	
					} else {
						var url = basePath + pageLocation;
					}
					
				} else {
					var beginUrl = window.location.href.split('?')[0];
					var queryStr = window.location.search.substring(1);
					var regEx = new RegExp('&?' + param + '=[^&]*');

					// remove any lang field values so it doesn't duplicate it in the query string
					queryStr = queryStr.replace(regEx, '');
					queryStr += '&' + param + '=' + lang;
					var url = beginUrl + '?' + queryStr;
				}
				window.location = url;
				return false;
			});

			$('#__saisai_page_publish_toggle__').click(function(e){
				var $this = this;
				var elem = $('#__saisai_page_published__')
				var val = (elem.val() == 'yes') ? 'no' : 'yes';
				elem.val(val);
				
				$('#__saisai_edit_bar_form__').ajaxSubmit(function(){
					window.location.reload();
				});
				return false;
			});

			$('#__saisai_page_cache_toggle__').click(function(e){
				var elem = $('#__saisai_page_cached__')
				var val = (elem.val() == 'yes') ? 'no' : 'yes';
				elem.val(val);
				$('#__saisai_edit_bar_form__').ajaxSubmit(function(){
					window.location.reload();
				});
				return false;
			});

			$('#__saisai_page_others__').change(function(){
				window.location = basePath + $(this).val();
			});

			var hideSaisaiBar = function(animate){
				var elem = $('#__saisai_page_toolbar_toggle__');
				var exposedWidth = 0;
				$('.__saisai__ .exposed').each(function(i){
					exposedWidth += $(this).innerWidth();
				});
				var barHideX = $('#__saisai_edit_bar__').width() - (exposedWidth + 1);
				if (animate){
					$("#__saisai_edit_bar__").animate({ right: '-' + barHideX + 'px'}, 500);
				} else {
					$("#__saisai_edit_bar__").css({ right: '-' + barHideX + 'px'});
				}

				saisaiBarOn = false;
				elem.parent('li').removeClass('active');
				$.supercookie('saisai_bar', 'show_saisai_bar', '0', {path: cookiePath});
			}

			var showSaisaiBar = function(animate){
				var elem = $('#__saisai_page_toolbar_toggle__');
				if (animate){
					$("#__saisai_edit_bar__").show().animate({ right: '0px'}, 500);
				} else {
					$("#__saisai_edit_bar__").show().css({ right: '0px'});
				}
				$('.__saisai_edit_bar__').width();
				saisaiBarOn = true;
				elem.parent('li').addClass('active');
				$.supercookie('saisai_bar', 'show_saisai_bar', '1', {path: cookiePath});
			}
			$('#__saisai_page_toolbar_toggle__').click(
				function(){
					toggleSaisaiBar(saisaiBarOn, true);
					return false;
				}
			);
			
			var toggleSaisaiBar = function(shown, animate){
				if (shown){
					hideSaisaiBar(animate);
				} else {
					showSaisaiBar(animate);
				}
			}
			 // change to negative so it will toggle correctly
			$("#__saisai_edit_bar__").show();
			toggleSaisaiBar(!saisaiBarOn, false);
			toggleEditors(!editorsOn, false);
		}
		
		init();
	});
	
})(jQuery);