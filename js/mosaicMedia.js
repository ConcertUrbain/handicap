$(function(){
	$("#media-vote-thanks").hide();
	$("#media-comment").hide();
	initVoteValidation();
});

function initVoteValidation(){

	var com = getUrlVars()["com"];
	if(com == null)	
		$("#media-comment").hide();
	else {	
		setComments(true);
		if (location.hash == "#last-comment") {
			$('html, body').animate({
				scrollTop:$("a#last-comment").offset().top
			}, 'fast');
		}
	}

	
	// permet de voter en cliquant sur un des deux cercles
	$("#media-vote-acces-commentaires").click(function(e){
		$("#media-vote-acces-commentaires").hide();
		$("#media-comment").show();
	});
	
	// permet de voter en cliquant sur un des deux cercles
	$(".vote").click(function(e){
		
		e.preventDefault();
		var $this = $(this);
		var $form = $("#voteForm");
		
		var $id = $this.attr("id");
		
		//met à jour la valeur de vote dans le formulaire
		$vote = -1;
		if($id == "vote-up")	$vote = 1;
		$form.children("#vote-value").val($vote);
		
		//submit form
		$.post("uploadVote.php", $form.serialize(), function(data){
			//alert(data);
			try{
				var json = JSON.parse(data);
				
				if(json.debug){
					alert("[OUTPUT]\n"+json.content+"\n"+json.type+"\n"+json.debug);
				}
				
			}catch(e){
				alert("[ERROR JSON]\n"+data);
				$("#media-frame-vote").html(data);
			}
			
		});
		
		//setComments(false);
		
		showThanks();
		
		// Retour à la mosaique :
		var questionId = $form.children("#question-id").val();
		var page = $form.children("#page").val();
		

		var url = "mosaic.php?id=" + questionId + "&page=" + page;
		
		setTimeout(function() { document.location.href = url; }, 1000);
	});
}

function showThanks(){

	$("#media-comment").hide();
	$("#media-vote-acces-commentaires").show();
	
	$("#media-vote-frame").fadeOut(200, function(e){
		$("#media-vote-thanks").fadeIn(200);
	});
	
}

function setComments(instant){
	
	$("#media-vote-acces-commentaires").hide();
	
	if(instant){
		$("#media-comment").show();
		$("#media-frame-vote").hide();
		return;
	}
	
	$("#media-frame-vote").fadeToggle(300, function(){
		
		$next = $("#media-comment");
		$next.fadeToggle(300);
		
	});
	
}