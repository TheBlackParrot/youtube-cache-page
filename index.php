<?php
	include_once "includes/settings.php";
?>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>YouTube Cache</title>
	<link rel='stylesheet' type='text/css' href='/yt/bootstrap/css/bootstrap.css'/>
	<style>
		@import url(http://fonts.googleapis.com/css?family=Roboto:500,400,300,100);
		body {
			background-color: #ddd;
			font-family: "Roboto", sans-serif;
			font-size: 9pt;
		}
		.wrapper {
			min-width: 1200px;
			max-width: 1200px;
			margin: auto;
			background-color: #fff;
			padding: 16px;
			min-height: 100%;
			box-shadow: 0px 0px 5px #aaa;
		}
		.circle {
			width: 96px;
			height: 96px;
			position: fixed;
			margin: auto;
			left: 0;
			right: 0;
			top: 0;
			bottom: 0;
			z-index: 5;
			box-shadow: 0px 0px 16px rgba(0,0,0,0.8);
			border-radius: 50%;
		}
		.circle_wrapper {
			position: fixed;
			margin: auto;
			left: 50%;
			right: 0;
			top: 50%;
			bottom: 0;
			z-index: 5;
			text-align: center;
			height: 256px;
			transform: translate(-50%, -50%);
			font-size: 16pt;
			color: #fff;
			text-shadow: 0px 0px 6px rgba(0,0,0,0.5);
		}
		.circle_bg {
			width: 100%;
			height: 100%;
			z-index: 4;
			background-color: rgba(0,0,0,0.5);
			position: fixed;
			display: none;
		}
	</style>
	<script src="js/jquery.js"></script>
	<script>
		$(document).ready(function(){
			$('.btn').click(function(){
				$('.circle_bg').css("display","block");
			})
		});
	</script>
</head>

<body>
<div class="circle_bg">
	<div class="circle_wrapper">
		<img class="circle" src="images/loading.gif"/><br/>
		Converting video...
	</div>
</div>
<div class="wrapper">
	<div class="navbar navbar-inverse">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">YouTube Cache</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">Add</a></li>
					<li><a href="browse.php">Browse</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>
	<div class="container">
		<?php
			if(!empty($_GET['message']))
			{
				switch ($_GET['message']) {
					case 1:
						echo '<div class="alert alert-dismissable alert-danger"><strong>Error: </strong>A way to check for previously cached videos is not defined in includes/settings.php.</div>';
						break;
					case 2:
						echo '<div class="alert alert-dismissable alert-danger"><strong>Error: </strong>This video has already been cached.</div>';
						break;
					case 3:
						echo '<div class="alert alert-dismissable alert-danger"><strong>Error <em>[youtube-dl]</em>: </strong>Output file from youtube-dl not found!</div>';
						break;
					case 4:
						echo '<div class="alert alert-dismissable alert-danger"><strong>Error <em>[ffmpeg]</em>: </strong>Output file from ffmpeg not found!</div>';
						break;
					case 5:
						echo '<div class="alert alert-dismissable alert-success"><strong>Video successfully cached.</strong></div>';
						break;
				}
			}
		?>
		<form class="form-horizontal" method="POST" action="includes/add.php">
			<fieldset>
				<legend>Add a YouTube video</legend>
				<div class="form-group">
					<label class="col-lg-2 control-label">Video ID</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="videoid" name="videoid" placeholder='(enter the "vZyenjZseXA" part of "https://www.youtube.com/watch?v=vZyenjZseXA")' required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Author/Artist</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="artist" name="artist" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Title</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="title" name="title" required>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-10 col-lg-offset-2">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
	<div class="container">
		<legend>Space Available</legend>
		<span style="text-align: left;"><?php echo $video['out_location']; ?></span>
		<span style="float: right;"><?php echo round(disk_free_space($video['out_location']) / (1024*1024*1024),1) . "GB / " . round(disk_total_space($video['out_location']) / (1024*1024*1024),1) . "GB"; ?></span><br/>
		<div class="progress progress-striped">
			<div class="progress-bar progress-bar-info" style="width: <?php echo disk_free_space($video['out_location']) / disk_total_space($video['out_location']); ?>%"></div>
		</div>
	</div>

	<script src="/yt/bootstrap/js/bootstrap.js"/>
</div>

</body>

</html>