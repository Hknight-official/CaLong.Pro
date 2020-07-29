<?php
session_start();
include(__DIR__ ."/../api/config.php");
include(__DIR__ ."/../api/function.php");

if (!isset($_POST['pin'], $_POST['serial'], $_POST['card_type'], $_POST['card_amount'], $_POST['username'], $_POST["captcha"])){
	exit('<script type="text/javascript">toastr.error("Vui Lòng Nhập Đầy Đủ Thông Tin !");</script>');
}
if($_POST["captcha"] != $_SESSION["captcha_code"]){
	exit('<script type="text/javascript">toastr.error("Xác nhận captcha không đúng !");</script>');
}
$content = md5(time() . rand(0, 999999)); // chó thể điền thông tin username và các thông tin khác sau đó sử dụng dấu "." để ngăn cách dữ liệu với nhau
$seri = $conn->real_escape_string(strip_tags(addslashes($_POST['serial']))); // string
$pin = $conn->real_escape_string(strip_tags(addslashes($_POST['pin']))); // string
$loaithe = $conn->real_escape_string(strip_tags(addslashes($_POST['card_type']))); // string
$menhgia = $conn->real_escape_string(strip_tags(addslashes($_POST['card_amount']))); // string
$username = $conn->real_escape_string(strip_tags(addslashes($_POST['username']))); // string

    $napthe = new napthe($apikey, $apisecret);
		$method = array (
		 'pin' => $pin,
		 'type' => $loaithe, 
		 'amount' => $menhgia,
		 'seri' => $seri,	
		 'content' => $content,
		 'link_callback' => $link_callback	
	    );
		$check = $napthe->get_card_v2($method); // gọi hàm get_card_v2
		print_r($check);
	    if ($check['check'] == 200){                          
			if ($check['status'] == '00' || $check['status'] == 'thanhcong'){
				//Gửi thẻ thành công, đợi duyệt.
				$conn->query("Insert into trans_log (name,trans_id,amount,pin,seri,type) values ('".$username."','".$content."',".$menhgia.",'".$pin."','".$seri."','".$loaithe."')");
				echo '<script type="text/javascript">swal("Thành Công", "'.$check['msg'].'", "success");</script>';							
            } else if ($check['status'] != '00' && $check['status'] != 'thanhcong'){
				// thất bại ở đây
		       echo '<script type="text/javascript">toastr.error("'.$check['msg'].'");</script>';
		    }
		}