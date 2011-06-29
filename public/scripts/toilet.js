
var Toilet = {

	init: function() {
		var voteup			= $("#voteup");
		var votedown		= $("#votedown");

		$(document).keydown(function(e){
			if (e.keyCode == 37) { 
			   Toilet.showPrevious();
			}
			
			if (e.keyCode == 39) { 
				Toilet.showNext();
			}
		});
		
		voteup.click(function(){
			Toilet.voteUp(this);
		});
		
		votedown.click(function(){
			Toilet.voteDown(this);
		});
	},
	
	showNext: function() {
		var link = $("#toilet .next a");
		window.location.href = link.attr("href");
	},
	
	showPrevious: function() {
		var link = $("#toilet .previous a");
		window.location.href = link.attr("href");
	},
	
	voteUp: function(e) {
		var url = $(e).attr("href");
		var count = $("#votescount");
		var votedown		= $("#votedown");
		
		$.ajax({
			url: url,
			success: function(data) {
				count.html(data);
				votedown.hide();
			}
		}); 
	},
	
	voteDown: function(e) {
		var url = $(e).attr("href");
		var count = $("#votescount");
		var voteup			= $("#voteup");
		
		$.ajax({
			url: url,
			success: function(data) {
				count.html(data);
				voteup.hide();
			}
		});
	}

}

$(document).ready(function(){
	Toilet.init();
});

