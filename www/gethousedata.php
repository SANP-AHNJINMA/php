<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');
        

    $stmt = $con->prepare('SELECT * from house where houseID="1"');
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
        $data = array(); 

        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
    
            array_push($data, 
                array('temp'=>$temp,
                'moisture'=>$moisture,
                'lux'=>$lux,
                'soil_moist'=>$soil_moist
            ));
        }

        header('Content-Type: application/json; charset=utf8');
        $json = json_encode(array("ajm"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        echo $json;
    }

?>