<?php
	include dirname(__FILE__).'/db/DAL/Web_Document.php';
	include dirname(__FILE__).'/util/DG_Page.php';
try {
    
	$prgName = "Web_Document";	
	$dal = new DAL_Web_Document();
	$myPage = new DG_Page($dal);

} catch (Exception $e) {
    print $e->getMessage();
exit();
}

	if (!empty($_REQUEST['type']) ) //  had query of parameter
	{
		$_POST['sort'] = "CreDate";
		$_POST['order'] = "desc";
		$type = $_REQUEST['type'];
		header("Content-Type: application/json; charset=utf-8");
		if($type == "data" || $type == "qry"){
			if($type == "data"){  // get more document
				$res = array();
				
				$_REQUEST['DBSTS'] = "A";
				$res["total"] = $dal->getTotalCount();
				
				$items = $dal->getData($_REQUEST);
				$data = array();
				$items2 = array();
				foreach ($items as $i => $doc) {
					$data["DocNum"] = $doc["DocNum"];
					$data["DocTitle"] = $doc["DocTitle"];
					$data["VisitNum"] = $doc["VisitNum"];
					$data["DocDescription"] = $doc["DocDescription"];
					array_push($items2, $data);
				}
				$res["rows"] = $items2;
				
				echo json_encode($res); 
			}else if($type == "qry"){  // get specific type of documents

				$items = $dal->getData($_REQUEST);

				echo json_encode($items);
			}
		}
	}else{  // show specific of document
		$criValues = array();
		if (!empty($_REQUEST["DocNum"]) ){
			$criValues['DocNum'] = $_REQUEST['DocNum'];
		}
		else{
			$criValues['DocNum'] = $_REQUEST['n'];
		}
			

		$items = $dal->getData($criValues);
		if(count($items) > 0){
			$data = $items[0];
			date_default_timezone_set('Asia/Taipei');
			$datetime = date('Y-m-d H:i:s');
			$criValues = array();
			$criValues['DocNum'] = $data['DocNum'];
			$criValues['VisitNum'] = $data['VisitNum'] + 1;
			$criValues["UpdUser"] = "sys";
			$criValues["UpdDate"] = $datetime;
			$result = $dal->real_update($criValues);

			$criValues = array();
			$criValues['DocType'] = $data['DocType'];
			$criValues['DBSTS'] = 'A';
			$items = $dal->getData($criValues);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.25" />
	<meta name="description" content='<?php echo $data['DocDescription']; ?>' />

	<link type="text/css" rel="stylesheet" href="StyleSheet.css" />
	<link type="text/css" rel="stylesheet" href="doc.css" />

	<script type="text/javascript" src="./oGrid/oGrid.util.js"></script>
	
	<script type="text/javascript" src="./prettify/prettify.js"></script>
	<link rel="stylesheet" href="./prettify/prettify.css" />
	
	<title>Web Title-<?php echo $data['DocTitle']; ?></title>
</head>
<body>


<style type="text/css">
.adslot_1 { width: 728px; height: 90px; }
@media (max-width:700px) { .adslot_1 { width: 468px; height: 60px; } }
</style>
  	<div class="page_main">
		<div style="background:#d8e9f4;display:block;">
			<div class="container">

			  <table cellpadding="0" cellspacing="0" style="width:100%;">
						<tbody>
							<tr>
								<td ><a class="mobile_menu_btn" href="http://o4u.tw"><img src="bars-home.png" /></a></td>
								<td style="height:62px;padding-left:10px;">
									<a href="/index.html" class="title">Web Title</a><br />
									<a href="/index.html" class="tdTitle_Normal" style="color:#999;">Weelcome...</a>
								</td>
						</tr>
						</tbody>
			  </table>
			  
			</div>
		</div>
		<div class="container">

			<div class="page_content" id="page_content" style="width: 100%;">
				<button class="mobile_button" style="width:100%" onclick="docDilog_close();">Close</button>
				<div id="doc_content" class="no_show" itemscope itemtype="http://schema.org/Article" >
					<h3>
					<?php 
						echo "<span itemprop='name'>".$data['DocTitle']."</span>&nbsp;&nbsp;<span class='view'> ".$data['VisitNum']." views</span>";
					?>

					</h3>
					<?php
						
						echo "<span itemprop='articleBody'>".$data['DocContent']."</span>";
					?>
					<br>&nbsp;

					<div class="fb-comments" expr:href="data:http://o4u.tw/WebDocTest.php?n=<?php echo $data['DocNum'] ?>" data-width='100%' data-numposts="5"></div>
					<?php 
						if(count($items) > 0){
							echo "<p><b>other doc link：</b><br>";
							$z = 0;
							foreach ($items as $i => $linkDoc) {
								if($data['DocNum'] != $linkDoc["DocNum"]){
									echo "<A href='WebDoc.php?DocNum=".$linkDoc["DocNum"]."'>".$linkDoc["DocTitle"]."</A><br>";
									$z += 1;
									if($z > 4)
										break;
								}
							}
						}
						?>
				</div>
				<button class="mobile_button" style="width:100%" onclick="docDilog_close();">Close</button>
			</div>
		</div>

	
		<div id="page_footer" class="page_footer" >

			Powered by <A href="babydragoner.html"> babydragoner</A> / Copyright  ?  2013 - watson chen
		</div>
	</div>

<SCRIPT language="javascript">

	window.onload = function () {
		var fdocs = document.getElementById("doc_content");
		var toHtml = new obj4u.ToHtml();
		fdocs.innerHTML = toHtml.preDecode(fdocs.innerHTML);
		prettyPrint();
		fdocs.className = "page_doc";
	}
	function docDilog_close() {
		window.close();
	}
</SCRIPT>

</body>
</html>

<?php
		}
	}
?>
