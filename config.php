<?php
session_start();
$cname="Company Name";/*company name*/
$caddress="Company Address";/*company address*/
$phone="(+00)phone Number";/*company phone*/
$omail="billbook@localhost.net";/*company Email*/
$pomail="billbook@localhost.net";/*company Email*/
$gsti="N/A";/*GST TIN NO or N/A*/
$gst="0";/*gst cgst+sgst=18 no % entry here */
$fine="10%";/*fine to show for cheque bounce or late payment */
$logo="logo.png";/*Add your Logo PNG format in index dir*/
$signature="./comx.png";/*Authorised Signature PNG format*/
$dateformat="d-m-Y";/*d-m-y D-m-y d=M-y d-m-Y D-M-Y*/
$invc="+0 days";/*Invoice Creation Date*/
$invlp="+7 days";/*Invoice Last Date of payment*/
$poc="+1 days";/*purchase order creation date today + 3 day*/
$popd="+23 days";/*purchase order Payment comit date today + 24 day*/
$porb="+7 days";/*purchase order estimated delivary by vendor date $popd + 7 days day*/
$lqto="+30 days";/*Last Date of quotation Validity*/
$id_start="COMPANY_";/*ID start Company_ or COMPANY- etc*/
$website="https://website.domain";/*Full uri like https://google.com  or place # for no link*/
$note="";/*Special note to include on all invoices dynamicly*/
$theme="default";
/*DATABASE CONNECT AREA*/
$dbhost="127.0.0.1";
$dbname="billbook";/*default DB name: billbook*/
$dbuser="root";
$dbpassword="password";
$con = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
if (mysqli_connect_errno()) { echo "Failed to connect to MySQL: " . mysqli_connect_error(); }
/*DATABASE CONNECT AREA*/
/*DO NOT TOUCH*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$logoi = base64_encode(file_get_contents("./".$logo)); 

/*DO NOT TOUCH*/
?>
