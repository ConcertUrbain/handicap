$(function(){
	
	fileSubmittion();
	textFormCheck();
  
  //initSelectionHover();
});

function showLoading(){
	$load = $("#loading-border");
	
	$load.css("left", $(window).width() * 0.5 - $load.width() * 0.5);
	$load.css("top", $(window).height() * 0.5 - $load.height() * 0.5);
	
	$load.fadeToggle(300);
}

function fileSubmittion(){
	
	$("#loading-border").hide();
	
	if(!isIE()){
		$(".file").hide();
	}
	
	$("#form-text").hide();
	
	// open browse for file
	$(".form_line").click(function(e){
		$this = $(this);
		
		var label = "";
		
		if(isIE()){
			label = $this.find(".form-line-label").html();
		}else{
			label = $this.children(".form-line-label").html();
		}
		
		//text ?
		if(label.indexOf("texte") > -1){
			$("#form-list").fadeToggle(300, function(){
				$("#form-text").fadeToggle(300);
			});
		}else{
			if(!isIE()){
				e.preventDefault();
				$(".file").click();
			}
		}
		
	});
	
	//if(isIE())	$("#form-submit").hide();
	
	//submit form after receive file from computer
	$(".file").change(function(e){
		//console.log("file selected "+$(".file").val());
		
		//if(isIE())	$("#form-submit").fadeToggle(300);
		showLoading();
		$("#formMedia").submit();
	});
}

function textFormCheck(){
	$("#form-text-input").click(function(e){
		//e.preventDefault();
		$this = $(this);
		
		var val = $("#from-textarea").val();
		if(val.length < 0){
			alert("Le champ de temoignage est vide.");
			e.preventDefault();
		}
	});
}
