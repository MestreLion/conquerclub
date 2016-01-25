var tickerTimer;var minTime = .01;var maxTime = .25;
var totalPages;var currentPage;var gotoUrl;

function togglePagePicker(id) {
  var page_picker = document.getElementById('page_picker_'+id);
//	var page_picker = $('#page_picker_'+id);console.log(page_picker);
	var page_picker_input = document.getElementById('page_picker_input_'+id);
	if(page_picker.style.display == "none") {
		page_picker.style.display = '';
		page_picker_input.value = "";
		page_picker_input.focus();
		page_picker_input.select();
	}
	else {
		page_picker.style.display = 'none';
	}
}

function gotoPage(id) {
//  var page_picker = $('page_picker_'+id);
  var page_picker = document.getElementById('page_picker_'+id);
//	var page_picker_input = $('page_picker_input_'+id);
  var page_picker_input = document.getElementById('page_picker_input_'+id);
	var page = parseInt(page_picker_input.value);
	if(isNaN(page) || page > totalPages || page < 1) {
		page_picker_input.value = '';
		return false;
	}
	page_picker_input.value = '';
	page_picker.style.display = "none";
	window.location = gotoUrl + page;
}

function startTicker(step, id) {
	tickerStartTime = new Date();
	updateTickerValue(step, id)
	tickerTimer = setTimeout(function() {ticker(step, id)}, maxTime * 1000);
}

function ticker(step, id) {
	var timeStep = ((new Date() - tickerStartTime) / 10000).toFixed(2);
	timeStep = maxTime - timeStep;
	if(timeStep < minTime) {timeStep = minTime;}
	var doNextTick = updateTickerValue(step, id);
	if(doNextTick) {tickerTimer = setTimeout(function() {ticker(step, id)}, timeStep * 1000);}
}

function updateTickerValue(step, id) {
	if (id == 'maps') {
		var map_select = document.getElementById(id);
		var doNextTick = true;
		var value = parseInt(map_select.selectedIndex);
		if(isNaN(value)) {value = currentPage;}
		newValue = value + step;
		if(newValue > map_select.options.length - 1) {newValue = 0;}
		if(newValue < 0) {newValue = map_select.options.length - 1;}
		map_select.selectedIndex = newValue;
		setThumb(newValue);
		return doNextTick;
	}
	else {
		var page_picker_input = $('page_picker_input_'+id);
		var doNextTick = true;
		var value = parseInt(page_picker_input.value);
		if(isNaN(value)) {value = currentPage;}
		newValue = value + step;
		if(newValue > totalPages) {newValue = totalPages; doNextTick = false;}
		if(newValue < 1) {newValue = 1; doNextTick = false;}
		page_picker_input.value = newValue;
		return doNextTick;
	}
}

function setThumb(val)
{
	if (val >= 0) {
		map_link.href = 'http://maps.conquerclub.com/' + mapFiles[val];
		map_link.title = mapTitles[val] + ',' + mapTopics[val];
		map_thumb.style.backgroundImage = 'url(http://maps.conquerclub.com/'+ mapThumbs[val] + ')';
		map_thumb.src = (mapStatuses[val] == 'B') ? 'http://static.conquerclub.com/map_beta.png' : 'http://static.conquerclub.com/map_normal.png';
		map_thumb.title = mapTitles[val];
		map_thumb.alt = mapTitles[val];
	}
}

function setThumbs(opts)
{
	var thumbs = '';
	for (var i = 0; i < opts.length; i++) {
		if (opts[i].selected) {
			var map_status = (mapStatuses[i] == 'B') ? 'http://static.conquerclub.com/map_beta.png' : 'http://static.conquerclub.com/map_normal.png';
			thumbs += ' <a href="http://maps.conquerclub.com/' + mapFiles[i] + '" rel="lightbox" title="' + mapTitles[i] + ',' + mapTopics[i] + '"><img style="background-image:url(http://maps.conquerclub.com/'+ mapThumbs[i] + ')" src="' + map_status + '" width="50" height="34" alt="' + mapTitles[i] + '" title="' + mapTitles[i] + '" /></a>';
		}
	}
	map_thumbs.innerHTML = thumbs;
	initLightbox();
}

function toggleDisplay(item)
{
	var elm = document.getElementById("item_" + item);
	if (elm){ elm.style.display = ( elm.style.display != "none")?"none":""; }
}

//function $(id) {return document.getElementById(id);}
function stopTicker() {clearTimeout(tickerTimer);}
function keyCheck(e, id) {var key;if(window.event) {key = e.keyCode;} else {key = e.which;};if(key == 13) {gotoPage(id);};}

document.onmouseup = stopTicker;
