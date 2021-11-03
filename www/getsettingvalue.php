<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	include('dbcon.php');
	
	//$userID = isset($_POST["userID"]) ? $_POST["userID"] : 'soo';

	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

	if(($_SERVER['REQUEST_METHOD'] == 'POST') || isset($_POST['submit'])||$android)
	{
        $houseID = $_POST['houseID'];
        //$userID = $_POST['userID'];
        
        $result = "";

        if(empty($houseID)&&empty($userID)) {
            $errMSG = "데이터 호출에 실패했습니다.";
        }
        
		// 에러메시지가 정의되어 있지 않으면 값들이 모두 입력된 경우
		if(!isset($errMSG)) {
			try{
                $st = $con->prepare('SELECT * from setev where houseID="1"');
				// SQL문을 실행하여 데이터를 MySQL 서버의 user 테이블에 저장
                if($st->execute()) {
                    if(!$android){
                        try {
                            while($record = $st->fetch(PDO::FETCH_ASSOC)){ 
                                //$result .= "<table border = '1'><tr>";
                                foreach($record as $column){ 
                                    //$result .= "<td>" . $column . "</td>";
                                    echo $column;
                                    echo ',';
                                } 
                                //$result .= "</tr></table>"; 
                            }
                        } catch(PDOException $e){ 
                            $result = "#ERR:" . $e->getMessage(); 
                        }
                        $successMSG = "설정값을 성공적으로 불러왔습니다.";
                        //echo $result;
                    } else {
                        $data=array();
                        try {
                            while($record = $st->fetch(PDO::FETCH_ASSOC)){ 
                                extract($record);
                        
                                array_push($data, 
                                    array('setTemp'=>$setTemp,
                                    'setMoisture'=>$setMoisture,
                                    'setLux'=>$setLux
                                ));
                            }
                        } catch(PDOException $e){ 
                            $result = "#ERR:" . $e->getMessage(); 
                        }
                        header('Content-Type: allication/json; charset=utf8');
                        $json = json_encode(array("ajmset"=>$data),JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
                        echo $json;
                        $successMSG = "설정값을 성공적으로 불러왔습니다.";
                        //echo $result;
                    }
                }
				else {
					$errMSG = "설정값 호출에 실패했습니다.";
				}
			} catch(PDOException $e) {
				die("Database error : ". $e->getMessage());
			}
		}
	}

	//if(isset($errMSG)) echo $errMSG;
	//if(isset($successMSG)) echo $successMSG;

?>
