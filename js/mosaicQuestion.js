$(function(){
	var video = $(".videoPlayer")[0];
  if(video == null) return;
  
	//console.log(video);
	video.addEventListener("ended", function(e){
		//console.log("video paused");
		videoEnded();
	}, false);
});