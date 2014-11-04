<?php
	include_once "includes/settings.php";
?>

<html>

<head>
	<title>YouTube Cache</title>
	<link rel='stylesheet' type='text/css' href='/yt/bootstrap/css/bootstrap.css'/>
	<script src="js/jquery.js"></script>	
	<script src="js/mediaelement-and-player.min.js"></script>
	<link rel="stylesheet" href="js/mediaelementplayer.css" />
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
		table {
			font-size: 9pt;
		}
		#videowrapper {
			background-color: #222;
			margin-bottom: 32px;
			padding: 0;
			width: 1026px;
			min-height: 578px;
			max-height: 578px;
			box-shadow: 0px 0px 5px #333;
			border: 1px solid #000;
			transition: .1s;
			-webkit-transition: .25s;
		}
		video {
			background-color: #000;
		}
		tr th:nth-child(1), tr td:nth-child(1) { width: 12%; }
		tr th:nth-child(2), tr td:nth-child(2) { width: 38%; }
		tr th:nth-child(3), tr td:nth-child(3) { width: 35%; }
		tr th:nth-child(4), tr td:nth-child(4) { width: 15%; }
		table tr {
			background-color: #fff;
		}
		table tr:hover {
			background-color: #ffc;
		}
		table th:hover, table thead:hover, table thead tr:hover {
			background-color: #fff !important;
		}
		table td {
			background-color: transparent !important;
		}
		.videoinfo {
			color: #fff;
			padding: 8px;
			line-height: 24pt;
			position: relative;
			top: -593px;
			background-color: rgba(0,0,0,0.5);
			display: none;
		}
	</style>
	<script>
	$(document).ready(function(){
		$('#cachetable').load("includes/load2.php");
		$('.cache_row').each(function(){
			$(this).click(function() {
				$('.cache_row').children().attr("style","background-color: #transparent;");
				$(this).children().attr("style", "background-color: #cff !important;");
				$('#videowrapper').empty();
				$('#videowrapper').load("includes/load.php?v=" + $(this).attr("videofn"))
			})
		})
		$('.th_link').each(function(){
			$(this).click(function(e){
				e.stopPropagation();
			})
		})
		$('.sort_artist').click(function(){
			$('#cachetable').empty();
			$('#cachetable').load("./includes/load2.php?sort=ARTIST&search=" + encodeURIComponent($('.searchtext').val()));
		})
		$('.sort_title').click(function(){
			$('#cachetable').empty();
			$('#cachetable').load("./includes/load2.php?sort=TITLE&search=" + encodeURIComponent($('.searchtext').val()));
		})
		$('.sort_date').click(function(){
			$('#cachetable').empty();
			$('#cachetable').load("./includes/load2.php?sort=DATEADDED&search=" + encodeURIComponent($('.searchtext').val()));
		})
		$('.searchbutton').click(function(){
			$('#cachetable').empty();
			$('#cachetable').load("./includes/load2.php?search=" + encodeURIComponent($('.searchtext').val()));
		})
		$('#page').on('change',function(){
			$('#cachetable').empty();
			$('#cachetable').load("./includes/load2.php?search=" + encodeURIComponent($('.searchtext').val()) + "&page=" + $(this).val());
		})
		$('#videowrapper').hover(function(){
			$('.videoinfo').css("display","block");
		}, function(){
			$('.videoinfo').fadeOut(250,function(){
				$('.videoinfo').css("display","none");
			})
		})
	});
	</script>
</head>

<body>

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
					<li><a href="/yt">Add</a></li>
					<li class="active"><a href="#">Browse</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>
	<div class="container" id="videowrapper">
	</div>
	<div class="container">
		<div class="col-lg-2">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Sort</h3>
				</div>
				<div class="panel-body">
					<a href="#" class="sort_artist">Artist</a><br/>
					<a href="#" class="sort_title">Title</a><br/>
					<a href="#" class="sort_date">Date Cached</a>
				</div>
			</div>
			<?php
				$query = "SELECT ID FROM ytcache ORDER BY ID DESC LIMIT 1";
				$result = mysqli_query($mysqli,$query);
				$arr = mysqli_fetch_array($result);
				
				$iterator = new DirectoryIterator($video['out_location']);

				$mtime = -1;
				$size = 0;
				foreach($iterator as $fileinfo)
				{
					if ($fileinfo->isFile())
					{
						if ($fileinfo->getMTime() > $mtime)
							$mtime = $fileinfo->getMTime();
						$size += $fileinfo->getSize();
					}
				}
			?>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Statistics</h3>
				</div>
				<div class="panel-body">
					<span style="font-weight: 500;">Cached videos</span><br/>
					<?php
						echo $arr['ID'];
					?><br/><br/>
					<span style="font-weight: 500;">Last modified</span><br/>
					<?php
						echo date('m/d/Y g:i A',$mtime);
					?><br/><br/>
					<span style="font-weight: 500;">Size of cache</span><br/>
					<?php
						echo round($size / (1024*1024*1024),1) . "GB";
					?>
				</div>
			</div>
		</div>
		<div class="col-lg-10">
			<form>
				<div class="form-group">
					<div class="input-group">
						<input type="text" class="form-control searchtext">
						<span class="input-group-btn">
							<button class="btn btn-default searchbutton" type="button">Search</button>
						</span>
					</div>
				</div>
			</form>
			<table class="table table-striped table-hover " id="cachetable">
			</table>
			<form class="form-horizontal">
				<fieldset>
					<div class="form-group">
						<label for="page" class="col-lg-1 control-label">Page</label>
						<div class="col-lg-2">
							<select class="form-control" id="page">
								<?php
									$query = "SELECT ID FROM ytcache ORDER BY ID DESC LIMIT 1";
									$result = mysqli_query($mysqli,$query);
									$amount = mysqli_fetch_array($result);

									$current = 1;
									$total = ceil($amount['ID']/$setting['videos_on_page']);
									while($current <= $total)
									{
										echo '<option value="' . $current . '">' . $current . '</option>';
										$current++;
									}
								?>
							</select>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>

	<script src="/yt/bootstrap/js/bootstrap.js"/>
</div>
</body>

</html>