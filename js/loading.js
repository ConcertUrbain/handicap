
$(function(){
	$("#loading-layer").hide();
});

function callLoadingLayer(){
	$("#loading-layer").show();
}

function hideLoadingLayer(){
	$("#loading-layer").fadeOut(100);
}