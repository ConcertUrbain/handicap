$(function(){
	//closeButtonInit();
});

function closeButtonInit(){
  var btn = $("#btn-close");
  var mosaic = $(".all");
  
  var top = parseInt(mosaic.position().top);
  var left = parseInt(mosaic.position().left) + parseInt(mosaic.css("width"));
  
  btn.css({
    top: top + "px",
    left: left + "px"
  });
  
  console.log(top, left);
}


// Mathieu : text to speech
$(function(){
	// gestion du DOM pour lecture 
	$('audio.text-to-speech').each(function() {
		if ($(this).parents('.text-to-speech-container').length == 0) {
			$(this).parent().addClass('text-to-speech-container');
			if ($(this).hasClass("force-play"))
				$(this).parent().addClass('force-play');
		}
	});
	// gestion évenements lecture
	$('.text-to-speech-container').each(function() {
		//$(this).click(function() {
		$(this).mouseover(function() {
			if (soundActivationJustToggled) {
				soundActivationJustToggled = false;
				return;
			}
			if ($.cookie("textToSpeechOnActive") != "off" || $(this).hasClass("force-play")) {
				audioItem = $(this).find('audio.text-to-speech')[0];
				if (audioItem.paused || audioItem.ended) {
					stopAllTextToSpeech();
					audioItem.play();
				}
			}
		});
	})
	// gestion toggle ON / OFF
	$('#text-to-speech-toggle-on').click(function() {
		$.cookie("textToSpeechOnActive", "off");
		$('#text-to-speech-toggle-on').hide();
		$('#text-to-speech-toggle-off').show();
		stopAllTextToSpeech();
		soundActivationJustToggled = true;
	});
	$('#text-to-speech-toggle-off').click(function() {
		$.cookie("textToSpeechOnActive", "on");
		$('#text-to-speech-toggle-off').hide();
		$('#text-to-speech-toggle-on').show();
		soundActivationJustToggled = true;
	});
	if ($.cookie("textToSpeechOnActive") != "off") {
		$('#text-to-speech-toggle-off').hide();
		$('#text-to-speech-toggle-on').show();
	}
	else {
		$('#text-to-speech-toggle-on').hide();
		$('#text-to-speech-toggle-off').show();		
	}
	soundActivationJustToggled = false;
});

function stopAllTextToSpeech() {
	$('audio.text-to-speech').each(function() {
		try {
			if (!this.paused)
				this.pause();
			this.currentTime = 0;
		} catch(err) {}
	});
}


//Mathieu : gestion du scroll et du bouton nretour en haut
$(document).ready(function()
{
	if ($('#lien_retour_top').length > 0) {
		$('#lien_retour_top').click(function() {
			$('html, body').animate({ scrollTop: 0 }, 'slow'); return false;
			return false;
		});
		$(document).scroll(function() {
			manageScroll();
	    });
		manageScroll();
	}
});
function manageScroll() {
	if ($('#lien_retour_top').length > 0) {
	    var top = $(document).scrollTop();
	    if (top > 100) 
	    	$('#lien_retour_top').show();
	    else
	    	$('#lien_retour_top').hide();
	}
}