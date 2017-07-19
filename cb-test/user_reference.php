<?php
	wp_enqueue_script("couponjs",plugins_url( 'js/couponjs.js', __FILE__ ));
	wp_enqueue_style("stylecss",plugins_url( 'css/style.css', __FILE__ ));
	wp_enqueue_style("pagination-css",plugins_url( 'css/pagination.css', __FILE__ ));
	if ($_GET['reference_no']) {
		global $wpdb;
		$ref = $_GET['reference_no'];
		$table1 = $wpdb->prefix . "users";
		$table2 = $wpdb->prefix . "cb_result_master";
		$sql = "SELECT t2.payment AS payment, t1.ID AS ID, t1.display_name AS display_name, t1.user_email AS user_email FROM `$table1` t1, `$table2` t2 WHERE (t1.ID = t2.uid) AND (t2.ref_no = '".$ref."')";
		$result_ref = $wpdb->get_results($sql);
	}
	if (!is_user_logged_in()) {
		echo '<h2>OOOPPPPPPSSSSS something went wrong. Please <a href="'.site_url().'">click here</a> to go back.</h2>';
	    exit();
	}
	else {
?>
<div>
	<div>
		<form method="get" id="form">
			<input type="text" class="input" id="reference_no" name="reference_no" value="<?php if (isset($_GET['reference_no'])) { echo $_GET['reference_no']; }  ?>">
			<button type="submit" class="btn">Search</button>
		</form>
	</div>
	<?php if (isset($_GET['reference_no']) && !empty($result_ref)) { 
		$user_data = get_userdata(get_current_user_id());
		//echo $user_data->user_email;
	?>
	<br>
	<div>
		<div>
			<input type="hidden" id="i_email" value="<?php echo $user_data->user_email; ?>">
			<input type="hidden" id="url_hidden" value="<?php echo site_url(); ?>">
			<p id="suc"></p>
		</div>
		<table>
			<tr>
				<td>Name:</td>
				<td><?php echo $result_ref[0]->display_name; ?></td>
			</tr>
			<tr>
				<td>Email:</td>
				<td><?php echo $result_ref[0]->user_email; ?></td>
			</tr>
			<tr>
				<td>Report</td>
				<td id="suc_s">
					<?php if($result_ref[0]->payment == 1) {
						echo "<b style='color: blue'>Report Unlocked</b>";
					}
					else {
						echo "<button class='btn' id='unlock'>Unlock</button>";
					}
					?>
				</td>
			</tr>
		</table>
	</div>
	<?php } elseif(isset($_GET['reference_no']) && empty($result_ref)) { ?>
	<div>
		<p style="color: red;">Invalid Referance Id.</p>
	</div>
	<?php } ?>
	<?php 
		global $wpdb;
		$offset_value = 0;
		if (!empty($_GET['page_no']) && is_numeric($_GET['page_no']) && ($_GET['page_no'] > 0)) {
			$page_no = $_GET['page_no'];
			$offset_value = 10 * ($page_no - 1);
		}
		$user_data_email = get_userdata(get_current_user_id());
		$table1 = $wpdb->prefix . "cb_result_master";
		$table2 = $wpdb->prefix . "users";
		$table3 = $wpdb->prefix . "cb_test";
		$table4 = $wpdb->prefix . "cb_coupon";
		$coupon = $wpdb->get_results("SELECT t4.coupon_code AS coupon_code FROM `$table4` t4 WHERE t4.coupon_email = '".$user_data_email->user_email."' ");
		$sql_data = "SELECT t1.ref_no AS ref_no, t3.name AS test_name, t2.display_name AS display_name FROM `$table1` t1, `$table2` t2, `$table3` t3 WHERE t1.uid = t2.ID AND t1.test_id = t3.test_id AND t1.applied_coupon = '".$coupon[0]->coupon_code."' ORDER BY t2.display_name ASC LIMIT 10 OFFSET ".$offset_value." ";
		$coupon_user_data = $wpdb->get_results($sql_data);

		$sql_data_page = "SELECT count(*) FROM `$table1` t1, `$table2` t2, `$table3` t3 WHERE t1.uid = t2.ID AND t1.test_id = t3.test_id AND t1.applied_coupon = '".$coupon[0]->coupon_code."' ORDER BY t2.display_name ASC";
		$total_no = $wpdb->get_var($sql_data_page);
		$total_pages = ceil($total_no / 10);
		//print_r($coupon_user_data);
		

		/*$sql = "SELECT t1.ref_no AS ref_no, t2.display_name AS display_name, t3.name as name FROM `$table1` t1, `$table2` t2, `$table3` t3, `$table4` t4 WHERE t4.coupon_email = t2.users AND t4.coupon_email = '".$user_data_email->user_email."' AND t3.test_id = t1.test_id AND t4.coupon_code = t1.applied_coupon AND t1.payment = 1";
		$reference_nos = $wpdb->get_results($sql);*/
		if(empty($coupon_user_data)) {
			echo "<div><h2 style='color: red'>You don't have any report!</h2></div>";
		}
		else {
	?>
	<br>
	<div>
	<div align="center">
		<table class="order-table" cellpadding="5"  cellspacing="10">
			<th>SL</th>
			<th>Test Name</th>
			<th>Name</th>
			<th>Reference No</th>
			<th>Report</th>
			<?php
				$offset_value =$offset_value + 1;
				foreach ($coupon_user_data as $reference_no) {
					echo "<tr>";
					echo "<td>".$offset_value++."</td>";
					echo "<td>".$reference_no->test_name."</td>";
					echo "<td>".$reference_no->display_name."</td>";
					echo "<td>".$reference_no->ref_no."</td>";
					echo "<td><a href='".site_url(get_option('brand_result_page'))."/?ref_no=".$reference_no->ref_no."' target='_blank'>Download Report</td>";
					echo "</tr>";
				}
			?>
		</table>
	</div><br /><br /><br />
	<div class="center">
		<div class="pagination">
			<?php
				$page_link = get_permalink();
				for ($i=1; $i<=$total_pages; $i++) {
					if ($page_no == $i) {
					 	$state = "class='active'";
					}
					elseif (!isset($page_no)) {
						$page_no = 1;
						if ($page_no == $i) {
							$state = "class='active'";
						}
						else {
							$state = "";
						}
					}
					else {
						$state = "";
					} 
		            echo "<a href='".$page_link."?page_no=".$i."' ".$state.">".$i."</a> "; 
				}
			?>
		</div>
	</div>
</div>
	<?php }  ?>
</div>
<?php } ?>