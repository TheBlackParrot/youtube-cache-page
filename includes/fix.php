<?php
include_once "settings.php";

$query = "SELECT * FROM ytcache";
$result = mysqli_query($mysqli,$query);
while($row = mysqli_fetch_array($result))
{
	$filename = $video['out_location'] . $row['ARTIST'] . " - " . $row['TITLE'] . ".mp4";
	$mtime = filemtime($filename);
	$query2 = 	"UPDATE ytcache
				SET DATEADDED='" .  $mtime . "'
				WHERE VID='" . $row['VID'] . "'";
	$result2 = mysqli_query($mysqli,$query2);
}
?>