//初始化相关元素高度
function init(){
	$("body").height($(window).height());
	$('#iframe-main').height($(window).height() - 50);
	$("#sidebar").height($(window).height());
}
/**
 * 调整工作区尺寸
 */
function resizeContentHeight() {
	var mainHeight = document.body.clientHeight - 98;
	$('#iframe-main').height(mainHeight);
}
$(function(){
	init();
	$(window).resize(function(){
		init();
	});
});
$(window).load(function() {
	resizeContentHeight();
});

$(window).resize(function() {
	resizeContentHeight();
});

// This function is called from the pop-up menus to transfer to
// a different page. Ignore if the value returned is a null string:
function goPage (newURL) {
	// if url is empty, skip the menu dividers and reset the menu selection to default
	if (newURL != "") {
		// if url is "-", it is this page -- reset the menu:
		if (newURL == "-" ) {
			resetMenu();
		}
		// else, send page to designated URL
		else {
			document.location.href = newURL;
		}
	}
}
	
// resets the menu selection upon entry to this page:
function resetMenu() {
	document.gomenu.selector.selectedIndex = 2;
}

// uniform使用示例：
// $.uniform.update($(this).attr("checked", true));