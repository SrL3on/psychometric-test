<?php 
	global $wpdb;
	$error = "";
	$result[0] = get_option('brand_logo');
	$result[1] = get_option('brand_name');
	$result[2] = get_option('brand_email');
	$result[3] = get_option('brand_phone_no');
	$result[4] = get_option('brand_website');
	$result[5] = get_option('brand_result_page');
	//echo wp_basename($result[0]);
	//print_r($result);
	//echo "<br>".count($result);
	if (isset($_POST['b_submit'])) {
		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}
		//echo $_FILES['b_logo']['name'];
		if(!empty($_FILES['b_logo']['name'])) {
			if ($_FILES['b_logo']['name'] != wp_basename($result[0])) {
				$upload_file = $_FILES['b_logo'];
				$movefile = wp_handle_upload($upload_file, array('test_form' => FALSE));
				$uploads = wp_upload_dir();
				$b_logo =  $uploads['url']."/".$_FILES['b_logo']['name'];
			}
			else {
				$b_logo = $result[0];
			}
		}
		elseif(!empty($result[0])) {
			$b_logo = $result[0];
		}
		else{
			$error = "<h4 style='color:red;'>Failed to save</h4>";
		}
		$b_name = $_POST['b_name'];
		$b_email = $_POST['b_email'];
		$b_phone = $_POST['b_phone'];
		$b_website = $_POST['b_website'];
		$b_result_page = $_POST['b_result_page'];
		//var_dump($movefile);
		//echo "<br>".$b_logo;
		
		
		if(empty($result[0]) && empty($result[1]) && empty($result[2])){
			if ($movefile && !empty($b_name) && !empty($b_email) && !empty($b_phone) && !empty($b_website)) {
				add_option('brand_logo',$b_logo);
				add_option('brand_name',$b_name);
				add_option('brand_email',$b_email);
				add_option('brand_phone_no',$b_phone);
				add_option('brand_website',$b_website);

				$result[0] = get_option('brand_logo');
				$result[1] = get_option('brand_name');
				$result[2] = get_option('brand_email');
				$result[3] = get_option('brand_phone_no');
				$result[4] = get_option('brand_website');
			}
			elseif ($movefile && !empty($b_name) && !empty($b_email) && !empty($b_phone)) {
				add_option('brand_logo',$b_logo);
				add_option('brand_name',$b_name);
				add_option('brand_email',$b_email);
				add_option('brand_phone_no',$b_phone);

				$result[0] = get_option('brand_logo');
				$result[1] = get_option('brand_name');
				$result[2] = get_option('brand_email');
				$result[3] = get_option('brand_phone_no');
				$result[4] = "";
			}
			elseif ($movefile && !empty($b_name) && !empty($b_email) && !empty($b_website)) {
				add_option('brand_logo',$b_logo);
				add_option('brand_name',$b_name);
				add_option('brand_email',$b_email);
				add_option('brand_website',$b_website);

				$result[0] = get_option('brand_logo');
				$result[1] = get_option('brand_name');
				$result[2] = get_option('brand_email');
				$result[3] = "";
				$result[4] = get_option('brand_website');
			}
			elseif ($movefile && !empty($b_name) && !empty($b_email)) {
				add_option('brand_logo',$b_logo);
				add_option('brand_name',$b_name);
				add_option('brand_email',$b_email);

				$result[0] = get_option('brand_logo');
				$result[1] = get_option('brand_name');
				$result[2] = get_option('brand_email');
				$result[3] = "";
				$result[4] = "";
			}
			else {
				$error .= "<h4 style='color:red;'>Failed to save</h4>";
			}
			add_option('brand_result_page',$b_result_page);
			$result[5] = get_option('brand_result_page');
		}
		else {
			if (isset($b_name) && isset($b_email) && isset($b_phone) && isset($b_website)) {
				update_option('brand_logo',$b_logo);
				update_option('brand_name',$b_name);
				update_option('brand_email',$b_email);
				update_option('brand_phone_no',$b_phone);
				update_option('brand_website',$b_website);

				$result[0] = get_option('brand_logo');
				$result[1] = get_option('brand_name');
				$result[2] = get_option('brand_email');
				$result[3] = get_option('brand_phone_no');
				$result[4] = get_option('brand_website');
			}
			elseif (isset($b_name) && isset($b_email) && isset($b_phone)) {
				update_option('brand_logo',$b_logo);
				update_option('brand_name',$b_name);
				update_option('brand_email',$b_email);
				update_option('brand_phone_no',$b_phone);

				$result[0] = get_option('brand_logo');
				$result[1] = get_option('brand_name');
				$result[2] = get_option('brand_email');
				$result[3] = get_option('brand_phone_no');
				$result[4] = "";
			}
			elseif (isset($b_name) && isset($b_email) && isset($b_website)) {
				update_option('brand_logo',$b_logo);
				update_option('brand_name',$b_name);
				update_option('brand_email',$b_email);
				update_option('brand_website',$b_website);

				$result[0] = get_option('brand_logo');
				$result[1] = get_option('brand_name');
				$result[2] = get_option('brand_email');
				$result[3] = "";
				$result[4] = get_option('brand_website');
			}
			elseif (isset($b_name) && isset($b_email)) {
				update_option('brand_logo',$b_logo);
				update_option('brand_name',$b_name);
				update_option('brand_email',$b_email);

				$result[0] = get_option('brand_logo');
				$result[1] = get_option('brand_name');
				$result[2] = get_option('brand_email');
				$result[3] = "";
				$result[4] = "";
			}
			else {
				$error = "<h4 style='color:red;'>Failed to update</h4>";
			}
			update_option('brand_result_page',$b_result_page);
			$result[5] = get_option('brand_result_page');
		}

	}	
?>
<div class="wrap">
	<h1>Branding</h1>
	<form method="post" class="form" enctype="multipart/form-data">
		<table class="form-table">
			<tr>
				<th scope="row"><lable for="brandlogo">Brand Logo <span style="color: red">*</span></lable></th>
				<td><input type="file" name="b_logo" class="regular-text"></td>
				<?php if (!empty($result[0])) echo '<td><img src="'.$result[0].'" width="300" height="200"></td>'; ?>
			</tr>
			<tr>
				<th scope="row"><lable for="brandname">Brand Name <span style="color: red">*</span></lable></th>
				<td><input type="text" name="b_name" class="regular-text" required="required" value="<?php echo $result[1]; ?>"></td>
			</tr>
			<tr>
				<th scope="row"><label for="brandemail">Brand Email <span style="color: red">*</span></label></th>
				<td><input type="email" name="b_email" class="regular-text" required="required" value="<?php echo $result[2]; ?>"></td>
			</tr>
			<tr>
				<th scope="row"><label for="brandphoneno">Brand Phone No</label></th>
				<td><label><input type="text" name="b_phone" class="regular-text" value="<?php echo $result[3]; ?>"></label></td>
			</tr>
			<tr>
				<th scope="row"><label for="brandwebsite">Brand Website</label></th>
				<td><input type="text" name="b_website" class="regular-text" value="<?php echo $result[4]; ?>"></td>
			</tr>
			<tr>
				<th scope="row"><label for="brandresultpage">Result Page <span style="color: red">*</span></label></th>
				<td>
					<select name="b_result_page" class="regular-text">
						<option value="">choose</option>
						<?php
							$sel = "";
							$pages= get_pages();
							foreach ($pages as $page) {
								if ($result[5] == $page->post_name) {
									$sel = "SELECTED";
								}
								else{
									$sel = "";
								}
								echo "<option value='".$page->post_name."'".$sel." >".$page->post_name."</option>";
							} 
							?>
					</select>
				</td>
			</tr>
			<tr>
				<table>
					<tr>
						<td><button type="submit" name="b_submit" class="button button-primary">Save Changes</button></td>
						<td><?php echo $error; ?></td>
					</tr>
				</table>
			</tr>
		</table>
	</form>
</div>