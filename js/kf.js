;
(function ($, window) {
	var keImg = 'images/sinaicon.jpg',
		ownImg = 'images/customicon.jpg',
		productSelect = $('#imProductCurrent'),
		productList = $('#imProductList'),
		sendTypeSelect = $('#sendTypeSelect'),
		sendTypeList = $('#sendTypeList'),
		contentBox = $('#imContents'),
		msg = $('#inputMsg'),
		send = $('#sendQuestion'),
		close = $('#closeWin'),
		api = 'control/AnswerApi.php',//访问API
		ctrl = false,
		/**
		 * Ajax 访问
		 * @param url
		 * @param methord
		 * @param data
		 * @param success
		 * @param error
		 */
		ajax = function (url, methord, data, success, error) {
			$.ajax({
				url: url,
				type: methord,
				data: data,
				dataType: 'json',
				success: success || function () {
				},
				error: error || function () {
					alert('请求服务器错误！');
				}
			})
		},
		/**
		 * 初始话事件
		 */
		initEvents = function () {
			//产品线
			productSelect.on('click', function (e) {
				e.stopPropagation();
				e.preventDefault();
				productList.fadeToggle();
			});
			productList.on('click', 'li', function (e) {
				e.preventDefault();
				var $this = $(this);
				if (!$this.hasClass('current')) {
					productList.find('li').removeClass('current');
					$this.addClass('current');
					productSelect.find('span').text($this.data('product'));
					clickAnswer(6, $this.data('product'));
				}
			});
			//发送方式
			sendTypeSelect.on('click', function (e) {
				e.stopPropagation();
				e.preventDefault();
				sendTypeList.fadeToggle();
			});
			sendTypeList.on('click', 'li', function (e) {
				e.preventDefault();
				var $this = $(this);
				if (!$this.hasClass('current')) {
					sendTypeList.find('li').removeClass('current');
					$this.addClass('current');
					ctrl = ($this.data('ctrl') == true || $this.data('ctrl') == 'true');
				}
			});
			$(document).on('click', function () {
				productList.fadeOut();
				sendTypeList.fadeOut();
			});
			//点击获取快速答案
			contentBox.on('click', '.clickAnswers a', function (e) {
				e.preventDefault();
				var word = $(this).data('word');
				word && clickAnswer(5, word);
			});
			//问问题
			send.on('click', function (e) {
				e.preventDefault();
				inputAnswer();
			});
			msg.on('keydown', function (e) {
				if (ctrl && e.keyCode == 13 && e.ctrlKey) {
					e.stopPropagation();
					e.preventDefault();
					inputAnswer();
				} else if (!ctrl && e.keyCode == 13 && !e.ctrlKey) {
					e.stopPropagation();
					e.preventDefault();
					inputAnswer();
				}
			});
			//反馈
			contentBox.on('click', '.feedback', function (e) {
				e.preventDefault();
				var $this = $(this);
				feedback($this.data('listid'), $this.data('x'));
			});
			//关闭
			close.on('click', function (e) {
				e.stopPropagation();
				e.preventDefault();
				if (confirm('确认要结束对话么？')) {
					closePage();
				}
			})
		},
		/**
		 * 关闭页面
		 */
		closePage = function () {
			if (navigator.userAgent.indexOf("MSIE") > 0) {
				if (navigator.userAgent.indexOf("MSIE 6.0") > 0) {
					window.opener = null;
					window.close();
				}
				else {
					window.open('', '_top');
					window.top.close();
				}
			}
			else if (navigator.userAgent.indexOf("Firefox") > 0) {
				window.location.href = 'about:blank ';
			}
			else {
				window.opener = null;
				window.open('', '_self', '');
				window.close();
			}
		},
		/**
		 * 渲染答案消息
		 * @param data
		 */
		renderAnswer = function (data) {
			var renderAnswerCase3 = function () {
					data = data.data;
					var htmls = [];
					htmls.push('<div class="wordMsgServe clickAnswers">',
						'<div class="wordMsgFace">',
						'<img src="', keImg, '" alt="">',
						'<span class="wordMsgMaster">遮罩</span>',
						'</div>',
						'<div class="wordContent">',
						'<div class="wordMain">',
						'<span class="wordArrwoLeft">箭头</span>',
						'<div class="wordInfor">',
						data.msg,
						'</div></div></div>');
					contentBox.append(htmls.join(''));
				},
				renderAnswerCase5 = function () {
					data = data.data;
					var htmls = [];
					htmls.push('<div class="wordMsgServe clickAnswers">',
						'<div class="wordMsgFace">',
						'<img src="', keImg, '" alt="">',
						'<span class="wordMsgMaster">遮罩</span>',
						'</div>',
						'<div class="wordContent">',
						'<div class="wordMain">',
						'<span class="wordArrwoLeft">箭头</span>',
						'<div class="wordInfor">',
						data.answear || data.data || "",
						'</div><div class="bntWrap">',
						'<div class="goodhelp feedback" data-x="1" data-listid="', data.listId, '"><a href="javascript:;">有帮助</a></div>',
						'<div class="badhelp feedback" data-x="0" data-listid="', data.listId, '"><a href="javascript:;">还没有帮我解决问题</a></div>',
						'</div>',
						'</div></div></div>');
					contentBox.append(htmls.join(''));
				},
				renderAnswerCase6 = function () {
					data = data.data;
					var htmls = [];
					htmls.push('<div class="wordMsgServe clickAnswers">' +
					'<div class="wordMsgFace">' +
					'<img src="', keImg, '" alt="">' +
					'<span class="wordMsgMaster">遮罩</span>' +
					'</div>' +
					'<div class="wordContent">' +
					'<div class="wordMain">' +
					'<span class="wordArrwoLeft">箭头</span>' +
					'<div class="wordInfor">' +
					'<div class="qAlist">' +
					'<h4>您好，请问您要咨询哪方面的问题？</h4>');
					$.each(data, function (index, item) {
						htmls.push('<a href="javascript:;" title="', item, '" data-word="', item, '">', item, '</a>');
					});
					htmls.push('</div></div></div></div></div>');
					contentBox.append(htmls.join(''));
				};
			switch (data.code) {
				case 3 :
				case '3':
					renderAnswerCase3();
					break;
				case 4 :
				case '4':
				case 5 :
				case '5':
					renderAnswerCase5();
					break;
				case 2 :
				case '2':
				case 6 :
				case '6':
					renderAnswerCase6();
					break;
			}
			scrollBottom();
		},
		/**
		 * 渲染用户问题
		 * @param text
		 */
		renderQuestion = function (text) {
			contentBox.append(['<div class="wordMsgServe wordMsgServeUser">',
				'<div class="wordMsgFace">',
				'<img src="', ownImg, '" alt="">',
				'<span class="wordMsgMaster">遮罩</span>',
				'</div>',
				'<div class="wordContent">',
				'<div class="wordMain">',
				'<span class="wordArrwoLeft">箭头</span>',
				'<div class="wordInfor">',
				text,
				'</div>',
				'</div>',
				'</div></div>'].join(''));
			scrollBottom();
		},
		/**
		 * 渲染错误信息
		 * @param text
		 */
		renderError = function (text) {
			var htmls = [];
			htmls.push('<div class="wordMsgServe clickAnswers">',
				'<div class="wordMsgFace">',
				'<img src="', keImg, '" alt="">',
				'<span class="wordMsgMaster">遮罩</span>',
				'</div>',
				'<div class="wordContent">',
				'<div class="wordMain">',
				'<span class="wordArrwoLeft">箭头</span>',
				'<div class="wordInfor">',
				text,
				'</div></div></div>');
			contentBox.append(htmls.join(''));
		},
		/**
		 * 滚动到消息底部
		 */
		scrollBottom = function () {
			contentBox.parent().scrollTop(contentBox.height());
		},
		/**
		 * 渲染产品线选择
		 * @param list
		 */
		renderProductLines = function (list) {
			var htmls = [];
			htmls.push('<ul>');
			$.each(list, function (index, item) {
				htmls.push('<li', (index == 0 ? " class=\"current\"" : ""), ' data-product="', item, '"><a href="javascript:;">', item, '</a></li>');
			});
			htmls.push('<ul/>');
			productList.empty().append(htmls.join(''));
			productSelect.find('span').text(list.length ? list[0] : '加载失败');
			list.length && clickAnswer(6, list[0]);
		},
		/**
		 * 反馈
		 * @param listid
		 * @param x
		 */
		feedback = function (listid, x) {
			ajax(api, 'post', {act: 7, word: listid + '_'+ x}, function () {
				renderAnswer({
					code: 3,
					data: {
						msg:  x == 0 ? '您也可以拨打新浪客服热线 <a href="javascript:;">4006-900-000</a> 反馈相关问题，我们会竭诚为您服务。' : '谢谢反馈'
					}
				});
			});
		},
		/**
		 * 输入问题
		 */
		inputAnswer = function () {
			var text = $.trim(msg.val());
			msg.val('');
			if (!text) {
				return;
			}
			ajax(api, 'post', {act: 0, word: text}, function (data) {
				if (data && (data.result == true || data.result == 'true')) {
					renderAnswer(data);
				} else {
					renderError('出错啦，请稍后再试！');
				}
			});
			renderQuestion(text.replace(/\r|\n/gim, '<br/>'));
		},
		/**
		 * 获取用户点击或默认答案
		 * @param act
		 * @param word
		 */
		clickAnswer = function (act, word) {
			ajax(api, 'post', {act: act, word: word}, function (data) {
				if (data && (data.result == true || data.result == 'true')) {
					renderAnswer(data);
				} else {
					renderError('出错啦，请稍后再试！');
				}
			});
		},
		/**
		 * 初始化产品线
		 */
		initProductLines = function () {
			ajax(api, 'post', {act: 1}, function (data) {
				if (data && (data.code == 1 || data.code == '1')) {
					renderProductLines(data.data.list);
					msg.removeAttr('disabled');
				} else {
					renderError('初始化错误，请稍后再试！');
				}
			}, function () {
				renderError('初始化错误，请稍后再试！');
			});
		};
	$(function () {
		//初始化
		initEvents();
		initProductLines();
	});
})(jQuery, window, undefined);