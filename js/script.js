$(function(){
	//emptyInputs();
});

function isIE(){
	if(navigator.appName == "Microsoft Internet Explorer"){
		return true;
	}
	
	return false;
}

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

/*function emptyInputs(){
	$("#comment-input").click(function(e){
		e.preventDefault();
		$this = $(this)
		
		if($this.val() == "Donner son avis")	$this.val("");
	});
}*/

function reload(time){
	setTimeout("window.location.reload()", time);
	//document.location.reload(true);
}

function setFocus(){
	$("#form-game-name").focus();
}
