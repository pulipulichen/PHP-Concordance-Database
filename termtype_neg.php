<?php
// http://pc.pulipuli.info/public/bigdata2016/csv.php?view=view_term_bibliography_prop_avg  

require("rb.config.php");

$view_type = "negative";

// ----------------------

if (isset($_GET["action"])) {
	@$id = $_GET["id"];
	$term = $_GET["term"];
	$type = $_GET["type"];
	$action = $_GET["action"];
	//echo $id . $term . $type . $action;
	
	if ($action === "update") {
		$termtype = R::load( 'termtype', intval($id) );
		//echo $term->id . $term->term . $term->type . $term->action;
		$termtype->term = $term;
		$termtype->type = $type;
		R::store( $termtype );
		echo "updated";
	}
	else if ($action === "create" 
		&& $term !== "" && $type !== "") {
		/*$termtype = R::dispense("termtype");
		$termtype->term = $term;
		$termtype->type = $type;
		$termtype->createdAt = R::isoDateTime();
		$termtype->updatedAt = R::isoDateTime();
		R::store( $termtype );
		*/
		$sql = "INSERT INTO termtype (term, type, \"createdAt\", \"updatedAt\") VALUES ('" . $term . "', '" . $type . "', '" . R::isoDateTime() ."','" . R::isoDateTime() ."')";
		//echo $sql;
		R::exec( $sql );
		echo "created";
	}
	
	exit;
}

// ----------------------
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<link rel="stylesheet" href="//pulipulichen.github.io/blogger/posts/2016/12/semantic/semantic.min.css">
<link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">
<script src="//pulipulichen.github.io/blogger/posts/2016/12/semantic/semantic.min.js"></script>
<script src="//pulipulichen.github.io/blogger/posts/2016/12/jszip.min.js"></script>
<script src="//pulipulichen.github.io/blogger/posts/2016/12/FileSaver.min.js"></script>
<script src="//pulipulichen.github.io/blogger/posts/2016/11/r-text-mining/wordcloud2.js"></script>
<script src="//pulipulichen.github.io/blogger/posts/2016/12/clipboard.min.js"></script>
<script src="//pulipulichen.github.io/blogger/posts/2016/12/smooth-scroll.min.js"></script>
<!-- <link rel="icon" href="icon.png" type="image/png"> -->
<title>人民日報 字彙分類: <?php echo $view_type ?></title>

<style>
body {
	padding: 2em;
}

.pointer {
	cursor: pointer;
	text-decoration: underline;
}

table td,
table th {
	vertical-align: top;
}

td strong {
	color: red;
}
/*
td.fulltext {
	text-align: center;
	white-space: nowrap;
	overflow-x: hidden;
	
}*/
td div.segment {
	text-align: center;
	padding-top: 0 !important;
    padding-bottom: 0 !important;
	white-space: nowrap;
}

td div.segment a {
	color: black;
	
}

.float-action-button {
  position: fixed;
  bottom: 1em;
  right: 1em;
  box-shadow: 0 0 4px rgba(0, 0, 0, 0.14), 0 4px 8px rgba(0, 0, 0, 0.28) !important;
}
</style>

</head>

<body>
<h1 id="top">人民日報 單字分類表</h1>

<button type="button" onclick="$(window).scrollTop(0)" class="circular large teal ui icon button float-action-button" title="回到頁首">
		<i class="large angle double up icon"></i>
</button>
<div class="ui form">

<table>
	<tbody>
<?php
$terms = R::getAll("SELECT * FROM termtype WHERE type='" . $view_type . "' ORDER BY type DESC, term");

echo '<form action="termtype.php" method="get" target="_blank">';
	
	echo '<td><input type="text" value="" name="term" /></td>';
	echo '<td><input type="text" value="' . $view_type . '" name="type" /></td>';
	echo '<td><button type="submit" name="action" value="create" >新增</button></td>';
	echo '<td> </td>';
	echo '</form>';

foreach ($terms AS $term_row) {
	
	if ($term_row["term"] === "") {
		continue;
	}
	?>
	<tr>
	<?php
	//echo '<td>' . $term_row["id"] . '</td>';
	echo '<form action="termtype.php" method="get" target="_blank">';
	echo '<input type="hidden" name="id" value="'.$term_row["id"].'" />';
	echo '<td><input type="text" value="' .$term_row["term"] . '" name="term" /></td>';
	echo '<td><input type="text" value="' .$term_row["type"] . '" name="type" /></td>';
	echo '<td><button type="submit" name="action" value="update" >修改</button></td>';
	echo '<td><button type="submit" name="action" value="delete" >刪除</button></td>';
	echo '</form>';
	//echo $term_row["type"];
	?>
	</tr>
	<?php
}

?>
	</tbody>
</table>
</div>

</body>
</html>