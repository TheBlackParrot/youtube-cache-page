<?php
	// == CONFIGURATION FILE

	// -- SQL --
	// hostname to connect to
	$hostname = "localhost";
	// SQL credentials
	$user = "ytcache_user";
	$password = "asifanyonewillgetin";
	// database that stores info for the cache list
	$database = "ytcache";
	// defines the SQL connection
	$mysqli = new mysqli($hostname, $user, $password, $database);

	// -- TIME --
	date_default_timezone_set('America/Chicago');

	// -- OPTIONS --
	// allow downloading of cached videos
	$setting['allow_downloading'] = true;
	// how to check for previously cached videos (title, artist, vid, date)
	$setting['previous_check'] = "vid";
	// amount of videos to show per page
	$setting['videos_on_page'] = 30;

	// -- VIDEO OPTIONS --
	// string that youtube-dl uses for downloading videos
	$video['website_string'] = "http://www.youtube.com/watch?v=";
	// quality of the video (reccommended range: 18-28) (lower = better quality)
	$video['crf'] = 24;
	// CPU threads to use for converting (reccommended the same amount of CPU cores available)
	$video['threads'] = 2;
	// location for cached videos (INCLUDE LEADING /)
	$video['out_location'] = "/srv/nas/Videos/YouTube/";
?>