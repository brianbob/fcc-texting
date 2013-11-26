jQuery(document).ready(function() { 

	var characters = 160; 
	jQuery("#content").prepend("<div class='remainingChars'>(You have <strong>"+ characters+"</strong> characters remaining.)</div>"); 
	jQuery("textarea").keyup(function(){ 

		if(jQuery(this).val().length > characters){ 
			jQuery(this).val(jQuery(this).val().substr(0, characters)); 
		} 

		var remaining = characters - jQuery(this).val().length; 

		jQuery("div.remainingChars").html("(You have <strong>"+ remaining+"</strong> characters remaining)"); 
		
		if(remaining <= 10) 
		{ 
			jQuery("div.remainingChars").css("color","red"); 
		} 
		else 
		{ 
			jQuery("div.remainingChars").css("color","white"); 
		} 
	}); 

	jQuery("textarea").click(function(){
		if(jQuery(this).val() == "Insert your text message here...") {
			jQuery(this).val("");
		}
	});

	jQuery("button.shownums").click(function(){
		jQuery(this).css('display', 'none');
		jQuery('div.number_list').css('display','block');
	});

	jQuery("input").click(function(){
		//jQuery('form').submit();
	});

});