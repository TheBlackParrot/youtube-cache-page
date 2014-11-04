<?php
	include_once "settings.php";
	$query = "SELECT * FROM ytcache WHERE VID = '" . $_GET['v'] . "'";
	$result = mysqli_query($mysqli,$query);
	$row = mysqli_fetch_array($result);

	$fname = rawurlencode($row['ARTIST'] . ' - ' . $row['TITLE'] . '.mp4');

	echo '<video style="margin: auto;" id="videopl" width="1024" height="576" controls="controls" preload="none" src="videos/' . $fname . '"></video><br/>';
	echo '<div class="videoinfo"><span style="font-size: 20pt; font-weight: 500;">' . $row['TITLE'] . '</span><br/>';
	echo '<span style="font-size: 14pt; font-weight: 300;">' . $row['ARTIST'] . '</span>';
?>
<script>
$(document).ready(function(){
	player = new MediaElementPlayer('#videopl', {
		iPhoneUseNativeControls: true
	});
	setTimeout("player.load()",50);
	setTimeout("player.play()",100);
});
</script>