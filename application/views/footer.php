
		<div id="footer">
			<b>TheToiletProject.com</b> > Where all the toilets join together for the world |
			Designed by <a href="http://www.germanrdz.com" target="_blank">German Rodriguez</a>
		</div>


      <!-- FACEBOOK API -->
      <div id="fb-root"></div>
      <script src="http://connect.facebook.net/en_US/all.js"></script>
      <script>
         FB.init({ 
            appId:'133512650062074', cookie:true, 
            status:true, xfbml:true 
         });
         FB.Event.subscribe('auth.login', function(response) {
			window.location.reload();
		 });
      </script>


		
	</body>
</html>
