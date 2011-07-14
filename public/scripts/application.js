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


        var username = "Anonymous";
        var query = FB.Data.query('select name, uid from user where uid={0}', response.session.uid);
                
        //debugger;

        var upload_form = $.FORM({ action: "main", method: "post", enctype: "multipart/form-data" }, 
                                 $.DIV({ className: "fields" }, 
                                       $.INPUT({ name: "title", value: "Titulo de la foto", className: "overlay", id: "name" }),
                                       $.INPUT({ name: "location", value: "Lugar donde fue tomada", className: "overlay", id: "location" }),
                                       
                                       $.INPUT({ type: "hidden", value: response.session.uid}),
                                       $.INPUT({ type: "hidden", id: "username_input" }),

                                       $.DIV({ className: "image_upload" },
                                             $.SPAN({}, 
                                                    $.INPUT({ type: "file", name: "image", className: "overlay"})
                                                   )
                                            ),
                                       
                                       $.A({ href: "javascript:;", id: "submit" }, $.IMG({ src:"public/images/upload.jpg" }))
                                      )
                                );
         
        var logged_header = $.SPAN({},
                                   $.A({ href: "javascript:;" },
                                       $.IMG({ src: "http://graph.facebook.com/" + response.session.uid + "/picture?type=square", className: "picture", height: "20", align: "left" })
                                      ),
                                   $.SPAN({ id:"username" }, "Cargando... "),
                                   $.A({ id: "fb_logout" }, "(cerrar sesion)")
                                  );
        
        query.wait(function(rows) {
            $("#login").html("").append(logged_header);
            $("#upload .content").html("").append(upload_form);
        
            $("#username").html(rows[0].name + " ");
            $("#username_input").val(rows[0].name);

            Application.init();
        });        
        
        
    }

};

$(document).ready(function() {
	Application.init();
});