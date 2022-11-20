<?php

function mformat($value) {
  if ($value<0) return "-".mformat(-$value);
  return '₹ ' . number_format($value, 2);
}

function setcol($stat) {
  if ($stat=="PAID") 
  {
	  return "<span style='color:GREEN;'>".$stat."</span>";
  }elseif($stat=="NOT PAID"){ return "<span style='color:RED;'>".$stat."</span>";}else{ return "";}
}

function setcollp($stat,$dtx) {
	
	$tdate = date('d-m-Y');
 

    if($dtx <= $tdate && $stat=="NOT PAID") {

        return "<span style='color:RED;'>".$dtx."</span>";

    }elseif($dtx >= $tdate && $stat=="NOT PAID"){return "<span style='color:GREEN;'>".$dtx."</span>";}
	else{return $dtx;}
}

if (isset($_REQUEST['ubilldata'])){
	$invid= stripslashes($_REQUEST['invid']);
	$tamt= stripslashes($_REQUEST['tamt']);
	$subt= stripslashes($_REQUEST['subt']);
	$cusname= stripslashes($_REQUEST['cusname']); 
	$cusaddr = trim(stripslashes($_REQUEST['cusaddr'])); 
	$ctax = stripslashes($_REQUEST['ctax']); 
	$cusphone = stripslashes($_REQUEST['cusphone']);
    $cusemail = stripslashes($_REQUEST['cusemail']);
	$note = trim(stripslashes($_REQUEST['note']));
	$status = stripslashes($_REQUEST['status']);
	$gstp = stripslashes($_REQUEST['gstp']);
	$xamt= round($subt + (($subt * $gstp)/100) ,2);
  if(! empty($_POST['item'])){
  foreach ($_POST['item'] as $id =>$item){
	  $vaz =array("name"=>$_POST['item'],"qty"=>$_POST['iqty'],"iprice"=>$_POST['iprice']);
  }}
  $sql="UPDATE `invoice` SET `status`='".$status."',`note`='".$note."',`items`='".base64_encode(json_encode($vaz))."',`cname`='".$cusname."',`caddr`='".$cusaddr."',`cphone`='".$cusphone."',`cemail`='".$cusemail."',`ctax`='".$ctax."',`tamt`='".$xamt."',`gsta`='".$gstp."' WHERE `invid`='".$invid."';";
  if(mysqli_query($con, $sql)){
	  header("LOCATION: ./?edit=$invid");
  }
}
$error="";
if (isset($_REQUEST['view'])){
	$bid=stripslashes($_REQUEST['view']);
	$sql = "SELECT * FROM `invoice` WHERE `invid`='".$bid."'";
$result = mysqli_query($con, $sql);
$i =0;
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
	  if($row["type"]=="INV"){
		  $iv="INVOICE";
		  $ivt="INVOICE TO:";
		   $rqb="";
		   $email=$omail;
		  $billfoot='<b>Invoice was created on a computer and is not required to have the signature & seal.
		 <br> All the payments must be done on due date or Service will be terminated on 7th day of next month.</b>';
		 $rsig="";
		 $dte="Date of Invoice: ".$row["dateissue"];
		 $dtelp="Last date of Payment: ".setcollp($row["status"],$row["lpdate"])." <br /><strong>STATUS: ".setcol($row["status"])."</strong>";
	  }elseif($row["type"]=="PO"){
		   $rsig='<td class="authx" > Authorised Signature:  </td>     <br /><br /><br /> <br /><br /><br />';
		  $iv="PURCHASE ORDER";
		  $email=$pomail;
		  $ivt="PURCHASE FROM:";
		  $rqb='<div class="date">Required By: '.date('d-m-Y', strtotime($row["lpdate"].$porb)).'</div>';
		  $billfoot='<b>Purchase order was created on a computer and is not valid without the signature.If the payment has been made at the creation of this order, can take maximum of 3 days to arrive if not arrived immediately
		  This purchase order was genarated is/was/will classify as final.If payment not done by mentioned date by us this purchase order will be void.<a href="#">Contact us</a> if any query. </b>';
	     $dte="Issue Date: ".$row["dateissue"];
		 $dtelp="Payment within: ".$row["lpdate"]." <br /><strong>";
	  }else{  $iv="QUOTATION";
		  $ivt="QUOTATION FOR:";
		  $billfoot='<b>QUOTATION VALUE is FINAL ON THE DATE OF ISSUE + 7 DAYS. BUT AFTER 7 DAYS VALUE CAN BE HIGHER or lower. </b> ';
		   $rsig="";
		   $rqb="";
		   $email=$omail;
		   $dte="Date of Issue: ".$row["dateissue"];
		 $dtelp="Quotation Validity: ".setcollp($row["status"],$row["lpdate"])." <br />";
		  }
	  
	  
	  ?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $iv."_".$row["invid"];?></title>
	<link rel="stylesheet" href="./theme/<?php echo $theme;?>/style.css" media="all" />
  </head>
  <body><div id="body">
  <div id="pa">
    <header class="clearfix">
      <div id="logo"><a href="<?php echo $website;?>">
     <img src="data:image/png;base64,<?php echo $logoi;?>"></a>
      </div>
      <div id="company">
        <h2 class="name"><?php echo $cname; ?></h2>
        <div><?php echo $caddress; ?></div>
        <div><?php echo $phone; ?></div>
		<div>GST TIN:<?php echo $gsti; ?></div>
        <div><a href="<?php echo $email;?>"><?php echo $email;?></a></div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to"><?php echo $ivt;?></div>
          <h2 class="name"><?php echo $row["cname"];?></h2>
           <div class="ads">
		   
          <?php echo $row["caddr"];?><br/>
		  TAX ID-<?php if(!empty($row["cid"])){echo $row["cid"];}else{echo "Not Declared";}?>.  <br/>
		  Phone: <?php echo $row["cphone"];?>.
		  <br/>
		 E-Mail: <?php echo $row["cemail"];?>.
          </div>
        </div>
        <div id="invoice">
          <h3><?php echo $iv;?></h3>
          <div class="date"><?php echo $row["invid"];?></div>
          <div class="date"> <?php echo $dte;?></div>
		  <?php echo $rqb;?>
		  <div class="date"><?php echo $dtelp;?></div>
        </div>
      </div>
      <table border="1" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">#</th>
            <th colspan="2" class="desc">ITEM DESCRIPTION</th>
            <th class="qty">QTY</th>
			 <th class="qty">Price/ITEM</th>
            <th class="total">ITEM Total</th>
          </tr>
        </thead>
        <?php
		$subt=0;
		
		if(!empty($row["items"])){
		$items=json_decode(base64_decode($row["items"]),true);
		
		for ($i=0; $i <count($items['name']); $i++) 
         { 
	     $subt +=$items["qty"][$i] *$items["iprice"][$i];
        echo '<tbody> <tr><td class="no">'.$i.'</td><td colspan="2" class="desc">'.$items["name"][$i].'</td><td class="qty">'.$items["qty"][$i].'</td><td class="qty">'.mformat($items["iprice"][$i]).'</td><td class="invprice">'.mformat($items["qty"][$i] *$items["iprice"][$i]).'</td></tr></tbody>';
         }
        }
		?>

		  
        
        <tfoot >
		
          <tr>
            <td colspan="4"></td>
            <td colspan="0">SUBTOTAL:</td>
            <td><b><span id="totals"><?php echo mformat($subt); ?></span></b></td>
          </tr>
          <tr>
            <td colspan="4"></td>
            <td colspan="0">GST <?php echo $row["gsta"]; ?>%:</td>
            <td>+ <span id="gst"><?php echo mformat(round((($subt*$row["gsta"])/100),2));?></span></td>
          </tr>
          <tr>
            <td colspan="4"></td>
			<td colspan="0"><b>GRAND TOTAL:</b></td>
            <td><b><span id="gt"><?php echo mformat(round(( $subt + (($subt*$row["gsta"])/100)),2));?></span></b></td>
          </tr>
		  	  
		  <tr></tr>
		
		  
        </tfoot>
	
      
  
      </table>
	        
      <?php echo $rsig;?>
         <div id="notices">
       <strong>NOTE:</strong><br />
      <?php echo $row["note"];?>

      </div>
	  <footer>
	  <center><?php echo $billfoot;?></center>
	  </footer>
	  
	  
	  
	  
	   </main>
	</div>
	</div>
    
	<center><input class="btns" type="button" onclick="pa()" value="PRINT" /><a href="./"><button class="btns" id="bbtn">BACK</button></a></center>
	<script>
	function pa() {
      var printContents = document.getElementById('body').innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
	</script>
  </body>
</html>




	<?php
		
}}
	exit();
}elseif(isset($_REQUEST['edit']) && !empty($_SESSION['billadmin'])){
	$edt=stripslashes($_REQUEST['edit']);
	$sql = "SELECT * FROM `invoice` WHERE `invid`='".$edt."'";
$result = mysqli_query($con, $sql);
$i =0;
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
	  if($row["type"]=="INV"){
		  $iv="INVOICE";
		  $ivt="INVOICE TO:";
		  $email=$omail;
		  $rqb='';
		  $billfoot='<b>Invoice was created on a computer and is not required to have the signature & seal.
		 <br> All the payments must be done on due date or Service will be terminated on 7th day of next month.</b>';
		 $rsig="";
	  }elseif($row["type"]=="PO"){
		   $rsig='<td class="authx" > Authorised Signature:  </td>     <br /><br /><br /> <br /><br /><br />';
		  $iv="PURCHASE ORDER";
		  $ivt="PURCHASE FROM:";
		  $email=$pomail;
		  $rqb='<div class="date">Required By: '.date('d-m-Y', strtotime($row["lpdate"].$porb)).'</div>';
		  $billfoot='<b>Purchase order was created on a computer and is not valid without the signature.If the payment has been made at the creation of this order, can take maximum of 3 days to arrive if not arrived immediately
		  This purchase order was genarated is/was/will classify as final.If payment not done by mentioned date by us this purchase order will be void.<a href="#">Contact us</a> if any query. </b>';
	  }else{  $iv="QUOTATION";
		  $ivt="QUOTATION FOR:";
		  $billfoot='<b>QUOTATION VALUE is FINAL ON THE DATE OF ISSUE + 7 DAYS. BUT AFTER 7 DAYS VALUE CAN BE HIGHER or lower. </b> ';
		   $rsig="";
		   $rqb='';
		   $email=$omail;
		  }
	  
	  
	  ?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $iv."_".$row["invid"];?></title>
	<link rel="stylesheet" href="./theme/<?php echo $theme;?>/style.css" media="all" />
  </head>
  <body><div id="body">
  <form action="" method="POST">
  <div id="pa">
    <header class="clearfix">
      <div id="logo"><a href="<?php echo $website;?>">
     <img src="data:image/png;base64,<?php echo $logoi;?>"></a>
      </div>
      <div id="company">
        <h2 class="name"><?php echo $cname; ?></h2>
        <div><?php echo $caddress; ?></div>
        <div><?php echo $phone; ?></div>
		<div>GST TIN:<?php echo $gsti; ?></div>
        <div><a href="<?php echo $email;?>"><?php echo $email;?></a></div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to"><?php echo $ivt;?></div>
          <h2 class="name"><input type="text" name="cusname" value="<?php echo $row["cname"];?>" placeholder="Customer name" required /></h2>
           <div class="ads"><textarea name="cusaddr" style="width:256px;height:64px; resize: vertical;">
		   <?php echo trim($row["caddr"]);?>
		   </textarea>
		    <br/>
		   TAX ID-<input type="text" name="ctax" value="<?php echo $row["cid"];?>" placeholder="GST:ID or PAN:ID" />.
          <br/>
		  Phone: <input type="text" name="cusphone" value="<?php echo $row["cphone"];?>" placeholder="Customer Phone numbers" required />.
		  <br/>
		 E-Mail:  <input type="text" name="cusemail" value="<?php echo $row["cemail"];?>" placeholder="Customer Emails" required />.
          </div>
        </div>
        <div id="invoice">
          <h3><?php echo $iv;?></h3>
          <div class="date"><input type="text" name="invid" value="<?php echo $row["invid"];?>" readonly style="width:256px;" /></div>
          <div class="date">Date of Invoice: <?php echo $row["dateissue"];?></div>
		   <?php echo $rqb;?>
		  <div class="date">Last date of Payment:
		  <?php echo setcollp($row["status"],$row["lpdate"]);?> <br /><strong>STATUS:
		  <?php echo setcol($row["status"]);?><select name="status"><option value='<?php echo $row["status"];?>' selected> <?php echo $row["status"];?></option> <option value='PAID'>PAID</option><option value='NOT PAID'>NOT PAID</option></select></strong>
          </div>
        </div>
      </div>
      <table border="1" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">#</th>
            <th colspan="2" class="desc">ITEM DESCRIPTION</th>
            <th class="qty">QTY</th>
			 <th class="qty">Price/ITEM</th>
            <th class="total">ITEM Total</th>
          </tr>
        </thead>
		<tbody id="itemx" class="container1">
        <?php
		$subt=0;
		
		if(!empty($row["items"])){
		$items=json_decode(base64_decode($row["items"]),true);
		
		for ($i=0; $i <count($items['name']); $i++) 
         { 
	     $subt +=$items["qty"][$i] *$items["iprice"][$i];  
		  echo ' <tr><td class="no">'.$i.'<a href="#" class="delete"><button  type="button" class="close">X</button></a></td><td colspan="2" class="desc"><textarea name="item[]" style="width:100%;height:auto;">'.$items["name"][$i].'</textarea>
		</td><td class="qty"><input style="width:100%;" type="number" name="iqty[]" value="'.$items["qty"][$i].'" /></td><td class="qty"><input style="width:100%;" type="number" name="iprice[]" value="'.$items["iprice"][$i].'" /></td>
		<td class="invprice">'.mformat($items["qty"][$i] *$items["iprice"][$i]).'</td></tr>';
          } 
		}
		?>

		  
        </tbody>
        <tfoot >
		
          <tr>
            <td colspan="3"></td>
			<td ><button type="button" id="af" class="add_form_field">!ADD FIELD!</button></td>
            <td colspan="0">SUBTOTAL:</td>
            <td><b><input type="number" name="subt" value="<?php echo $subt; ?>" readonly /></b></td>
          </tr>
          <tr>
            <td colspan="4">SUBTOTAL & GST will be updated on click update button</td>
            <td colspan="0">GST <select name="gstp">
			<option value="<?php echo $row["gsta"]; ?>" selected><?php echo $row["gsta"]; ?> % Applied </option>
			<option value="<?php echo $gst; ?>"><?php echo $gst; ?> % Applicable </option>
			<option value="0">0 %</option>
			<option value="5">5 %</option>
			<option value="12">12 %</option>
			<option value="18">18 %</option>
			<option value="28">28 %</option>
			</select>:</td>
            <td>+ <span id="gst"><?php echo mformat(round((($subt*$row["gsta"])/100),2));?></span></td>
          </tr>
          <tr>
            <td colspan="4"></td>
			<td colspan="0"><b>GRAND TOTAL:</b></td>
            <td><b><span id="gt"><input type="text" name="tamt" value="<?php echo round(( $subt + (($subt*$row["gsta"])/100)),2);?>" readonly /></span></b></td>
          </tr>
		  	  
		  <tr></tr>
		
		  
        </tfoot>
	
      
  
      </table>
	        
      <?php echo $rsig;?>
         <div id="notices">
       <strong>NOTE:</strong><br /><textarea name="note" style="width:600px;height:128px; resize: vertical;">
	   
      <?php echo trim($row["note"]);?>
       </textarea>
      </div>
	  <footer>
	  <center><?php echo $billfoot;?></center>
	  </footer>
	  
	  
	  
	  
	   </main>
	</div>
	</div>
    
	<center><input class="btns" name="ubilldata" type="submit" value="UPDATE" /><a href="./"><input class="btns" type="button" value="BACK" /></a></center>
	</form>
  </body>
   <script language="JavaScript" type="text/javascript" src="./jquery.min.js"></script>
<script>
var cur = new Intl.NumberFormat('en-IN', {
  style: 'currency',
  currency: "INR",
});
$(document).ready(function() {
    var max_fields = 16;
    var wrapper = $(".container1");
    var add_button = $(".add_form_field");
    var close_button = $(".close");
    var x = 0;
    $(add_button).click(function(e) {
        e.preventDefault();
        if (x < max_fields) {
            x++;
            $(wrapper).append('<tr class="ovt"><td class="no">'+x+' <a href="#" class="delete"><button type="button" class="close">X</button></a></td><td colspan="2"><textarea style="width:100%;height:auto;" name="item[]" placeholder="Item With description"></textarea></td><td><input style="width:100%;"  type="number" name="iqty[]" min="0" placeholder="Qunatity"/></td><td><input type="number" style="width:100%;"  min="0" name="iprice[]" placeholder="Price For total quantity"/></td><td>WILL BE UPDATED on SAVE</td></tr>'); //add input box
        } else {
            alert('You Reached the limits')
        }
    });
	

    $(wrapper).on("click", ".delete", function(e) {
		
   var r=confirm("Removeing This Field will be unrecoverable!! Continue??")
   if (r==true)
   {
        e.preventDefault();
        $(this).parent('td').parent('tr').remove();
        x--;
   }
   else
   {
     
   }
    });
});


   
</script>
</html>




<?php	
}} exit();
}elseif(isset($_REQUEST['del'])){
	$invdid= stripslashes($_REQUEST['del']);
	$sql="DELETE FROM `invoice` WHERE `invid`='".$invdid."';";
  if(mysqli_query($con, $sql)){
	  header("LOCATION: ./");
  }
}elseif(isset($_REQUEST['newinv'])){
	$cdate=Date('d-m-Y', strtotime($invc));
	$ldp =Date('d-m-Y', strtotime($invlp));
	$invid=$id_start.Date('dmY')."-INV".Date('his');
	$type="INV";
	$sql="INSERT INTO `invoice`(`invid`, `dateissue`, `lpdate`, `status`, `note`, `items`, `type`, `cname`, `caddr`, `cphone`, `cemail`, `ctax`, `cid`, `tamt`, `gsta`) VALUES ('".$invid."','".$cdate."','".$ldp."','NOT PAID','','','".$type."','','','','','','','0','0');";
  if(mysqli_query($con, $sql)){
	  header("LOCATION: ./?edit=$invid");
  }
 
}elseif(isset($_REQUEST['newpo'])){
	$cdate=Date('d-m-Y', strtotime($poc));
	$ldp =Date('d-m-Y', strtotime($popd));
	$invid=$id_start.Date('dmY')."-PO".Date('his');
	$type="PO";
	$sql="INSERT INTO `invoice`(`invid`, `dateissue`, `lpdate`, `status`, `note`, `items`, `type`, `cname`, `caddr`, `cphone`, `cemail`, `ctax`, `cid`, `tamt`, `gsta`) VALUES ('".$invid."','".$cdate."','".$ldp."','NOT PAID','','','".$type."','','','','','','','0','0');";
  if(mysqli_query($con, $sql)){
	  header("LOCATION: ./?edit=$invid");
  }
 
}elseif(isset($_REQUEST['newquota'])){
	$cdate=Date('d-m-Y');
	$ldp =Date('d-m-Y', strtotime($lqto));
	$invid=$id_start.Date('dmY')."-QTA".Date('his');
	$type="";
	$sql="INSERT INTO `invoice`(`invid`, `dateissue`, `lpdate`, `status`, `note`, `items`, `type`, `cname`, `caddr`, `cphone`, `cemail`, `ctax`, `cid`, `tamt`, `gsta`) VALUES ('".$invid."','".$cdate."','".$ldp."','NOT PAID','','','".$type."','','','','','','','0','0');";
  if(mysqli_query($con, $sql)){
	  header("LOCATION: ./?edit=$invid");
  }
 
}elseif(isset($_REQUEST['logout'])){
	$_SESSION['billadmin']="";
	unset($_SESSION['billadmin']);
	if(session_destroy()){
	header("Location: ./"); }
 
}elseif(isset($_REQUEST['billbooklogin'])){
	$sql="SELECT * FROM `admin` WHERE `Email`='".$_REQUEST['login']."' AND `pass`='".md5($_REQUEST['password'])."';";
	$result = mysqli_query($con,$sql) or die(mysql_error());
	 		
if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
	  $_SESSION['billadmin']=md5($row['Email']);
	  header("LOCATION: ./");
}}else{
	$error="<span style='color:red;'>Wrong E-Mail / Password.....Forgot your password? Use server console and use mysql updateDB commands with key pass in md5.</span>" ;

  }
}



?>