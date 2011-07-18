
		<div id="footer">
			<b>AsiMeEstacionoYo.com</b> > Sube tus fotos de gente mal estacionada | 
			Designed by <a href="http://www.germanrdz.com" target="_blank">German Rodriguez</a>
		</div>


      <!-- FACEBOOK API -->
      <div id="fb-root"></div>
      <script src="http://connect.facebook.net/en_US/all.js"></script>
      <script type="text/javascript">
         FB.init({ 
            appId:'133512650062074', cookie:true, 
            status:true, xfbml:true 
         });
         
         FB.Event.subscribe('auth.login', function(response) {
                 window.location.reload();
                 //Application.loggedHeader(response);
         });
      </script>
		
	</body>
</html>
