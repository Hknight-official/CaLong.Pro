<?php
	$apikey = '4db2c1f7c5c47898b701b7442b1b64e1'; //API key, lấy từ website calong.pro thay vào trong cặp dấu ''
	$apisecret = '7bed178a8e837b2c8d11e1990addb905'; //SECRET key, lấy từ website calong.pro thay vào trong cặp dấu ''
	$link_callback = "http://localhost/callback.php"; // link file callback để server api trả kết quả về
	// database Mysql config
	$local_db = "localhost";
	$user_db = "root";
	$pass_db = "";
	$name_db = "api_calong";
	# đừng đụng vào 
  $conn = new mysqli($local_db, $user_db, $pass_db, $name_db);
  $conn->set_charset("utf8");
