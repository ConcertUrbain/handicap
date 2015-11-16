$(function(){
  initConfirmForm();
  //initSelectionHover();
  initConfirmHover();
});

function initConfirmHover(){
	
  $("#confirm-validation").hover(function(){
    $("#confirm-valid-image").css("background-position","top right");
  }, function(){
    $("#confirm-valid-image").css("background-position","top left");
  });
  
  /* NEW */
  
  $("#confirm-seul").on("mouseover", function(e) {

	$(".confirm-rollover").css("display", "none");
	
	var target = $(e.currentTarget);
	var targetRollOver = $("#confirm-seul-rollover");
	targetRollOver.css("display", "block");
  });
  
  $("#confirm-aidee").on("mouseover", function(e) {

	$(".confirm-rollover").css("display", "none");
	
	var target = $(e.currentTarget);
	var targetRollOver = $("#confirm-aidee-rollover");
	targetRollOver.css("display", "block");
  });
  
  $(".confirm-rollover").on("mouseout", function(e) {	
	$(".confirm-rollover").css("display", "none");
  });

}

function initConfirmForm(){
	
	$("#confirm-validation").hide();
	$("#confirm-form-detail").hide();
	
	$("#confirm-other-btn").click(function(e){
		e.preventDefault();
		$this = $(this);
		
		//$("#confirm-handicap-container").fadeOut(100);
		$("#confirm-form-detail").fadeToggle(100);
	});
	
	//$(".form-submit").click(function(e){
	$("#confirm-validation").click(function(e){
		e.preventDefault();
		//alert("click submit");
		$("#form").submit();
	});
  
	$(".form-callValid").click(function(e){
		
		$(".confirm-rollover").css("display", "none");
		$(".confirm-rollovers").css("display", "none");
		$("#form").submit();
		
		/*
		$("#confirm-frame").fadeOut(100, function(){
			$("#confirm-validation").fadeIn(200);
		});
		$("#confirm-frame-bottom").fadeOut(100);
		*/
	});
}

function initSelectionHover(){

	$(".confirm-cat-cell").hover(function(e){
		e.preventDefault();
		
		//which one ?
		$this = $(this);
		var id = $this.attr("id");
		
		//change other
		if(id == "confirm-alone"){
			$("#confirm-help").css("background-position","top right");
		}else{
			$("#confirm-alone").css("background-position","top right");
		}
		
	}, function(e){
		e.preventDefault();
		$("#confirm-help").css("background-position","top left");
		$("#confirm-alone").css("background-position","top left");
	});
  
}
