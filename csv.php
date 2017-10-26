<?php
// http://pc.pulipuli.info/public/bigdata2016/csv.php?view=view_term_bibliography_prop_avg  
require("rb.config.php");

if (isset($_GET["view"])) {
	//header("Content-type: text/csv");
	$rows = R::getAll( 'SELECT * FROM ' . $_GET["view"] );
	
	?>
	<table border="1">
	<?php
	
	foreach ($rows AS $i => $row) {
		
		if ($i > 0) {
			echo "\n";
		}
		else {
			$keys = array_keys($row);
			?>
			<tr><td valign="top">
			<?php
			echo implode("</td><td>	", $keys) . "\n";
			?>
			</td></tr>
			<?php
		}
		?>
		<tr>
		<?php
		foreach ($row AS $j => $cell) {
			//echo str_replace(",", "</td><td>", $cell);
			echo '<td>' . str_replace(",", "</td><td>", $cell) . '</td>';
		}
		
		//echo implode("</td><td>" , $row);
		?>
		</tr>
		<?php
	}
	?>
	</table>
	<?php
}