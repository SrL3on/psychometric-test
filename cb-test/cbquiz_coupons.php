<?php
	wp_enqueue_style("bootstrap","https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css");
	wp_enqueue_style("couponcss",plugins_url( 'css/couponcss.css', __FILE__ ));
	wp_enqueue_script("bootstrapjs","https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js");
	wp_enqueue_script("couponjs",plugins_url( 'js/couponjs.js', __FILE__ ));
	global $wpdb;
	if (isset($_POST['delete_coupon'])) {
		$char = $_POST['select_coupon'];
		foreach ($char as $del) {
			$table = $wpdb->prefix . "cb_coupon";
			$wpdb->delete($table,array('coupon_id' => $del));
		}
	}
	if (isset($_POST['add_coupon'])) {
		$table = $wpdb->prefix . "cb_coupon";
		$wpdb->insert($table,array('coupon_id' => '', 'coupon_code' => strtoupper($_POST['c_code']), 'coupon_discount' => $_POST['c_discount'], 'coupon_used' => '0', 'coupon_max_limit' => $_POST['c_limit'], 'coupon_email' => $_POST['c_email'], 'last_update' => date("Y-m-d H:i:s")));
	}
	if (isset($_POST['save'])) {
		$table = $wpdb->prefix . "cb_coupon";
		$wpdb->update($table,array('coupon_code' => strtoupper($_POST['coupon_code_edit']), 'coupon_discount' => $_POST['coupon_discount_edit'], 'coupon_max_limit' => $_POST['coupon_uses_limit_edit'], 'coupon_email' => $_POST['coupon_email_edit'], 'last_update' => date("Y-m-d H:i:s")),array('coupon_id' => $_POST['coupon_id_edit']));
	}
?>
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 id="trial">Edit Coupon</h3>
        </div>
        <div class="modal-body">
        	<form method="post">
        		<table>
          			<tr>
          				<td><b>Coupon Code</b></td>
          				<td><input type="text" id="coupon_code_edit" name="coupon_code_edit" required="required"></td>
          			</tr>
          			<tr>
          				<td><br><b>Coupon Discount(%)</b></td>
          				<td><br><input type="text" id="coupon_discount_edit" name="coupon_discount_edit" required="required"></td>
          			</tr>
          			<tr>
          				<td><br><b>Coupon Uses Limit</b></td>
          				<td><br><input type="text" id="coupon_uses_limit_edit" name="coupon_uses_limit_edit" required="required"></td>
          			</tr>
          			<tr>
          				<td><br><b>Email Id</b></td>
          				<td><br><input type="email" id="coupon_email_edit" name="coupon_email_edit"></td>
          			</tr>
          			<tr>
          				<td><br><input type="hidden" id="coupon_id_edit" name="coupon_id_edit"></td>
          				<td><br></td>
          			</tr>
          			<tr>
          				<table>
          					<tr>
          						<td><button type="submit" name="save" class="btn btn-primary">Save</button></td>
          					</tr>
          				</table>
          			</tr>
          		</table>
          	</form>
        </div>
      </div>
      
    </div>
  </div>
  
<div class="container">
	<div>
		<h2>Coupons</h2>
	</div>
	<ul class="nav nav-tabs">
	    <li class="active"><a data-toggle="tab" href="#alco">All Coupon</a></li>
	    <li><a data-toggle="tab" href="#adco">Add Coupon</a></li>
	    <li><a data-toggle="tab" href="#dco">Edit / Delete Coupon</a></li>
  	</ul>
  	<br>
  	<div class="tab-content">
    	<div id="alco" class="tab-pane fade in active">
    		<table align="center" class="table text-center">
					<tr>
						<td><b>No</b></td>
						<td><b>Coupon Code</b></td>
						<td><b>Coupon Discount (%)</b></td>
						<td><b>Coupon Used</b></td>
						<td><b>Coupon Uses Limit</b></td>
						<td><b>Email Id</b></td>
					</tr>
						<?php
							global $wpdb;
							$table = $wpdb->prefix . "cb_coupon";
							$result = $wpdb->get_results("SELECT * FROM `$table` ORDER BY last_update DESC");
							$sl = 1;
							foreach ($result as $key) {
								echo "<tr>";
								echo "<td>".$sl."</td>";
								echo "<td>".$key->coupon_code."</td>";
								echo "<td>".$key->coupon_discount."</td>";
								echo "<td>".$key->coupon_used."</td>";
								echo "<td>".$key->coupon_max_limit."</td>";
								echo "<td>".$key->coupon_email."</td>";
								echo "</tr>";
								$sl++;
							}
						?>
				</table>
    	</div>
    	<div id="adco" class="tab-pane fade">
    		<form method="POST" class="form">
    			<table>
    				<tr>
	    				<td><label>Coupon Code</label></td>
	    				<td><input type="text" name="c_code" required="required"></td>
	    				<td>&nbsp &nbsp &nbsp</td>
	    				<td><label>Coupon Discount (%)</label></td>
	    				<td><input type="text" name="c_discount" required="required"></td>
	    				<td><br></td>
	    			</tr>
	    			<tr>
	    				<td><label>Coupon Uses Limit</label></td>
	    				<td><input type="text" name="c_limit" required="required"></td>
	    				<td>&nbsp &nbsp &nbsp</td>
	    				<td><label>Email Id</label></td>
	    				<td><input type="email" name="c_email"></td>
	    				<td><br><br><br></td>
	    			</tr>
	    			<tr>
	    				<table>
	    					<tr>
	    						<td><button type="submit" name="add_coupon" class="btn btn-primary">Add Coupon</button></td>
	    					</tr>
	    				</table>
	    			</tr>
	    		</table>
    		</form>
    	</div>
		<div id="dco" class="tab-pane fade">
			<form method="POST">
				<table align="center" class="table text-center">
					<tr>
						<td><b>No</b></td>
						<td><b>Coupon Code</b></td>
						<td><b>Coupon Discount (%)</b></td>
						<td><b>Coupon Used</b></td>
						<td><b>Coupon Uses Limit</b></td>
						<td><b>Email Id</b></td>
						<td><b>Select Coupon</b></td>
						<td></td>
					</tr>
						<?php
							global $wpdb;
							$table = $wpdb->prefix . "cb_coupon";
							$result = $wpdb->get_results("SELECT * FROM `$table` ORDER BY last_update DESC");
							$sl = 1;
							foreach ($result as $key) {
								echo "<tr>";
								echo "<td>".$sl."</td>";
								echo "<td>".$key->coupon_code."</td>";
								echo "<td>".$key->coupon_discount."</td>";
								echo "<td>".$key->coupon_used."</td>";
								echo "<td>".$key->coupon_max_limit."</td>";
								echo "<td>".$key->coupon_email."</td>";
								echo "<td><input type='checkbox' name='select_coupon[]' value='".$key->coupon_id."' /></td>";
								echo '<td><form method="post"><button type="button" onclick="getdata('.$key->coupon_id.',\''.$key->coupon_code.'\','.$key->coupon_discount.', '.$key->coupon_max_limit.', \''.$key->coupon_email.'\')" class="btn btn-info" data-toggle="modal" data-target="#myModal">Edit</button></form>';
								echo "</tr>";
								$sl++;
							}
						?>
					<tr>
						<table align="center">
							<tr>
								<td><button type="submit" class="btn btn-danger" name="delete_coupon">Delete Coupon</button></td>
							</tr>
						</table>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>