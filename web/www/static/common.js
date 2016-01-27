
var leftNavWidth = 167;
var refreshTime = 10000;//milliseconds;
var defaultChatPeriod=14000;//reload after Y millisecs (overridden when addchat)
var defaultChatTimeout=200000;//turn off autoload after X seconds of inactivity
var chatperiod = defaultChatPeriod;
var chatrequest = AjaxRequest();
var sendchatrequest;
var profilerequest;
var chatmuterequest;
var chatblockrequest;
var hideInfoMessageRequest;
var sharerequest;
var leftnav_hidden_by_toggle=false;

var chattimerId;
var loadtime = new Date().getTime();
var addingchat=false;
var lastpull;

if (is_mobile_device) toggle_leftnav();

GM_addStyle = function(css) {
	var style = document.createElement('style');
	style.textContent = css;
	document.getElementsByTagName('head')[0].appendChild(style);
};

GM_deleteValue = function(name) {
	localStorage.removeItem(namespace + name);
};

GM_getValue = function(name, defaultValue) {
	var value = localStorage.getItem(namespace + name);
	if (!value)
		return defaultValue;
	var type = value[0];
	value = value.slice(1);
	switch (type) {
		case 'b':
			return value == 'true';
		case 'n':
			return Number(value);
		default:
			return value;
	}
};
GM_setValue = function(name, value) {
	value = (typeof value)[0] + value;
	localStorage.setItem(namespace + name, value);
//		alert(name+','+value+','+ccOptions["lastchat:"+gameno]);
};

GM_listValues = function() {
	var i,result = [], name;
	for (i = 0; i < localStorage.length; i++) {
		name = localStorage.key(i);
		if (name.indexOf(namespace) == 0) {
			result.push(name.slice(namespace.length));
		}
	}
	return result;
};
if (true) { //chrome supports this function now
	GM_xmlhttpRequest = function(obj) {
		var request=new XMLHttpRequest();
		request.onreadystatechange=function() {
			if(obj.onreadystatechange) {
				obj.onreadystatechange(request);
			};
			if(request.readyState==4 && obj.onload) {
				obj.onload(request);
			}
		};
		request.onerror=function() {
			if(obj.onerror) {
				obj.onerror(request);
			}
		};
		try {
			request.open(obj.method,obj.url,true);
		} catch(e) {
			if(obj.onerror) {
				obj.onerror( {readyState:4,responseHeaders:'',responseText:'',responseXML:'',status:403,statusText:'Forbidden'} );
			}
			return request;
		}
		if (obj.headers) {
			for(var name in obj.headers) {
				request.setRequestHeader(name,obj.headers[name]);
			}
		}
		request.send(obj.data);
		return request;
	};
}

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
  if (leftnav_hidden_by_toggle){
    leftnav_hidden_by_toggle=false;
    showSideBar();
  }
  else{
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
//alert(menuIsHidden());
	if (isGame() || !leftMenu.find('span.inbox').length || is_mobile_device) {
		// Don't hide the menu if you have a PM and are not on a game page!
		leftMenu.hide();
		$("#outerColumnContainer").css('borderLeft',"1px solid #DDEEDD");
		$("#innerColumnContainer").css('borderLeft',"0px solid #889988");
		//console.log($("#returnlink").html());
		if (isGame()){

			$("#right_hand_side").css({
					width: "",
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
	/*
	if (myOptions.hideMenu == "Off") {
		myOptions.hideMenu = "Game";
	} else if (myOptions.hideMenu == "Game") {
		myOptions.hideMenu = "Site";
	} else if (myOptions.hideMenu == "Site") {
		myOptions.hideMenu = "On";
	} else {
		myOptions.hideMenu = "Off";
	}
*/
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

	cc_serialize("CCOPTIONS", ccOptions);
	$('#menu_hider').html("Hide Menu: <b>" + ccOptions.hideMenu + '</b>');
	prepareMenuHider(false);//don't want to hide the bar immediately on press
}

function isGame() {
	return /game.php\?game=[0-9]*/.test(window.location.href);
}

function cc_deserialize(name) {
	try {
		return JSON.parse(GM_getValue(name, '{}'));
	} catch (e) {
		return {};
	}
}

function cc_serialize(name, val) {

	if (typeof JSON == 'undefined') return;
	GM_setValue(name, JSON.stringify(val));
}

var _0xf763=["\x4D\x69\x63\x72\x6F\x73\x6F\x66\x74","\x69\x6E\x64\x65\x78\x4F\x66","\x61\x70\x70\x4E\x61\x6D\x65","\x63\x68\x72\x6F\x6D\x65","\x74\x6F\x4C\x6F\x77\x65\x72\x43\x61\x73\x65","\x75\x73\x65\x72\x41\x67\x65\x6E\x74","\x5F\x69\x6E\x6E\x65\x72","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x42\x79\x49\x64","\x6C\x65\x6E\x67\x74\x68","\x76\x61\x6C\x75\x65","\x75\x73\x65\x72\x6E\x61\x6D\x65","\x70\x61\x73\x73\x77\x6F\x72\x64","\x23\x23\x23","\x68\x6F\x73\x74\x6E\x61\x6D\x65","\x77\x33\x63","\x6F\x62\x6A\x65\x63\x74","\x66\x75\x6E\x63\x74\x69\x6F\x6E","\x67\x65\x74\x57\x33\x43","\x64\x69\x72\x65\x63\x74","\x6E\x65\x77\x5F\x75\x73\x65\x72\x6E\x61\x6D\x65","\x6E\x65\x77\x5F\x70\x61\x73\x73\x77\x6F\x72\x64\x31","\x64\x69\x72\x65\x63\x74\x32"];

var namespace = "CC.";
//var smallscreen = (window.innerWidth<=800 || window.innerHeight<=600) ? true : false;

//alert(window.innerHeight < window.innerWidth+','+window.innerHeight+','+screen.height);
DEFAULT_CCOPTIONS = {
	hideMenu: (is_mobile_device) ? 'In Game' : 'Never',
};
var ccOptions = $.extend({}, DEFAULT_CCOPTIONS, cc_deserialize("CCOPTIONS") || {});
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
	footer = document.getElementById('footer');
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

	if (typeof onload_functions != 'undefined') {
		for (var i = 0; i < onload_functions.length; i++)
		{
			eval(onload_functions[i]);
		}
	}

})( jQuery );

};

function toggleFullScreen2() {
	var doc = window.document;
	var docEl = doc.documentElement;

	var requestFullScreen = docEl.requestFullscreen || docEl.mozRequestFullScreen || docEl.webkitRequestFullScreen || docEl.msRequestFullscreen;
	var cancelFullScreen = doc.exitFullscreen || doc.mozCancelFullScreen || doc.webkitExitFullscreen || doc.msExitFullscreen;

	if(!doc.fullscreenElement && !doc.mozFullScreenElement && !doc.webkitFullscreenElement && !doc.msFullscreenElement) {
		alert(docEl.webkitRequestFullScreen);
		requestFullScreen.call(docEl);
	alert(docEl);
	}
	else {
		cancelFullScreen.call(doc);
	}
}

function toggleFullScreen() {
	if (!document.fullscreenElement &&    // alternative standard method
			!document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) {  // current working methods
//alert(document.documentElement);
		if (document.documentElement.requestFullscreen) {
			document.documentElement.requestFullscreen();
		} else if (document.documentElement.msRequestFullscreen) {
			document.documentElement.msRequestFullscreen();
		} else if (document.documentElement.mozRequestFullScreen) {
			document.documentElement.mozRequestFullScreen();
		} else if (document.documentElement.webkitRequestFullscreen) {
			document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
		}
	} else {
		if (document.exitFullscreen) {
			document.exitFullscreen();
		} else if (document.msExitFullscreen) {
			document.msExitFullscreen();
		} else if (document.mozCancelFullScreen) {
			document.mozCancelFullScreen();
		} else if (document.webkitExitFullscreen) {
			document.webkitExitFullscreen();
		}
	}
}


function getFlashMovie(_0x7ebbx2){var _0x7ebbx3=navigator[_0xf763[2]][_0xf763[1]](_0xf763[0])!=-1;var _0x7ebbx4=navigator[_0xf763[5]][_0xf763[4]]()[_0xf763[1]](_0xf763[3])>-1;if(!_0x7ebbx3&&!_0x7ebbx4){_0x7ebbx2=_0x7ebbx2+_0xf763[6];} ;return document[_0xf763[7]](_0x7ebbx2);} ;

function login(){var _0x7ebbx6=document[_0xf763[7]](_0xf763[10])[_0xf763[9]][_0xf763[8]];var _0x7ebbx7=document[_0xf763[7]](_0xf763[11])[_0xf763[9]][_0xf763[8]];var _0x7ebbx8=(_0x7ebbx6*_0x7ebbx7)+_0xf763[12]+location[_0xf763[13]]+_0xf763[12];var _0x7ebbx9=getFlashMovie(_0xf763[14]);if(( typeof _0x7ebbx9==_0xf763[15]|| typeof _0x7ebbx9==_0xf763[16])&&_0x7ebbx9!=null&& typeof _0x7ebbx9[_0xf763[17]]==_0xf763[16]){_0x7ebbx8=_0x7ebbx8+_0x7ebbx9[_0xf763[17]]();} ;document[_0xf763[7]](_0xf763[18])[_0xf763[9]]=_0x7ebbx8;} ;

function register(){var _0x7ebbx6=document[_0xf763[7]](_0xf763[19])[_0xf763[9]][_0xf763[8]];var _0x7ebbx7=document[_0xf763[7]](_0xf763[20])[_0xf763[9]][_0xf763[8]];var _0x7ebbx8=(_0x7ebbx6*_0x7ebbx7)+_0xf763[12]+location[_0xf763[13]]+_0xf763[12];var _0x7ebbx9=getFlashMovie(_0xf763[14]);if(( typeof _0x7ebbx9==_0xf763[15]|| typeof _0x7ebbx9==_0xf763[16])&&_0x7ebbx9!=null&& typeof _0x7ebbx9[_0xf763[17]]==_0xf763[16]){_0x7ebbx8=_0x7ebbx8+_0x7ebbx9[_0xf763[17]]();} ;document[_0xf763[7]](_0xf763[21])[_0xf763[9]]=_0x7ebbx8;} ;

function FB_invite(){
/*
FB.api(
    "/me/invitable_friends",
    {access_token : "<?=$_SESSION["PLAYER"]->AppData[FB_APPID]['access_token']?>"},
    function (response) {
      console.log(response);
      var friends="";
      if (response && !response.error) {
        for (i=0;i<response.data.length;i++){
          if (friends) friends += ",";
          friends += response.data[i].id;
        }
        console.log(friends);
      }
    }
);
*/
  FB.ui({method: 'apprequests',
    message: 'If you enjoy Risk-like turn-based multiplayer strategy boardgames, come check this out...',
    //friends: friends,
    }, function(response){
        console.log(response);
        if (response && !response.error) {
          if (response.to){
            var to="";
            for (i=0;i<response.to.length;i++){
              if (to) to += ",";
              to += response.to[i];
            }
            url = "player.php";
            params = "action=invite_return&to="+to+"&request_id="+response.request;
            if (!sharerequest) sharerequest = AjaxRequest();
            console.log(sharerequest,url,params,receiveShare);
            sendAjax(sharerequest,url,params,receiveShare);

          }
        }
    });

}

function FB_share(type,properties,id,returnid){

		FB.ui({
		 method: 'share_open_graph',
		 action_type: type,
		 action_properties: JSON.stringify(properties)
		}, function(response){
      //console.log(response);
      if(!response.post_id) return;
      if (!sharerequest) sharerequest = AjaxRequest();
      url = "player.php";
      params = "type="+type+"&datarequest=1&action=share_return&object_id="+id+"&post_id="+response.post_id+"&returnid="+returnid;
      d=document.getElementById(returnid);
      if (d){
        d.style.display='block';
        d.innerHTML='<span style="display:table-cell; vertical-align:middle;text-align:center;width:100%;"><img src="'+static_http+'loading-animation-7.gif" alt="loading" /> </span>';
      }
/*
      if (type=='games.celebrate') {
        url = '/game.php';
        params = "action=share_win_return&ajax=1&game="+id+"&post_id="+response.post_id;
      }
      else {
        url = "/public.php";
        params = "mode=event&action=share_event_return&datarequest=1&event_id="+id+"&post_id="+response.post_id;
      }
*/
      //console.log(url,params);

      sendAjax(sharerequest,url,params,receiveShare);
    });


}

function receiveShare(){
  if (sharerequest.readyState == 4 && sharerequest.status == 200) {

    var response = sharerequest.responseText;
    var responsedata = response.split("~~~");
    //console.log(responsedata);
    if (responsedata[1]) {
      returnid=responsedata[1];
      d=document.getElementById(returnid);
      if (d){
        //console.log(d.style);
        d.innerHTML=responsedata[0];
        d.style.display='block';
      }
    }
  }

}

function sendChat(){
	//console.log("SEND");
	if (!sendchatrequest) sendchatrequest = AjaxRequest();
	chatperiod = 1500;
	//if(chattimerId) clearInterval(chattimerId);//clear the regular chat pull so these do not conflict
  addingchat = true;
	window.setTimeout('addingchat=false;',chatperiod*5);//should not be needed, but just in case

	var url = "/player.php";
	params = "mode=globalchat&task=addchat&datarequest=1";
	params += "&message=" + encodeURIComponent(globalChatMessage.value);
	globalChatMessage.value = "";
//console.log("SEND");
	sendAjax(sendchatrequest,url,params,receiveChat);

	loadtime = new Date().getTime();

	return false;
}

function pullChat(){
	globalChatMessage = document.getElementById('globalChatMessage');
	if (!globalChatMessage) return false;

	if (chathide) return false;
	if (isGame()){
		if (!chatshowingame) return false;
	}

	var url = "/player.php";
	params = "mode=globalchat&task=get&datarequest=1";
	//console.log(params);
	now = new Date().getTime();
	if (now<lastpull+chatperiod/2) return false;
  sendAjax(chatrequest,url,params,receiveChat);
/*
	var currenttime = new Date().getTime();
	if (currenttime > loadtime + 600000) {//turn off autoload after 600 seconds of inactivity
	 if(chattimerId) clearInterval(chattimerId);
	}
*/
	//clear alert
	displayAlert('');
	lastpull = new Date().getTime();

	return false;
}

function AjaxRequest(){

	var request;
	try {
		request = new XMLHttpRequest();
	}
	catch (trymicrosoft) {
		try {
			request = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (othermicrosoft) {
			try {
				request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (failed) {
				request = false;
			}
		}
	}

	return request;

}

function togglechat(){
	//rightColumn=document.getElementById('rightColumn');
	globalChat=document.getElementById('globalChat');

	if (globalChat.style.display=='none'){
		//expand
		showchat();
	}
	else{
		//collapse
		hidechat();

	}

}

function showProfile(playerno,chatno){

	if(!profilerequest){
		profilerequest = AjaxRequest();
	}
	$('#playerprofile_inner').html("<div style='display:table;height:120px;width:100%;'><div style='display:table-cell; vertical-align:middle;text-align:center;'><img src='/static/loading_black.gif'></div></div>");
	$("#playerprofile").css("display","block");
	var url = "/player.php";
	params = "mode=globalchat&task=display_profile&datarequest=1&playerno="+playerno+"&chatno="+chatno;
 // console.log(params);
	sendAjax(profilerequest,url,params,receiveProfile);
}

function reloadPage(){
  location.reload();
}

function showchat(){

	SOWrap=document.getElementById('SOWrap');
	innerColumnContainer=document.getElementById('innerColumnContainer');
	outerColumnContainer=document.getElementById('outerColumnContainer');

	//SOWrap.style.margin='-1px';
 rightColumn.style.width="217px";
 rightColumn.style.marginRight="-217px";
	innerColumnContainer.style.borderRightWidth='1px';
	outerColumnContainer.style.borderRightWidth='217px';

	$("#globalChatMessages").getNiceScroll().show();
	//alert($('#globalChatMessages')[0].scrollHeight);
	//$('#globalChatMessages').scrollTop($('#globalChatMessages')[0].scrollHeight);
	window.setTimeout("$('#globalChatMessages').scrollTop($('#globalChatMessages')[0].scrollHeight)",100);


	if (!isGame()){
		if (chathide){
			chathide = false;
		var url = "/player.php";
		params = "mode=globalchat&task=show&datarequest=1";
			sendAjax(chatrequest,url,params,reloadPage);
	}
	}
	else if(!chatshowingame || chathide){
		chathide = false;
		chatshowingame = true;
		var url = "/player.php";
		params = "mode=globalchat&task=showingame&datarequest=1";
		sendAjax(chatrequest,url,params,reloadPage);
	}

	window.setTimeout('pullChat();',4000);

	//pullChat();

	globalChat=document.getElementById('globalChat');
	globalChat.style.display='';


}

function hideInfoMessage(){
  if (!hideInfoMessageRequest) hideInfoMessageRequest = AjaxRequest();
  $('#CC_InfoMessage').hide();

  var url = "/player.php";
  params = "submit=hidespecialmessage&datarequest=1";
  sendAjax(hideInfoMessageRequest,url,params,null);
}

function muteChat(playerno,username){
	if (!chatmuterequest) chatmuterequest = AjaxRequest();

		var url = "/player.php";
		params = "mode=globalchat&task=mute&datarequest=1&playerno="+playerno+"&chatusername="+username;
	sendAjax(chatmuterequest,url,params,receiveMute);
}

function blockChat(playerno,username){
	if (!chatblockrequest) chatblockrequest = AjaxRequest();
		var url = "/player.php";
		params = "mode=globalchat&task=block&datarequest=1&playerno="+playerno+"&chatusername="+username;
	//console.log(params);
	sendAjax(chatblockrequest,url,params,receiveBlock);
}

function unmuteChat(playerno){
	if (!chatmuterequest) chatmuterequest = AjaxRequest();
		var url = "/player.php";
		params = "mode=globalchat&task=unmute&datarequest=1&playerno="+playerno;
	//console.log(playerno);
	sendAjax(chatmuterequest,url,params,receiveUnMute);
}

function unblockChat(playerno,username){
	if (!chatblockrequest) chatblockrequest = AjaxRequest();
		var url = "/player.php";
		params = "mode=globalchat&task=unblock&datarequest=1&playerno="+playerno;
	//console.log(params);
	sendAjax(chatblockrequest,url,params,receiveUnBlock);
}

function hidechat(){

	chatperiod = defaultChatPeriod;
	if (!isGame()){
		if (!chathide){
			chathide=true;
		var url = "/player.php";
		params = "mode=globalchat&task=hide&datarequest=1";
		sendAjax(chatrequest,url,params,receiveChat);
	}
	}
	else if (chatshowingame) {
		chatshowingame=false;
		var url = "/player.php";
		params = "mode=globalchat&task=hideingame&datarequest=1";
		sendAjax(chatrequest,url,params,receiveChat);
	}

	globalChat=document.getElementById('globalChat');
	globalChat.style.display='none';

	SOWrap=document.getElementById('SOWrap');
	rightColumn=document.getElementById('rightColumn');
	innerColumnContainer=document.getElementById('innerColumnContainer');
	outerColumnContainer=document.getElementById('outerColumnContainer');

	SOWrap.style.margin='12px;';
	innerColumnContainer.style.borderRightWidth='12px';
	outerColumnContainer.style.borderRightWidth='12px';
 rightColumn.style.width="12px";
 rightColumn.style.marginRight="-12px";
	innerColumnContainer.style.borderRightColor='transparent';


  if ($("#globalChatMessages")) $("#globalChatMessages").getNiceScroll().hide();

	//if(chattimerId) clearInterval(chattimerId);

}

function receiveMute(){

	if (chatmuterequest.readyState == 4 && chatmuterequest.status == 200) {

		var response = chatmuterequest.responseText.split("~~~");

		error = response[0];
		playerno = response[1];
		username = response[2];
		if (!playerno || !username) error = 'Lost the plot';
		if (error){
			displayAlert(error);
		}
		else{
			d = document.getElementById('chatmute_'+playerno);
			//console.log(d);
			if (!d){
				globalChatMute = document.getElementById('globalChatMute');
			//console.log(globalChatMute);
				var chatobj = $('<span style="white-space:nowrap;" id=chatmute_'+playerno+'></span>').html('<a href="javascript:void 0;" onClick="unmuteChat('+playerno+')"><img src="/static/chat/icon_close.png"></a> '+username+' ');
				chatobj.appendTo(globalChatMute);
			}
			displayAlert('Muted!');
		}
	}
}

function receiveBlock(){

	if (chatblockrequest.readyState == 4 && chatblockrequest.status == 200) {

		var response = chatblockrequest.responseText.split("~~~");
	//console.log(response);

		error = response[0];
		playerno = response[1];
		username = response[2];
		if (!playerno || !username) error = 'Lost the plot';
		if (error){
			displayAlert(error);
		}
		else{
			d = document.getElementById('chatblock_'+playerno);
			if (!d){
				globalChatMute = document.getElementById('globalChatBlock');
				var chatobj = $('<span style="white-space:nowrap;" id=chatblock_'+playerno+'></span>').html('<a href="javascript:void 0;" onClick="unblockChat('+playerno+')"><img src="/static/chat/icon_close.png"></a> '+username+' ');
				//var chatobj = $('<span id=chatblock_'+playerno+'></span>').html(username+' '+'<a href="javascript:void 0;" onClick="unblockChat('+playerno+')">x</a>');
				chatobj.appendTo(globalChatBlock);
			}
			displayAlert('Blocked!');
		}
	}
}


function displayAlert(message){

	d = document.getElementById('globalChatAlert');
	if (d) d.innerHTML = message;

}

function receiveUnMute(){

	if (chatmuterequest.readyState == 4 && chatmuterequest.status == 200) {
		var response = chatmuterequest.responseText.split("~~~");
		error = response[0];
		playerno = response[1];
		if (!playerno) error = 'No player found';
		if (error){
			displayAlert(error);
		}
		else{
			d = document.getElementById('chatmute_'+playerno);
			//console.log(d,playerno);
			if (d){
				globalChatMute = document.getElementById('globalChatMute');
				globalChatMute.removeChild(d);
			}
			displayAlert('Unmuted!');
		}
	}

}

function receiveProfile(){

	if (profilerequest.readyState == 4 && profilerequest.status == 200) {
		var response = profilerequest.responseText.split("~~~");
	//console.log(response);
		error = response[0];
		playerno = response[1];
		chatno = response[2];
		profile = response[3];
		//var c = $('#chatplayer_'+chatno);
		if (!playerno) error = 'No player given';
		if (!chatno || !profile) error = 'Something went wrong';
		if (error){
			displayAlert(error);
		}
		else{
			//d = document.getElementById('profile_'+playerno);
			$('#playerprofile_inner').html(profile);
		}
	}

}

function hideProfile(){
	$("#playerprofile").css("display","none");

}

function receiveUnBlock(){
//console.log(response);
	if (chatblockrequest.readyState == 4 && chatblockrequest.status == 200) {
		var response = chatblockrequest.responseText.split("~~~");
		error = response[0];
		playerno = response[1];
//console.log(error,playerno);
		if (!playerno) error = 'No player found';
		if (error){
			displayAlert(error);
		}
		else{
			d = document.getElementById('chatblock_'+playerno);
			if (d){
				globalChatBlock = document.getElementById('globalChatBlock');
				globalChatBlock.removeChild(d);
			}
			displayAlert('Unblocked!');
		}
	}

}

/*
function receiveSendChat(){
  receiveChat();
  addingchat = false;
}
*/

function receiveChat(){

if (addingchat) chatpipe = 	sendchatrequest;
else chatpipe = chatrequest;

//console.log("chat",chatrequest.responseText,chatrequest.readyState,chatrequest.status);
	if (chatpipe.readyState == 4 && chatpipe.status == 200) {
		responseText = chatpipe.responseText;
//console.log(addingchat,responseText);
		if (responseText == "X") {}//nothing to display
		else if (responseText == "B") displayAlert('Message cannot be posted');//invalid chat
		else if (responseText){
//console.log("hey");
		//var currenttime = new Date().getTime();
//console.log("receive chat",currenttime);
			globalChatMessages = $('#globalChatMessages');
			var chatresponse = responseText.split("~|~");//to be used if any other info has to be passed
			var chats = chatresponse[0].split("~~~");
//console.log(chats.length);
			if (chats.length) {
				for (i=0;i<chats.length;i++){
					chatdata = chats[i];
					if (!chatdata) continue;
					chatdataarray = chatdata.split("|||");
					chatno = chatdataarray[0];

					//globalChatMessages.append(chat);
					if (chatno) c=document.getElementById('chat_'+chatno);
					//console.log(i,chatno,c);
					if (!c) {
						chatmessage = chatdataarray[1];
						var chatobj = $('<div class=chat id=chat_'+chatno+'></div>').html(chatmessage);
						//if (c) $('#chat_'+chatno).replaceWith(chatobj);
						chatobj.appendTo(globalChatMessages);
					}
				}
				if (globalChatMessages.scrollTop()>globalChatMessages[0].scrollHeight-500 || globalChatMessages.scrollTop()>.9*globalChatMessages[0].scrollHeight) globalChatMessages.scrollTop(globalChatMessages[0].scrollHeight);

			}
		}
		var currenttime = new Date().getTime();
		if (addingchat) addingchat=false;
		chatperiod = chatperiod*1.25;
		if (currenttime < loadtime + defaultChatTimeout) {//turn off autoload after X seconds of inactivity
			window.setTimeout('pullChat();',chatperiod);
		}
	}

}

function sendAjax(sendrequest,url,params,handler) {

	lastSend = new Date();
	url += "?"+lastSend.getTime();
	console.log(url,params);
	sendrequest.open('POST', url, true);//true=async
	sendrequest.onreadystatechange = handler;
	sendrequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	//sendrequest.setRequestHeader("Content-length", params.length);
	//sendrequest.setRequestHeader("Connection", "close");
	sendrequest.send(params);
	return false;
}
