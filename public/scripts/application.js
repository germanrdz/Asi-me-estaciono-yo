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

    loggedHeader: function(response) {

        debugger;

        var upload_form = $.FORM({ action: "main" }, 
                                 $.DIV({ className: "fields" }, 
                                       $.INPUT({ name: "title", title: "Titulo de la foto", className: "overlay", id: "name" }),
                                       $.INPUT({ name: "location", title: "Lugar donde fue tomada", className: "overlay", id: "location" }),
                                       
                                       $.INPUT({ type: "hidden" }, ""),
                                       $.INPUT({ type: "hidden" }, 0),

                                       $.DIV({ className: "image_upload" },
                                             $.SPAN({}, $.INPUT({ type: "file", name: "image", className: "overlay"})),
                                            ),
                                       
                                       $.A({ href: "javascript:;", id: "submit" }, $.IMG({ src="/public/images/upload.jph" })),
                                      ),
                                );
        
        $("#upload").append(upload_form);
                                             
    }

};

$(document).ready(function() {
	Application.init();
});