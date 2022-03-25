<?php
 
// Connect to database
// Server - localhost
// Username - root
// Password - empty
// Database name = xmldata
$conn = mysqli_connect("localhost", "root", "", "xmlbaza");
 
$affectedRow = 0;
 
// Load xml file else check connection
$xml = simplexml_load_file("PriceAvail.xml")
    or die("Error: Cannot create object");
 
// Assign values
foreach ($xml->children() as $row) {
    $wic = $row->WIC;
    $description = $row->DESCRIPTION;
    $vendor_name = $row->VENDOR_NAME;
    $group_name = $row->GROUP_NAME;
	 $vpf_name = $row->VPF_NAME;
	 $currency_code = $row->CURRENCY_CODE;
	  $avail = $row->AVAIL;
	   $retail_price = $row->RETAIL_PRICE;
	    $my_price = $row->MY_PRICE;
		 $warrantyterm = $row->WARRANTYTERM;
		  $group_id = $row->GROUP_ID;
		   $vendor_id = $row->VENDOR_ID;
		    $small_image = $row->SMALL_IMAGE;
			 $product_card = $row->PRODUCT_CARD;
			  $ean = $row->EAN;
     
    // SQL query to insert data into xml table
    $sql = "INSERT INTO product(wic, description,
        vendor_name, group_name,vpf_name,currency_code, avail, retail_price, my_price, warrantyterm, group_id, vendor_id, small_image, product_card, ean) VALUES ('"
        . $wic . "','" . $description . "','"
        . $vendor_name . "','" . $group_name . "','" . $vpf_name . "','" . $currency_code . "', '" . $avail . "', '" . $retail_price . "', '" . $my_price . "', '" . $warrantyterm . "', '" . $group_id . "', '" . $vendor_id . "', '" . $small_image . "', '" . $product_card . "', '" . $ean . "')";
     
    $result = mysqli_query($conn, $sql);
     
    if (! empty($result)) {
        $affectedRow ++;
    }
}
?>
 
<center><h2>Pohrana podataka</h2></center>

<?php
if ($affectedRow > 0) {
    $message = $affectedRow . " records inserted";
} else {
    $message = "No records inserted";
}
 
?>
<style>
    body { 
        max-width:550px;
        font-family: Arial;
    }
    .affected-row {
        background: #cae4ca;
        padding: 10px;
        margin-bottom: 20px;
        border: #bdd6bd 1px solid;
        border-radius: 2px;
        color: #6e716e;
    }
    .error-message {
        background: #eac0c0;
        padding: 10px;
        margin-bottom: 20px;
        border: #dab2b2 1px solid;
        border-radius: 2px;
        color: #5d5b5b;
    }
</style>
 
<div class="affected-row">
    <?php  echo $message; ?>
</div>
 
<?php if (! empty($error_message)) { ?>
 
<div class="error-message">
    <?php echo nl2br($error_message); ?>
</div>
<?php } ?>