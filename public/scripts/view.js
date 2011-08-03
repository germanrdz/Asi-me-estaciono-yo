var View = {

    link_next: undefined,
    link_previous: undefined,

	init: function() {
		var voteup			= $("#voteup");
		var votedown		= $("#votedown");

        this.link_next = $("#toilet .next a"); 
        this.link_previous = $("#toilet .previous a");

		$(document).keydown(function(e){
			if (e.keyCode == 37) { 
			   View.showPrevious();
			}
			
			if (e.keyCode == 39) { 
				View.showNext();
			}
		});
		
		voteup.click(function(){
			View.voteUp(this);
		});
		
		votedown.click(function(){
			View.voteDown(this);
		});
        
        $('a[rel*=facebox]').facebox();
    },
	
	showNext: function() {
        if (this.link_next.size() > 0) {
		    window.location.href = View.link_next.attr("href");
        }
	},
	
	showPrevious: function() {
        if (this.link_previous.size() > 0) {
		    window.location.href = View.link_previous.attr("href");
        }
	},
	
	voteUp: function(e) {
		var url = $(e).attr("href");
		var count = $("#votescount");
		var votedown = $("#votedown");
		
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
	View.init();
});

