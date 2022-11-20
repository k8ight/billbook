<?php
include("./config.php");
include("./engine.php");

if (!empty($_SESSION['billadmin'])){
?>
<html>
<head>
<link rel="stylesheet" href="./theme/<?php echo $theme;?>/bb.css" media="all" />
</head>
<body>
<div class="topnav">
<form  action="" style="display:inline;">
 <input type="text" name="search" placeholder="Search Bills IDs" style="width:300px;padding: 10px 12px;box-sizing: border-box;"/>
 <input type="submit" value="🔍" style="padding: 8px 10px;box-sizing: border-box;"/>
 </form>
  <a class="active" onclick="return confirm('Logout Now?? all unsaved progress will be lost!!');"  href="./?logout">Logout</a>
<a href="./?newpo"  onclick="return confirm('Create New Purchase order??');"  title="Create New PO" target="_self">Create PO +</a>
<a href="./?newinv"  onclick="return confirm('Create New Invoice??');"  title="Create New INVOICE" target="_self">Create INV +</a>
<a href="./?newquota"  onclick="return confirm('Create New Quotation??');" title="Create New INVOICE" target="_self">Create QUOTA +</a>
<a href="./"  title="HOME" target="_self">HOME</a>
</div>

<table class="tab">
  <tr >
    <th>#  </th>
    <th>BILL ID  </th>
	<th>BILL Type</th>
	<th>Amount</th>
	<th>BILL Status</th>
	<th>ISSUE Date</th>
	<th>lastPay Date</th>
	<th>Actions</th>
  </tr>
 
<?php
if (isset($_REQUEST['search'])){
$sql = "SELECT * FROM `invoice` WHERE `invid` LIKE '%".$_REQUEST['search']."%'; ";
$result = mysqli_query($con, $sql);
$i =0;
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
	  $i++;
	  $XD='return confirm("Deleting this will not be recoverd later? Continue?");';
    echo "<tr ><td>".$i. "</td><td> ".$row["invid"]. "</td><td> ".$row["type"]. "</td><td> ".mformat($row["tamt"]). "</td><td> ".setcol($row["status"]). "</td><td> ".$row["dateissue"]. "</td><td> ".setcollp($row["status"],$row["lpdate"]). "</td><td> 
	<a href='./?view=".$row["invid"]."'  target='_self'><button class='btns' title='VIEW this Bill'>VIEW</button></a>
	<a href='./?edit=".$row["invid"]."'  target='_self'><button class='btns' title='Edit this Bill'>EDIT</button></a>
	<a href='./?del=".$row["invid"]."'  target='_self'><button class='btns'  title='Delete this Bill' onclick='".$XD."'>DELETE</button></a>
	</td>";
  }
} else {
  echo "<tr><td colspan='8'> query matching ".$_REQUEST['search'].", Not found in database</td></tr>";
}
}else{
$sql = "SELECT * FROM `invoice`";
$result = mysqli_query($con, $sql);
$i =0;
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
	  $i++;
	  $XD='return confirm("Deleting this will not be recoverd later? Continue?");';
    echo "<tr ><td>".$i. "</td><td> ".$row["invid"]. "</td><td> ".$row["type"]. "</td><td> ".mformat($row["tamt"]). "</td><td> ".setcol($row["status"]). "</td><td> ".$row["dateissue"]. "</td><td> ".setcollp($row["status"],$row["lpdate"]). "</td><td> 
	<a href='./?view=".$row["invid"]."'  target='_self'><button class='btns' title='VIEW this Bill'>VIEW</button></a>
	<a href='./?edit=".$row["invid"]."'  target='_self'><button class='btns' title='Edit this Bill'>EDIT</button></a>
	<a href='./?del=".$row["invid"]."'  target='_self'><button class='btns'  title='Delete this Bill' onclick='".$XD."'>DELETE</button></a>
	</td>";
  }
} else {
  echo "<tr><td colspan='8'> No entry Added</td></tr>";
}

mysqli_close($con);
/*
$vaz=array("name"=>"Web Hosting & maintanace and Upgradation of website brightlandcomputer.com for 2 years","qty"=>"1","iprice"=>"5900");
$cat=base64_encode(serialize(array($vaz)));
base64_decode(unserialize(array($vaz))); for decode
echo $cat;*/
}
?>
</table>
</body></html>




<?php }else{ ?>
<html>
<head>
<style type="text/css">
body {
  font: 13px/20px "Lucida Grande", Tahoma, Verdana, sans-serif;
}

.login {
  position: relative;
  margin: 30px auto;
  padding: 20px 20px 20px;
  width: 310px;
  background: white;
  border-radius: 3px;
  -webkit-box-shadow: 0 0 200px rgba(255, 255, 255, 0.5), 0 1px 2px rgba(0, 0, 0, 0.3);
  box-shadow: 0 0 200px rgba(255, 255, 255, 0.5), 0 1px 2px rgba(0, 0, 0, 0.3);
}

.login:before {
  content: '';
  position: absolute;
  top: -8px;
  right: -8px;
  bottom: -8px;
  left: -8px;
  z-index: -1;
  background: rgba(0, 0, 0, 0.08);
  border-radius: 4px;
}

.login h1 {
  margin: -20px -20px 21px;
  line-height: 40px;
  font-size: 15px;
  font-weight: bold;
  color: #555;
  text-align: center;
  text-shadow: 0 1px white;
  background: #f3f3f3;
  border-bottom: 1px solid #cfcfcf;
  border-radius: 3px 3px 0 0;
  background-image: -webkit-linear-gradient(top, whiteffd, #eef2f5);
  background-image: -moz-linear-gradient(top, whiteffd, #eef2f5);
  background-image: -o-linear-gradient(top, whiteffd, #eef2f5);
  background-image: linear-gradient(to bottom, whiteffd, #eef2f5);
  -webkit-box-shadow: 0 1px whitesmoke;
  box-shadow: 0 1px whitesmoke;
}

.login p {
  margin: 20px 0 0;
  text-align:center;
}

.login p:first-child {
  margin-top: 0;
}
.login p.remember_me {
  float: left;
  line-height: 31px;
}

.login p.remember_me label {
  font-size: 12px;
  color: #777;
  cursor: pointer;
}

.login p.remember_me input {
  position: relative;
  bottom: 1px;
  margin-right: 4px;
  vertical-align: middle;
}

.login-help {
  margin: 20px 0;
  font-size: 11px;
  text-align: center;
}

.login-help a {
  text-decoration: none;
}

.login-help a:hover {
  text-decoration: underline;
}

:-moz-placeholder {
  color: #c9c9c9 !important;
  font-size: 13px;
}

::-webkit-input-placeholder {
  color: #ccc;
  font-size: 13px;
}

input {
  font-family: 'Lucida Grande', Tahoma, Verdana, sans-serif;
  font-size: 14px;
}

input[type=email], input[type=password] {
  margin: 5px;
  padding: 0 10px;
  width: 278px;
  height: 34px;
  color: #404040;
  background: white;
  border: 1px solid;
  border-color: #c4c4c4 #d1d1d1 #d4d4d4;
  /*border-radius: 2px;*/
  outline: 5px solid #eff4f7;
  -webkit-box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12);
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12);
}

input[type=text]:focus, input[type=password]:focus {
  border-color: #7dc9e2;
  outline-color: #dceefc;
  outline-offset: 0;
}

input[type=submit] {
	text-align:center;
	vertical-align:middle;
  padding: 0 18px;
  height: 29px;
  font-size: 12px;
  font-weight: bold;
  color: #527881;
  text-shadow: 0 1px #e3f1f1;
  background: #cde5ef;
  border: 1px solid;
  outline: 0;
  -webkit-box-sizing: content-box;
  -moz-box-sizing: content-box;
  box-sizing: content-box;
  background-image: -webkit-linear-gradient(top, #edf5f8, #cde5ef);
  background-image: -moz-linear-gradient(top, #edf5f8, #cde5ef);
  background-image: -o-linear-gradient(top, #edf5f8, #cde5ef);
  background-image: linear-gradient(to bottom, #edf5f8, #cde5ef);
  -webkit-box-shadow: inset 0 1px white, 0 1px 2px rgba(0, 0, 0, 0.15);
  box-shadow: inset 0 1px white, 0 1px 2px rgba(0, 0, 0, 0.15);
}

input[type=submit]:active {
  background: #cde5ef;
  border-color: #9eb9c2 #b3c0c8 #b4ccce;
  -webkit-box-shadow: inset 0 0 3px rgba(0, 0, 0, 0.2);
  box-shadow: inset 0 0 3px rgba(0, 0, 0, 0.2);
}

.lt-ie9 input[type=text], .lt-ie9 input[type=password] {
  line-height: 34px;
}
</style>
</head>
<body>


<div class="login">
  <h1>Login to Billbook</h1>
  <form method="post" action="">
  <p><?php echo $error?></p>
    <p><input type="email" name="login" placeholder="Username or Email" required ></p>
    <p><input type="password" name="password"  placeholder="Password" required ></p>
    <p class="submit"><input type="submit" name="billbooklogin" value="Login"></p>
  </form>
</div>

</body></html>
<?php }
	?>

