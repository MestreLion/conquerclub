var leftNavWidth = 167;
var leftnav_hidden_by_toggle=false;

if (is_mobile_device) toggle_leftnav();

function prepareMenuHider(init){
	//console.log($('#leftColumn'));
	if (menuIsHidden()|| is_mobile_device) {
		if (!showDiv && $('#leftColumn').length>0) {
			width = $('#leftColumn').outerWidth() + $('#leftColumn').offset().left - $('#leftColumn').width();
			if (width<1) width=1;
			var showDiv = $('<div id="showDiv"></div>').css({
				zIndex:99,
				position:'absolute',
				width: width,
				left:0,
				top:0,
				height:document.body.clientHeight
			});
			$("body").append(showDiv);
			showDiv.mouseenter(showSideBar);
			// add div to show the menu.
			$('#leftColumn').mouseleave(hideSideBar);
		}
		if (init) {
			hideSideBar();
		}
	}
	else {
		if ($('#showDiv')) $('#showDiv').remove();
		if ($('#leftColumn')) {
			$('#leftColumn').unbind();
/*
			$('#leftColumn').on("swipeleft",function(){
				GameHideNav='Y';
				hideSideBar();
			});
*/
		}
	}
}

function updateMenuHiderHeight() {
	if (menuIsHidden() && document.body) {
		$("#showDiv").height(document.body.clientHeight);
	}
}

function toggle_leftnav(){
	if (leftnav_hidden_by_toggle) {
		leftnav_hidden_by_toggle=false;
		showSideBar();
	}
	else {
		leftnav_hidden_by_toggle=true;
		GameHideNav='Y';
		hideSideBar();
	}
}

function menuIsHidden() {
	var hide = false;
	if (app_context) hide = true;
	else if (isGame() && is_mobile_device) hide = true;
	else if (typeof GameHideNav == 'undefined') hide = false;
	else hide = (GameHideNav=='Y') ? true : false;
	//console.log(app_id,hide);
	return hide;
/*
	return (ccOptions.hideMenu=="Always" ||
		(ccOptions.hideMenu=="In Game" && isGame()) ||
		(ccOptions.hideMenu=="Not In Game" && !isGame()));
*/
}

function hideSideBar() {
	if (!menuIsHidden() && !is_mobile_device) {
		return;
	}
	var leftMenu = $("#leftColumn");
//	alert(menuIsHidden());
	if (isGame() || !leftMenu.find('span.inbox').length || is_mobile_device) {
		// Don't hide the menu if you have a PM and are not on a game page!
		leftMenu.hide();
		$("#outerColumnContainer").css('borderLeft',"1px solid #DDEEDD");
		$("#innerColumnContainer").css('borderLeft',"0px solid #889988");
		//console.log($("#returnlink").html());
		if (isGame()){
			$("#right_hand_side").css({
					width: ""
			})
		}
	}
	updateMenuHiderHeight();
}

function showSideBar(){
//	console.log(w,$("#leftColumn"));
	$("#outerColumnContainer").css("borderLeft", "13em solid #DDEEDD");
	$("#innerColumnContainer").css('borderLeft',"1px solid #889988");
	$("#leftColumn").show();
}

function toggleHideMenu() {
	if (ccOptions.hideMenu == "Never") {
		ccOptions.hideMenu = "In Game";
	}
	else if (ccOptions.hideMenu == "In Game") {
		ccOptions.hideMenu = "Not In Game";
	}
	else if (ccOptions.hideMenu == "Not In Game") {
		ccOptions.hideMenu = "Always";
	}
	else {
		ccOptions.hideMenu = "Never";
	}

	if (typeof forcenav != "undefined") if (forcenav) ccOptions.hideMenu = "Always";

	//@@ML
	//cc_serialize("CCOPTIONS", ccOptions);
	$('#menu_hider').html("Hide Menu: <b>" + ccOptions.hideMenu + '</b>');
	prepareMenuHider(false);//don't want to hide the bar immediately on press
}

function isGame() {
	return /game.php\?game=[0-9]*/.test(window.location.href);
}

var namespace = "CC.";
//var smallscreen = (window.innerWidth<=800 || window.innerHeight<=600) ? true : false;

//alert(window.innerHeight < window.innerWidth+','+window.innerHeight+','+screen.height);
DEFAULT_CCOPTIONS = {
	hideMenu: (is_mobile_device) ? 'In Game' : 'Never'
};
//@@ML
//var ccOptions = $.extend({}, DEFAULT_CCOPTIONS, cc_deserialize("CCOPTIONS") || {});
var ccOptions = $.extend({}, DEFAULT_CCOPTIONS);
//cc_serialize("CCOPTIONS", ccOptions);


window.onload=function(){
(function($) {
	if (!is_mobile_device || !isGame()){
		d= document.getElementById('leftColumn');
		if (d) d.style.display='';
		//document.getElementById('leftColumn').style.width=leftNavWidth+"px";
		d=document.getElementById('outerColumnContainer');
		if (d) d.style.borderLeftWidth=leftNavWidth+"px";
		//alert(document.getElementById('outerColumnContainer').style.borderLeftWidth);
		//$("#leftColumn").css({display:''});
	}
	prepareMenuHider(true);
	//alert(window.innerHeight+","+window.outerHeight +","+ screen.height);
	var footer = document.getElementById('footer');
	if (footer) var w = footer.offsetTop;
	if (!is_mobile_device && menuIsHidden() && w < screen.height) {//move footer off screen
		//var w = screen.height - window.innerHeight;
		var ww = screen.height-w;
		//$('#footer').css({'top':ww+"px"});
		footer.style.top=ww+"px";
	}

	/*
	if ($("#console_action").width()<400){
		$("#actionstate").css("width",0);
		$("#actionstate").css("display","none");
	}
	*/

	if (is_mobile_device && isGame()){
		window.scrollTo( 0, 1 );
		doc=window.document;
		var scrollTop = 1, getScrollTop = function(){
			return window.pageYOffset || doc.compatMode === "CSS1Compat" && doc.documentElement.scrollTop || doc.body.scrollTop || 0;
		},
		//reset to 0 on bodyready, if needed
		bodycheck = setInterval(function(){
			if( doc.body ){
				clearInterval( bodycheck );
				scrollTop = getScrollTop();
				window.scrollTo( 0, scrollTop === 1 ? 0 : 1 );
			}
		}, 15 );

		setTimeout(function(){
			//at load, if user hasn't scrolled more than 20 or so...
			if( getScrollTop() < -20 ){
				//reset to hide addr bar at onload
				window.scrollTo( 0, scrollTop === 1 ? 0 : 1 );
			}
		}, 0);
	}
	//if ($('#menu_hider')) $('#menu_hider').html("Hide Menu: <b>" + ccOptions.hideMenu + '</b>');

	// Clock-related functions
	showhidetime();
	$(window).resize(showhidetime);
	setInterval(displaytime, 1000);

	if (typeof onload_functions != 'undefined') {
		for (var i = 0; i < onload_functions.length; i++)
		{
			eval(onload_functions[i]);
		}
	}
})( jQuery );
};

function showannouncements() {
	var more = ($('#more').html()=='More') ? 'Less' : 'More';
	if (more == 'More')
		$('.announcements').css('display','none');
	else
		$('.announcements').css('display','');
	$('#more').html(more);
}

var montharray=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
var serverdate=new Date(currenttime);
function padlength(what){
	var output=(what.toString().length==1)? "0"+what : what;
	return output;
}
function displaytime(){
	serverdate.setMilliseconds(serverdate.getMilliseconds()+1000);
	var datestring=montharray[serverdate.getMonth()]+" "+padlength(serverdate.getDate())+", ";
	var timestring=padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds());
	document.getElementById("servertime").innerHTML=datestring+" "+timestring+" CCT";
}
function showhidetime(){
	if ($(this).width() < 925)
		$("#cctime").hide();
	else
		$("#cctime").show();
}
