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
	
	doUpload: function(e) {
		
		// get some values from elements on the page:
		var $form = $( e ),
			name = $form.find( 'input[name="name"]' ).val(),
			location = $form.find( 'input[name="location"]' ).val(),
			toilet = $form.find( 'input[name="toilet"]' ).val(),
			url = $form.attr( 'action' );

		// Send the data using post and put the results in a div
		$.post( url, 
			{
				name: name,
				location: location,
				toilet: toilet
			},
			function( data ) {
				$.modal(data, { overlayClose:true, opacity:85 } );
			  
				//var content = $( data ).find( '#content' );
				//$( "#result" ).html( content );
			}
		);

	
		//var loading = $.modal("uploading..");
		/*
		$.ajax({
			type: 'POST',
			url: url,
			data: data,
			success: function(html) {
				//loading.close();
				$.modal(html, { overlayClose:true, opacity:85 } );
			},
			dataType: "html"
		});
	
		*/
	},
	
	view: function(id) {
		var view_window = $("#view_window");
	
		var info = Application.getToiletInfo(id);
		var html =	$.DIV({ Class: "toilet_view" },
				$.H1({}, info.location),
				$.IMG({ src: "public/toilets/" + info.image + ".jpg" }),
				$.DIV({ Class: "bottom" },
					$.SPAN({ Class: "name" }, "by " + info.name),
					$.SPAN({ Class: "votes" },
						$.A({ href: "javascript:;" }, $.IMG({ src: "public/images/up.png"})),
						$.A({ href: "javascript:;" }, $.IMG({ src: "public/images/down.png"}))
					)
				)
			);
				
		view_window.html(html);
		
		var window_options = {
			onShow: function () {
			            $.modal.setContainerDimensions();
			},
			overlayClose: true,
			opacity: 85		
		};
		
	    var img = new Image();
	    img.onload = function () {
	        //$.modal("<div><img src=\"someimage.jpg\" /></div>");
			view_window.modal(window_options);
	    };
	    img.src = "public/toilets/" + info.image + ".jpg";		
	
		
	},
	
	getToiletInfo: function(id) {
		var json = $("#toilet" + id);
		var toilet = eval("(" + json.html() + ")");
		
		return toilet;
	}

};

$(document).ready(function() {

	Application.init();

});