
function initClickMenu(){
	
	pres_hideAll();
	
	$("#pres-intro").show();
	
	$(".pres-link").click(function(e){
	    e.preventDefault();
	    if ($("#videoHTML5").length > 0)
	    	document.getElementById("videoHTML5").pause();
	    var id = $(this).attr('id');
	    if(id != undefined)  
	    	clickCat(id);
	});
}

function clickCat(id){
	
  if (id == "intro") {
	 document.location = "aide.php";
	 return;
  }

  $this = $("#"+id);
  alt = "#"+$this.attr("alt");
  
  pres_hideAll();
  cleanMenuSelection();
  
  $(alt).fadeToggle(200);
  $this.addClass(" selected");
  // $this.css("display", "block");
  
  var v = id == "debat" ? "none" : "block";
  $("#debat").css("display", v);
  $("#video").css("display", v);
  $("#calendar").css("display", v);	  
    
  $("#pres-intro").css("display", id == "intro" ? "block" : "none");	  
  $("#pres-video").css("display", id == "video" ? "block" : "none");  
  $("#pres-questions").css("display", id == "debat" ? "block" : "none");	  
  $("#pres-calendrier").css("display", id == "calendar" ? "block" : "none");	  
  
  switch (id)
  {
	 case "video" : 
	 playStopVideo("#videoHtml5", true);
	 playStopVideo("#videoTutorielHtml5", false);
	 break;

	 case "intro" : 
	 // N'est plus utilisé :
	 playStopVideo("#videoTutorielHtml5", true);
	 playStopVideo("#videoHtml5", false);
	 break;
	 
	 default:
	 playStopVideo("#videoTutorielHtml5", false);
	 playStopVideo("#videoHtml5", false);
  }
}

function playStopVideo(videoId, bool){
  
  var videoHtmlElement = $(videoId);
  var videoElement = videoHtmlElement.get(0);
  
  if (videoElement != null)
  {  
     // Lancement de la vidéo
	  if (bool) videoElement.play();
	  else {
		  // Arrêt de la vidéo
      if(videoElement.player.pause == null){
        console.log("video element cannot pause");
      }else{
        videoElement.pause();
      }
		  
	  }
  }
}

function pres_hideAll(){
	var list = new Array("#pres-intro", "#pres-video", "#pres-questions", "#pres-calendrier");
	
	for (i=0;i<list.length;i++){
		$(list[i]).hide();
	}
}

function cleanMenuSelection(){
	$(".pres-link").removeClass(" selected");
}
