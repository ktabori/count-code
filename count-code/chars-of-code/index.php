<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
		<meta http-equiv="Cache-control" content="no-cache" />
		
		<style type="text/css">
			@font-face
			{
				font-family: "Roadgeek2005SeriesD";
				src: url("http://panic.com/fonts/Roadgeek 2005 Series D/Roadgeek 2005 Series D.otf");
			}
			
			body, *
			{
			
			}
			body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td
			{ 
				margin: 0;
				padding: 0;
			}
				
			fieldset,img
			{ 
				border: 0;
			}
			
				
			/* Settin' up the page */
			
			html, body, #main
			{
				overflow: hidden; /* */
			}
			
			body
			{
				color: white;
				font-family: 'Roadgeek2005SeriesD', sans-serif;
				font-size: 20px;
				line-height: 24px;
			}
			body, html, #main
			{
				background: transparent !important;
			}
			
			#Container
			{
				width: 250px;
				height: 186px;
				text-align: center;
				background-size: 250px 187px;
			}
			#Container *
			{
				font-weight: normal;
			}
			
			h1
			{
				font-size: 60px;
				line-height: 120px;
				margin-top: 30px;
				margin-bottom: 28px;
				color: white;
				text-shadow:0px -2px 0px black;
				text-transform: uppercase;
			}
			
			h2
			{
				width: 180px;
				margin: 0px auto;
				padding-top: 20px;
				font-size: 16px;
				line-height: 18px;
				color: #7e7e7e;
				text-transform: uppercase;
			}
		</style>
	</head>
	
	<script type="text/javascript">

		function ajaxStateChange()
		{
		    if ( this.readyState == 4 )
		    {
				document.getElementById('howmany').innerText = this.responseText;
		    }
		};

		function refresh()
		{
		    var url = 'class_chars_of_code.php';
		    var req = new XMLHttpRequest();
	   	 	console.log("Refreshing Count...");
			
		    req.onreadystatechange = ajaxStateChange.bind(req);
		    req.open("GET", url, true);
		    req.send(null);
		}

		function init()
		{
			// Change page background to black if the URL contains "?desktop", for debugging while developing on your computer
			if (document.location.href.indexOf('desktop') > -1)
			{
				document.getElementById('Container').style.backgroundColor = 'black';
			}
			
			refresh()
			var int=self.setInterval(function(){refresh()},30000);
		}

	</script>
	
	<body onload="init()">
		<div id="main">
		
			<div id="Container">

				<h2>Chars of code in Project?</h2>
				<h1 id="howmany"><?= $folder -> count_lines() ?></h1>
			
			</div><!-- spacepeopleContainer -->

		</div><!-- main -->
	</body>
</html>
