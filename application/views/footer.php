
		<div id="footer">
			<b>AsiMeEstacionoYo.com</b> > Sube tus fotos de gente mal estacionada | 
			Designed by <a href="http://www.germanrdz.com" target="_blank">German Rodriguez</a>
		</div>


      <!-- FACEBOOK API -->
      <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            appId      : '133512650062074',
            status     : true, 
            cookie     : true,
            xfbml      : true,
            oauth      : true,
          });

          FB.Event.subscribe('auth.login', function(response) {
          window.location.reload();
          });
        };


        (function(d){
           var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
           js = d.createElement('script'); js.id = id; js.async = true;
           js.src = "//connect.facebook.net/en_US/all.js";
           d.getElementsByTagName('head')[0].appendChild(js);
         }(document));
      </script>
		
	</body>
</html>
