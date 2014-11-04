<?php
	include_once "settings.php";
	$date = time();
	$output_fn = escapeshellarg($_POST['artist'] . " - " . $_POST['title'] . ".mp4");

	switch ($setting['previous_check']){
		case 'title':
			$query = 'SELECT ' . $setting['previous_check'] . ' FROM ytcache WHERE TITLE = "' . $_POST['title'] . '"';
			break;
		case 'vid':
			$query = 'SELECT ' . $setting['previous_check'] . ' FROM ytcache WHERE VID = "' . $_POST['videoid'] . '"';
			break;
		case 'artist':
			$query = 'SELECT ' . $setting['previous_check'] . ' FROM ytcache WHERE ARTIST = "' . $_POST['artist'] . '"';
			break;
		case 'date':
			$query = 'SELECT ' . $setting['previous_check'] . ' FROM ytcache WHERE DATE = "' . $date . '"';
			break;
		default:
			header("Location: ../?message=1");
			exit;
			break;
	}
	$result = mysqli_query($mysqli,$query);
	while($row = mysqli_fetch_array($result))
	{
		header("Location: ../?message=2");
		exit;
	}

	shell_exec('youtube-dl -o "/tmp/%(id)s" ' . $video['website_string'] . $_POST['videoid']);
	sleep(1);

	if(file_exists("/tmp/" . $_POST['videoid']))
	{
		//avconv -i /tmp/vZyenjZseXA -codec:v libx264 -pre:v veryfast -crf 28 -c:a libmp3lame -q:a 1 /tmp/vZyenjZseXA-post.mp4
		shell_exec("avconv -i /tmp/" . $_POST['videoid'] . " -threads " . $video['threads'] . " -codec:v libx264 -pre:v veryfast -crf " . $video['crf'] . " -c:a libmp3lame -q:a 1 " . $video['out_location'] . $output_fn);
		sleep(1);
		shell_exec("rm /tmp/" . $_POST['videoid']);
		if(file_exists("/srv/nas/Videos/YouTube/" . $_POST['artist'] . " - " . $_POST['title'] . ".mp4"))
		{
			$query = 'INSERT INTO ytcache (VID, TITLE, ARTIST, DATEADDED) VALUES ("' . $_POST['videoid'] . '","' . $_POST['title'] . '","' . $_POST['artist'] . '","' . $date . '");';
			$result = mysqli_query($mysqli,$query);
			header("Location: ../?message=5");
			exit;
		}
		else
		{
			header("Location: ../?message=4");
			exit;
		}
	}
	else
	{
		header("Location: ../?message=3");
		exit;
	}