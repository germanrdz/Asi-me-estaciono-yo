var Application = {

	init: function() {
		var upload_button	= $("#submit");
		var upload_form		= $("#header form");
		var name 			= $("#name");
		var location 		= $("#location");
		
		var name_tip 		= "Titulo de la foto";
		var location_tip 	= "Lugar donde fue tomada";
				
		upload_button.click(function() {
			upload_form.submit();
		});
		
		name.focus(function() {
			var me = $(this);
			if (me.val() == name_tip) {
				me.val("").removeClass("overlay");
			}
		}).blur(function() {
			var me = $(this);
			if (me.val() == "") {
				me.val(name_tip).addClass("overlay");
			}
		});
		
		location.focus(function() {
			var me = $(this);
			if (me.val() == location_tip) {
				me.val("").removeClass("overlay");
			}
		}).blur(function() {
			var me = $(this);
			if (me.val() == "") {
				me.val(location_tip).addClass("overlay");
			}
		});		
		
		$("#fb_logout").click(function() {
			FB.logout(function(response) {
				window.location.reload(true);
			})
		});

	},

    loggedHeader: function() {
        
    }

};

$(document).ready(function() {
	Application.init();
});