<html>
<head>
<style>
p.inline {display: inline-block;}
span { font-size: 10px;}
</style>
<style type="text/css" media="print">
    @page 
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */

    }
</style>
</head>
<body onload="window.print();">
	<div style="margin-left: 4%">
		<?php
		include 'barcode/barcode128.php';
		$product_id = $_GET['codigopr'];
		//$st =number_format($_GET['st'] ,0, '', '');
		$st =$_GET['st'] ;
		$rate = $_GET['pr'];;

		//for($i=1;$i<=$_POST['stockprint'];$i++){
		for($i=1;$i<=$st;$i++){
	echo "<p class='inline'>
	<span style='vertical-align: middle; display: table-cell;'>
	<b>".bar128(stripcslashes($product_id))."</b>
	</span>
	<span>
	<b>Precio: ".$rate." </b>
	<span>
		</p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
		}

		?>
	</div>
</body>
</html>