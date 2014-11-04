<?php
	include_once "settings.php";
?>
	<thead>
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>Artist/Author</th>
			<th>Added</th>
		</tr>
	</thead>
	<?php
		$suf = "ASC";
		if(!empty($_GET['sort']))
			$sort = $_GET['sort'];
		else
			$sort = "TITLE";
		if($sort === "DATEADDED")
			$suf = "DESC";
		if(!empty($_GET['page']))
			$page = $_GET['page'];
		else
			$page = 1;

		if(empty($_GET['search']))
			$_GET['search'] = "";
		$search_words = explode(" ",$_GET['search']);
		// apparently %%word% %another%% is valid?
		$SQL_search_formatted = ""; # screw off PHP.
		foreach ($search_words as $word)
			$SQL_search_formatted .= "%" . $word . "%";

		$query = "SELECT ID FROM ytcache ORDER BY ID DESC LIMIT 1";
		$result = mysqli_query($mysqli,$query);
		$amount = mysqli_fetch_array($result);
		// page = 2; start = 8; end = 16;
		$pages['start'] = ($page-1) * $setting['videos_on_page'];

		$query = 	"SELECT *
					FROM ytcache
					WHERE concat_ws(' ', ARTIST, TITLE) LIKE '%" . $SQL_search_formatted . "%'
					OR concat_ws(' ', TITLE, ARTIST) LIKE '%" . $SQL_search_formatted . "%'
					ORDER BY " . $sort . " " . $suf . "
					LIMIT " . $pages['start'] . "," . $setting['videos_on_page'];
		$result = mysqli_query($mysqli,$query);
	?>
	<tbody page="<?php echo $page; ?>">
		<?php
			while($row = mysqli_fetch_array($result))
			{
				echo '<tr class="cache_row" videofn="' . $row['VID'] . '">';
				echo '<td><a class="th_link" href="' . $video['website_string'] . $row['VID'] . '" target="_blank">' . $row['VID'] . '</a></td>';
				echo '<td>' . $row['TITLE'] . '</td>';
				echo '<td>' . $row['ARTIST'] . '</td>';
				echo '<td>' . date('m/d/Y g:i A',$row['DATEADDED']) . '</td>';
				echo '</tr>';
			}
		?>
	</tbody>
	<script>
	$(document).ready(function(){
		$('.cache_row').each(function(){
			$(this).click(function() {
				$('.cache_row').children().attr("style","background-color: #transparent;");
				$(this).children().attr("style", "background-color: #cff !important;");
				$('#videowrapper').empty();
				$('#videowrapper').load("includes/load.php?v=" + $(this).attr("videofn"))
			})
		})
	});
	</script>