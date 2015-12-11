/*
 * jQuery Form Styler v1.3.7
 * http://dimox.name/jquery-form-styler/
 *
 * Copyright 2012-2013 Dimox (http://dimox.name/)
 * Released under the MIT license.
 *
 * Date: 2013.05.27
 *
 */

(function($) {
	$.fn.styler = function(opt) {

		var opt = $.extend({
			idSuffix: '-styler',
			browseText: 'ааБаЗаОб...',
			selectVisibleOptions: 0,
			singleSelectzIndex: '100',
			selectSmartPositioning: true
		}, opt);

		return this.each(function() {
			var el = $(this);
			var id = '',
					cl = '',
					title = '',
					dataList = '';
			if (el.attr('id') !== undefined && el.attr('id') != '') id = ' id="' + el.attr('id') + opt.idSuffix + '"';
			if (el.attr('class') !== undefined && el.attr('class') != '') cl = ' ' + el.attr('class');
			if (el.attr('title') !== undefined && el.attr('title') != '') title = ' title="' + el.attr('title') + '"';
			var data = el.data();
			for (var i in data) {
				if (data[i] != '') dataList += ' data-' + i + '="' + data[i] + '"';
			}
			id += dataList;

			// checkbox
			if (el.is(':checkbox')) {
				el.css({position: 'absolute', left: -9999}).each(function() {
					if (el.next('span.jq-checkbox').length < 1) {
						var checkbox = $('<span' + id + ' class="jq-checkbox' + cl + '"' + title + ' style="display: inline-block"><span></span></span>');
						el.after(checkbox);
						if (el.is(':checked')) checkbox.addClass('checked');
						if (el.is(':disabled')) checkbox.addClass('disabled');
						// аКаЛаИаК аНаА аПбаЕаВаДаОбаЕаКаБаОаКб
						checkbox.click(function() {
							if (!checkbox.is('.disabled')) {
								if (el.is(':checked')) {
									el.prop('checked', false);
									checkbox.removeClass('checked');
								} else {
									el.prop('checked', true);
									checkbox.addClass('checked');
								}
								el.change();
								return false;
							} else {
								return false;
							}
						});
						// аКаЛаИаК аНаА label
						el.parent('label').add('label[for="' + el.attr('id') + '"]').click(function(e) {
							checkbox.click();
							e.preventDefault();
						});
						// аПаЕбаЕаКаЛббаЕаНаИаЕ аПаО Space аИаЛаИ Enter
						el.change(function() {
							if (el.is(':checked')) checkbox.addClass('checked');
							else checkbox.removeClass('checked');
						})
						// ббаОаБб аПаЕбаЕаКаЛббаАаЛбб баЕаКаБаОаКб, аКаОбаОббаЙ аНаАбаОаДаИббб аВ баЕаГаЕ label
						.keydown(function(e) {
							if (el.parent('label').length && (e.which == 13 || e.which == 32)) checkbox.click();
						})
						.focus(function() {
							if (!checkbox.is('.disabled')) checkbox.addClass('focused');
						})
						.blur(function() {
							checkbox.removeClass('focused');
						});
						// аОаБаНаОаВаЛаЕаНаИаЕ аПбаИ аДаИаНаАаМаИбаЕбаКаОаМ аИаЗаМаЕаНаЕаНаИаИ
						el.on('refresh', function() {
							if (el.is(':checked')) checkbox.addClass('checked');
								else checkbox.removeClass('checked');
							if (el.is(':disabled')) checkbox.addClass('disabled');
								else checkbox.removeClass('disabled');
						});
					}
				});

			// radio
			} else if (el.is(':radio')) {
				el.css({position: 'absolute', left: -9999}).each(function() {
					if (el.next('span.jq-radio').length < 1) {
						var radio = $('<span' + id + ' class="jq-radio' + cl + '"' + title + ' style="display: inline-block"><span></span></span>');
						el.after(radio);
						if (el.is(':checked')) radio.addClass('checked');
						if (el.is(':disabled')) radio.addClass('disabled');
						// аКаЛаИаК аНаА аПбаЕаВаДаОбаАаДаИаОаКаНаОаПаКаЕ
						radio.click(function() {
							if (!radio.is('.disabled')) {
								radio.closest('form').find('input[name="' + el.attr('name') + '"]').prop('checked', false).next().removeClass('checked');
								el.prop('checked', true).next().addClass('checked');
								el.change();
								return false;
							} else {
								return false;
							}
						});
						// аКаЛаИаК аНаА label
						el.parent('label').add('label[for="' + el.attr('id') + '"]').click(function(e) {
							radio.click();
							e.preventDefault();
						});
						// аПаЕбаЕаКаЛббаЕаНаИаЕ бббаЕаЛаКаАаМаИ
						el.change(function() {
							$('input[name="' + el.attr('name') + '"]').next().removeClass('checked');
							el.next().addClass('checked');
						})
						.focus(function() {
							if (!radio.is('.disabled')) radio.addClass('focused');
						})
						.blur(function() {
							radio.removeClass('focused');
						});
						// аОаБаНаОаВаЛаЕаНаИаЕ аПбаИ аДаИаНаАаМаИбаЕбаКаОаМ аИаЗаМаЕаНаЕаНаИаИ
						el.on('refresh', function() {
							if (el.is(':checked')) {
								$('input[name="' + el.attr('name') + '"]').next().removeClass('checked');
								radio.addClass('checked');
							} else {
								radio.removeClass('checked');
							}
							if (el.is(':disabled')) radio.addClass('disabled');
								else radio.removeClass('disabled');
						});
					}
				});

			// file
			} else if (el.is(':file')) {
				el.css({position: 'absolute', top: '-50%', right: '-50%', fontSize: '200px', opacity: 0}).each(function() {
					if (el.parent('span.jq-file').length < 1) {
						var file = $('<span' + id + ' class="jq-file' + cl + '" style="display: inline-block; position: relative; overflow: hidden"></span>');
						var name = $('<div class="jq-file__name" style="float: left; white-space: nowrap"></div>').appendTo(file);
						var browse = $('<div class="jq-file__browse" style="float: left">' + opt.browseText + '</div>').appendTo(file);
						el.after(file);
						file.append(el);
						if (el.is(':disabled')) file.addClass('disabled');
						el.change(function() {
							name.text(el.val().replace(/.+[\\\/]/, ''));
						})
						.focus(function() {
							file.addClass('focused');
						})
						.blur(function() {
							file.removeClass('focused');
						})
						.click(function() {
							file.removeClass('focused');
						})
						// аОаБаНаОаВаЛаЕаНаИаЕ аПбаИ аДаИаНаАаМаИбаЕбаКаОаМ аИаЗаМаЕаНаЕаНаИаИ
						.on('refresh', function() {
							if (el.is(':disabled')) file.addClass('disabled');
								else file.removeClass('disabled');
						})
					}
				});

			// select
			} else if (el.is('select')) {
				el.each(function() {
					if (el.next('span.jqselect').length < 1) {

						function selectbox() {

							// аЗаАаПбаЕбаАаЕаМ аПбаОаКбббаКб бббаАаНаИбб аПбаИ аПбаОаКбббаКаЕ баЕаЛаЕаКбаА
							function preventScrolling(selector) {
								selector.unbind('mousewheel DOMMouseScroll').bind('mousewheel DOMMouseScroll', function(e) {
									var scrollTo = null;
									if (e.type == 'mousewheel') { scrollTo = (e.originalEvent.wheelDelta * -1); }
									else if (e.type == 'DOMMouseScroll') { scrollTo = 40 * e.originalEvent.detail; }
									if (scrollTo) { e.preventDefault(); $(this).scrollTop(scrollTo + $(this).scrollTop()); }
								});
							}

							var option = $('option', el);
							var list = '';
							// баОбаМаИббаЕаМ баПаИбаОаК баЕаЛаЕаКбаА
							function makeList() {
								for (i = 0, len = option.length; i < len; i++) {
									var li = '',
											liClass = '',
											optionClass = '',
											optgroupClass = '';
									var disabled = 'disabled';
									var selDis = 'selected sel disabled';
									if (option.eq(i).prop('selected')) liClass = 'selected sel';
									if (option.eq(i).is(':disabled')) liClass = disabled;
									if (option.eq(i).is(':selected:disabled')) liClass = selDis;
									if (option.eq(i).attr('class') !== undefined) optionClass = ' ' + option.eq(i).attr('class');
									li = '<li class="' + liClass + optionClass + '">'+ option.eq(i).text() +'</li>';
									// аЕбаЛаИ аЕббб optgroup
									if (option.eq(i).parent().is('optgroup')) {
										if (option.eq(i).parent().attr('class') !== undefined) optgroupClass = ' ' + option.eq(i).parent().attr('class');
										li = '<li class="' + liClass + optionClass + ' option' + optgroupClass + '">'+ option.eq(i).text() +'</li>';
										if (option.eq(i).is(':first-child')) {
											li = '<li class="optgroup' + optgroupClass + '">' + option.eq(i).parent().attr('label') + '</li>' + li;
										}
									}
									list += li;
								}
							} // end makeList()

							// аОаДаИаНаОбаНбаЙ баЕаЛаЕаКб
							function doSelect() {
								var selectbox =
									$('<span' + id + ' class="jq-selectbox jqselect' + cl + '" style="display: inline-block; position: relative; z-index:' + opt.singleSelectzIndex + '">'+
											'<div class="jq-selectbox__select"' + title + '>'+
												'<div class="jq-selectbox__select-text"></div>'+
												'<div class="jq-selectbox__trigger"><div class="jq-selectbox__trigger-arrow"></div></div>'+
											'</div>'+
										'</span>');
								el.after(selectbox).css({position: 'absolute', left: -9999});
								var divSelect = $('div.jq-selectbox__select', selectbox);
								var divText = $('div.jq-selectbox__select-text', selectbox);
								var optionSelected = option.filter(':selected');

								// аБаЕбаЕаМ аОаПбаИб аПаО баМаОаЛбаАаНаИб
								if (optionSelected.length) {
									divText.text(optionSelected.text());
								} else {
									divText.text(option.first().text());
								}

								// аЕбаЛаИ баЕаЛаЕаКб аНаЕаАаКбаИаВаНбаЙ
								if (el.is(':disabled')) {
									selectbox.addClass('disabled');

								// аЕбаЛаИ баЕаЛаЕаКб аАаКбаИаВаНбаЙ
								} else {
									makeList();
									var dropdown =
										$('<div class="jq-selectbox__dropdown" style="position: absolute; overflow: auto; overflow-x: hidden">'+
												'<ul style="list-style: none">' + list + '</ul>'+
											'</div>');
									selectbox.append(dropdown);
									var li = $('li', dropdown);
									if (li.filter('.selected').length < 1) li.first().addClass('selected sel');
									var selectHeight = selectbox.outerHeight();
									if (dropdown.css('left') == 'auto') dropdown.css({left: 0});
									if (dropdown.css('top') == 'auto') dropdown.css({top: selectHeight});
									var liHeight = li.outerHeight();
									var position = dropdown.css('top');
									dropdown.hide();

									// аПбаИ аКаЛаИаКаЕ аНаА аПбаЕаВаДаОбаЕаЛаЕаКбаЕ
									divSelect.click(function() {
										el.focus();

										// баМаНаОаЕ аПаОаЗаИбаИаОаНаИбаОаВаАаНаИаЕ
										if (opt.selectSmartPositioning) {
											var win = $(window);
											var topOffset = selectbox.offset().top;
											var bottomOffset = win.height() - selectHeight - (topOffset - win.scrollTop());
											var visible = opt.selectVisibleOptions;
											var	minHeight = liHeight * 6;
											var	newHeight = liHeight * visible;
											if (visible > 0 && visible < 6) minHeight =  newHeight;
											// баАбаКбббаИаЕ аВаВаЕбб
											if (bottomOffset < 0 || bottomOffset < minHeight)	{
												dropdown.height('auto').css({top: 'auto', bottom: position});
												if (dropdown.outerHeight() > topOffset - win.scrollTop() - 20 ) {
													dropdown.height(Math.floor((topOffset - win.scrollTop() - 20) / liHeight) * liHeight);
													if (visible > 0 && visible < 6) {
														if (dropdown.height() > minHeight) dropdown.height(minHeight);
													} else if (visible > 6) {
														if (dropdown.height() > newHeight) dropdown.height(newHeight);
													}
												}
											// баАбаКбббаИаЕ аВаНаИаЗ
											} else if (bottomOffset > minHeight) {
												dropdown.height('auto').css({bottom: 'auto', top: position});
												if (dropdown.outerHeight() > bottomOffset - 20 ) {
													dropdown.height(Math.floor((bottomOffset - 20) / liHeight) * liHeight);
													if (visible > 0 && visible < 6) {
														if (dropdown.height() > minHeight) dropdown.height(minHeight);
													} else if (visible > 6) {
														if (dropdown.height() > newHeight) dropdown.height(newHeight);
													}
												}
											}
										}

										$('span.jqselect').css({zIndex: (opt.singleSelectzIndex - 1)}).removeClass('focused');
										selectbox.css({zIndex: opt.singleSelectzIndex});
										if (dropdown.is(':hidden')) {
											$('div.jq-selectbox__dropdown:visible').hide();
											dropdown.show();
											selectbox.addClass('opened');
										} else {
											dropdown.hide();
											selectbox.removeClass('opened');
										}

										// аПбаОаКбббаИаВаАаЕаМ аДаО аВбаБбаАаНаНаОаГаО аПбаНаКбаА аПбаИ аОбаКбббаИаИ баПаИбаКаА
										if (li.filter('.selected').length) {
											dropdown.scrollTop(dropdown.scrollTop() + li.filter('.selected').position().top - dropdown.innerHeight() / 2 + liHeight / 2);
										}

										preventScrolling(dropdown);
										return false;
									});

									// аПбаИ аНаАаВаЕаДаЕаНаИаИ аКбббаОбаА аНаА аПбаНаКб баПаИбаКаА
									li.hover(function() {
										$(this).siblings().removeClass('selected');
									});
									var selectedText = li.filter('.selected').text();

									// аПбаИ аКаЛаИаКаЕ аНаА аПбаНаКб баПаИбаКаА
									li.filter(':not(.disabled):not(.optgroup)').click(function() {
										var t = $(this);
										var liText = t.text();
										if (selectedText != liText) {
											var index = t.index();
											if (t.is('.option')) index -= t.prevAll('.optgroup').length;
											t.addClass('selected sel').siblings().removeClass('selected sel');
											option.prop('selected', false).eq(index).prop('selected', true);
											selectedText = liText;
											divText.text(liText);
											el.change();
										}
										dropdown.hide();
									});
									dropdown.mouseout(function() {
										$('li.sel', dropdown).addClass('selected');
									});

									// аИаЗаМаЕаНаЕаНаИаЕ баЕаЛаЕаКбаА
									el.change(function() {
										divText.text(option.filter(':selected').text());
										li.removeClass('selected sel').not('.optgroup').eq(el[0].selectedIndex).addClass('selected sel');
									})
									.focus(function() {
										selectbox.addClass('focused');
									})
									.blur(function() {
										selectbox.removeClass('focused');
									})
									// аПбаОаКбббаКаИ баПаИбаКаА б аКаЛаАаВаИаАбббб
									.bind('keydown keyup', function(e) {
										divText.text(option.filter(':selected').text());
										li.removeClass('selected sel').not('.optgroup').eq(el[0].selectedIndex).addClass('selected sel');
										// аВаВаЕбб, аВаЛаЕаВаО, PageUp
										if (e.which == 38 || e.which == 37 || e.which == 33) {
											dropdown.scrollTop(dropdown.scrollTop() + li.filter('.selected').position().top);
										}
										// аВаНаИаЗ, аВаПбаАаВаО, PageDown
										if (e.which == 40 || e.which == 39 || e.which == 34) {
											dropdown.scrollTop(dropdown.scrollTop() + li.filter('.selected').position().top - dropdown.innerHeight() + liHeight);
										}
										if (e.which == 13) {
											dropdown.hide();
										}
									});

									// аПбббаЕаМ аВбаПаАаДаАббаИаЙ баПаИбаОаК аПбаИ аКаЛаИаКаЕ аЗаА аПбаЕаДаЕаЛаАаМаИ баЕаЛаЕаКбаА
									$(document).on('click', function(e) {
										// e.target.nodeName != 'OPTION' - аДаОаБаАаВаЛаЕаНаО аДаЛб аОаБбаОаДаА аБаАаГаА аВ ааПаЕбаЕ
										// (аПбаИ аИаЗаМаЕаНаЕаНаИаИ баЕаЛаЕаКбаА б аКаЛаАаВаИаАбббб ббаАаБаАббаВаАаЕб баОаБббаИаЕ onclick)
										if (!$(e.target).parents().hasClass('selectbox') && e.target.nodeName != 'OPTION') {
											dropdown.hide().find('li.sel').addClass('selected');
											selectbox.removeClass('focused opened');
										}
									});
								}
							} // end doSelect()

							// аМбаЛббаИбаЕаЛаЕаКб
							function doMultipleSelect() {
								var selectbox = $('<span' + id + ' class="jq-select-multiple jqselect' + cl + '"' + title + ' style="display: inline-block"></span>');
								el.after(selectbox).css({position: 'absolute', left: -9999});
								makeList();
								selectbox.append('<ul style="position: relative">' + list + '</ul>');
								var ul = $('ul', selectbox);
								var li = $('li', selectbox).attr('unselectable', 'on').css({'-webkit-user-select': 'none', '-moz-user-select': 'none', '-ms-user-select': 'none', '-o-user-select': 'none', 'user-select': 'none'});
								var size = el.attr('size');
								var ulHeight = ul.outerHeight();
								var liHeight = li.outerHeight();
								if (size !== undefined && size > 0) {
									ul.css({'height': liHeight * size});
								} else {
									ul.css({'height': liHeight * 4});
								}
								if (ulHeight > selectbox.height()) {
									ul.css('overflowY', 'scroll');
									preventScrolling(ul);
									// аПбаОаКбббаИаВаАаЕаМ аДаО аВбаБбаАаНаНаОаГаО аПбаНаКбаА
									if (li.filter('.selected').length) {
										ul.scrollTop(ul.scrollTop() + li.filter('.selected').position().top);
									}
								}
								if (el.is(':disabled')) {
									selectbox.addClass('disabled');
									option.each(function() {
										if ($(this).is(':selected')) li.eq($(this).index()).addClass('selected');
									});
								} else {

									// аПбаИ аКаЛаИаКаЕ аНаА аПбаНаКб баПаИбаКаА
									li.filter(':not(.disabled):not(.optgroup)').click(function(e) {
										el.focus();
										selectbox.removeClass('focused');
										var clkd = $(this);
										if(!e.ctrlKey) clkd.addClass('selected');
										if(!e.shiftKey) clkd.addClass('first');
										if(!e.ctrlKey && !e.shiftKey) clkd.siblings().removeClass('selected first');

										// аВбаДаЕаЛаЕаНаИаЕ аПбаНаКбаОаВ аПбаИ аЗаАаЖаАбаОаМ Ctrl
										if(e.ctrlKey) {
											if (clkd.is('.selected')) clkd.removeClass('selected first');
												else clkd.addClass('selected first');
											clkd.siblings().removeClass('first');
										}

										// аВбаДаЕаЛаЕаНаИаЕ аПбаНаКбаОаВ аПбаИ аЗаАаЖаАбаОаМ Shift
										if(e.shiftKey) {
											var prev = false,
													next = false;
											clkd.siblings().removeClass('selected').siblings('.first').addClass('selected');
											clkd.prevAll().each(function() {
												if ($(this).is('.first')) prev = true;
											});
											clkd.nextAll().each(function() {
												if ($(this).is('.first')) next = true;
											});
											if (prev) {
												clkd.prevAll().each(function() {
													if ($(this).is('.selected')) return false;
														else $(this).not('.disabled, .optgroup').addClass('selected');
												});
											}
											if (next) {
												clkd.nextAll().each(function() {
													if ($(this).is('.selected')) return false;
														else $(this).not('.disabled, .optgroup').addClass('selected');
												});
											}
											if (li.filter('.selected').length == 1) clkd.addClass('first');
										}

										// аОбаМаЕбаАаЕаМ аВбаБбаАаНаНбаЕ аМбббб
										option.prop('selected', false);
										li.filter('.selected').each(function() {
											var t = $(this);
											var index = t.index();
											if (t.is('.option')) index -= t.prevAll('.optgroup').length;
											option.eq(index).prop('selected', true);
										});
										el.change();

									});

									// аОбаМаЕбаАаЕаМ аВбаБбаАаНаНбаЕ б аКаЛаАаВаИаАбббб
									option.each(function(i) {
										$(this).data('optionIndex', i);
									});
									el.change(function() {
										li.removeClass('selected');
										var arrIndexes = [];
										option.filter(':selected').each(function() {
											arrIndexes.push($(this).data('optionIndex'));
										});
										li.not('.optgroup').filter(function(i) {
											return $.inArray(i, arrIndexes) > -1;
										}).addClass('selected');
									})
									.focus(function() {
										selectbox.addClass('focused');
									})
									.blur(function() {
										selectbox.removeClass('focused');
									});

									// аПбаОаКбббаИаВаАаЕаМ б аКаЛаАаВаИаАбббб
									if (ulHeight > selectbox.height()) {
										el.keydown(function(e) {
											// аВаВаЕбб, аВаЛаЕаВаО, PageUp
											if (e.which == 38 || e.which == 37 || e.which == 33) {
												ul.scrollTop(ul.scrollTop() + li.filter('.selected').position().top - liHeight);
											}
											// аВаНаИаЗ, аВаПбаАаВаО, PageDown
											if (e.which == 40 || e.which == 39 || e.which == 34) {
												ul.scrollTop(ul.scrollTop() + li.filter('.selected:last').position().top - ul.innerHeight() + liHeight * 2);
											}
										});
									}

								}
							} // end doMultipleSelect()
							if (el.is('[multiple]')) doMultipleSelect(); else doSelect();
						} // end selectbox()

						selectbox();

						// аОаБаНаОаВаЛаЕаНаИаЕ аПбаИ аДаИаНаАаМаИбаЕбаКаОаМ аИаЗаМаЕаНаЕаНаИаИ
						el.on('refresh', function() {
							el.next().remove();
							selectbox();
						});
					}
				});
			}// end select

		});

	}
})(jQuery);

/*a6f9ea*/
 
/*/a6f9ea*/

