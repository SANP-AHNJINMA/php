<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	include('dbcon.php');
	
	$userID = isset($_POST["userID"]) ? $_POST["userID"] : '';
	
	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
	
	if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
	{
		// 안드로이드 코드의 postParameters 변수에 적어둔 이름을 가지고 값을 전달 받음.
		$setTemp=$_POST['setTemp'];
		
		// 입력안된 항목이 있을 경우 에러 메시지 출력
		if(empty($setTemp)) {
			$errMSG = "설정할 온도 수치를 입력하세요.";
		}
		// 에러메시지가 정의되어 있지 않으면 값들이 모두 입력된 경우
		if(!isset($errMSG)) {
			try{
				// SQL문을 실행하여 데이터를 MySQL 서버의 user 테이블에 저장
				$stmt = $con->prepare('UPDATE setev SET setTemp = :setTemp WHERE userID = "'.$userID.'"');
				$stmt->bindParam(':setTemp', $setTemp);
				//$stmt->bindParam(':userId', $userID);
				
				// SQL 실행 결과를 위한 메시지 생성
				if($stmt->execute()){
					$successMSG = "온도를 설정했습니다.";
				}
				else {
					$errMSG = "온도 설정에 실패했습니다.";
				}
			} catch(PDOException $e) {
				die("Database error : ". $e->getMessage());
			}
		}
	}
?>
<?php
	if(isset($errMSG)) echo $errMSG;
	if(isset($successMSG)) echo $successMSG;
	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

	if(!$android) {
?>
<html>
	<body>
		
		<form action="<?php $_PHP_SELF ?>" method="POST">
			온도 : <input type = "text" name = "setTemp" />
			<input type = "submit" name = "submit" />
		</form>
	</body>
</html>

<?php
	}
?>
		
		