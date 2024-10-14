<?php
$iwishCnt = 0;
$pdata = array();
$num_rec_per_page = 3;

	/* pagination */
	if (isset($_GET["page"])) {
		$page  = $_GET["page"];
	} else {
		$page = 1;
	}
	$start_from = ($page-1) * $num_rec_per_page;
	/* EOFpagination */

	$_REQUEST['iwishlist'] = '{"180268597":["412901713"],"180268853":["412902101"],"180269153":["412902489"],"180272273":["412907421"],"180272745":["412908285"],"180275373":["412912973"],"180275721":["412913437"],"182774681":["418302537"],"182871929":["418512317"]}';

	$pdataAll = json_decode($_REQUEST['iwishlist'], True);
	/*$pdataAll = array (
		"180266101" => array("412898285" => 1),
		"180266877" => array("412899209" => 1),
		"180272745" => array("412908285" => 1),
		"182774681" => array("418302537" => 1),
	);*/


	if ($start_from == 0) {
            $pdata = array_slice($pdataAll, 0, $num_rec_per_page, true);
        } else {
            $pdata = array_slice($pdataAll, $start_from, $num_rec_per_page, true); 
        }

	echo '<pre>';
	echo "<p>start_from :". $start_from." :: num_rec_per_page :".$num_rec_per_page."</p>";
	print_r($pdataAll);
	print_r($pdata);
	echo '</pre>';


	/* pagination */
	$custDatapagi = 'data-pagi="true"';
	$custparam = '';
	$total_records = count($pdataAll);  //count number of records
	$total_pages = ceil($total_records / $num_rec_per_page);
	if($total_pages>1) {
		$pagiStr = '<div class="pagination pagination-centered"><ul>';
		$pagiStr .= '<li><a title="first" href="/?'.$custparam.'&page=1" '.$custDatapagi.' data-page="1">&laquo;</a></li>'; // Goto 1st page
		for ($i=1; $i<=$total_pages; $i++) {
			if($i==$page) { $activeCls = 'active'; } else { $activeCls = ''; }
			$pagiStr .= '<li class="'.$activeCls.'"><a href="/?'.$custparam.'&page='.$i.'" '.$custDatapagi.' data-page="'.$i.'">'.$i.'</a></li>';
		}
		$pagiStr .= '<li><a title="last" href="/?'.$custparam.'&page='.$total_pages.'" '.$custDatapagi.' data-page="'.$total_pages.'">&raquo;</a></li>'; // Goto last page
		$pagiStr .= '</ul></div>';

	echo $pagiStr;
	}
	/* EOFpagination */

echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js" type="text/javascript"></script>';
echo '<script>
function iWishPost(e,t){
	method="post";var n=document.createElement("form");n.setAttribute("method",method);n.setAttribute("action",e);for(var r in t){if(t.hasOwnProperty(r)){var i=document.createElement("input");i.setAttribute("type","hidden");i.setAttribute("name",r);i.setAttribute("value",t[r]);n.appendChild(i)}}document.head.appendChild(n);n.submit()
}
jQuery("a[data-pagi=true]").click(function(e) {
	var pgno = jQuery(this).attr("data-page");
	var iwishlist = '.$_REQUEST['iwishlist'].';
	e.preventDefault();
	iWishPost("http://localhost/webroot/pagination.php?page="+pgno,{iwishlist:JSON.stringify(iwishlist),cId:0});
});
</script>';

/*
{"136462059":["43584371911","21758221383"],"136462151":[],"136462465":["311752563"],"136462543":["311752737"],"136462663":["311753109"],"136463037":["311754055"],"136463075":["43659223175"],"180259061":["412880457"],"180259357":["412881061"],"180260601":["412882745"],"180266101":["412898285"],"180266521":["412898817"],"180266877":["412899209"],"180268597":["412901713"],"180268853":["412902101"],"180269153":["412902489"],"180272273":["412907421"],"180272745":["412908285"],"180275373":["412912973"],"180275721":["412913437"],"182774681":["418302537"],"182871929":["418512317"]}*/

?>
