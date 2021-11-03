<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	include('dbcon.php');
	
	//$userID = isset($_POST["userID"]) ? $_POST["userID"] : 'soo';

	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

	if(($_SERVER['REQUEST_METHOD'] == 'POST') || isset($_POST['submit'])||$android)
	{
        $houseID = '1';
        $temp = $_POST['temp'];
        $moisture = $_POST['moisture'];
        $lux = $_POST['lux'];
        $soil_moist = $_POST['soil_moist'];

        echo $houseID;
        echo '<br>';
        echo $temp;
        echo '<br>';
        echo $moisture;
        echo '<br>';
        echo $lux;
        echo '<br>';
        echo $soil_moist;
        echo '<br>';
        
        $result = '';
		
		// 입력안된 항목이 있을 경우 에러 메시지 출력
		if(!isset($temp)||!isset($moisture)||!isset($lux)||!isset($soil_moist)) {
			$errMSG = "데이터가 누락되었습니다.";
		}
		// 에러메시지가 정의되어 있지 않으면 값들이 모두 입력된 경우
		if(!isset($errMSG)) {
			try{
                echo 'test';
                echo '<br>';
                $st = $con->prepare('SELECT * from house where houseID="'.$houseID.'"');
				// SQL문을 실행하여 데이터를 MySQL 서버의 user 테이블에 저장
                if($st->execute()) {
                    echo 'test2';
                    try {
                        while($record = $st->fetch(PDO::FETCH_ASSOC)){ 
                            $result .= "<tr>";
                            foreach($record as $column){ 
                                $result .= "<td>" . $column . "</td>";
                            } 
                            $result .= "</tr>"; 
                        }
                    } catch(PDOException $e){ 
                        $result = "#ERR:" . $e->getMessage(); 
                    }
                    echo $result;
                   if($result == '') $st = $con->prepare('INSERT into house(houseID,temp,moisture,lux,soil_moist) values ('.$houseID.','.$temp.','.$moisture.','.$lux.','.$soil_moist.')');
                }
                
                $stmt = $con->prepare('UPDATE house SET houseID="'.$houseID.'", temp="'.$temp.'", moisture="'.$moisture.'", lux="'.$lux.'", soil_moist="'.$soil_moist.'" WHERE houseID = "1"');
                echo'test3';
				// $stmt->bindParam(':houseID', $houseID);
				// $stmt->bindParam(':temp', $temp);
				// $stmt->bindParam(':moist', $moist);
				// $stmt->bindParam(':lux', $lux);
				// $stmt->bindParam(':soil_moist', $soil_moist);
				
				// SQL 실행 결과를 위한 메시지 생성
				if($stmt->execute()){
					$successMSG = "데이터를 저장하였습니다.";
				}
				else {
					$errMSG = "데이터 저장에 실패했습니다.";
				}
			} catch(PDOException $e) {
				die("Database error : ". $e->getMessage());
			}
		}
	}

	if(isset($errMSG)) echo $errMSG;
	if(isset($successMSG)) echo $successMSG;

?>
