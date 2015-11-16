
function initClickMenu(){
	
	pres_hideAll();
	
	$("#pres-intro").show();
	
	$(".pres-link").click(function(e){
    e.preventDefault();
    var id = $(this).attr('id');
    if(id != undefined)  clickCat(id);
  });
}

function clickCat(id){
  $this = $("#"+id);
  alt = "#"+$this.attr("alt");
  
  pres_hideAll();
  cleanMenuSelection();
  
  $(alt).fadeToggle(200);
  $this.addClass(" selected");
  
  if (id == "debat")	
  {
	  $("#menu #video").css("display", "none");
	  $("#menu #calendar").css("display", "none");	  
  };
  
  //console.log("clicked "+id);
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
