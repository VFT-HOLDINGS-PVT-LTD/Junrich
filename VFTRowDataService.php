<?PHP
//error_reporting(E_ERROR | E_PARSE);
header("Access-Control-Allow-Origin: http://localhost/VFTServices/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'dbconfiguration.php';


$JSONArrayObject = json_decode(file_get_contents("php://input"));

 if($JSONArrayObject == null)
 {
 	 // set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("IsSuccess" => "false" ,"Message" => "Input Data is empty."));
	return;
 }
 
 try
 {
	 foreach($JSONArrayObject as $data)
	 {
	 if(
		 empty($data->DeviceID) ||
		 empty($data->EnrollNO) ||
		 empty($data->EventId) || 
		 empty($data->EventDateTime) )
		{
			echo json_encode(array("IsSuccess" => "false" ,"Message" => "Please send all mandatory feilds."));
			return;
		}
		
				// get database connection
				$database = new Database();
				$Conn = $database->getConnection();
				
				
			 
				// prepare the query
				$stmt = $Conn->prepare("CALL EventRowDataUpsert(:DeviceID,:EnrollNO,:EventId,:EventDateTime,:EventMode,:EventOrigin,:ParaEventStatus)");
				
				// sanitize
				$data->DeviceID = htmlspecialchars(strip_tags($data->DeviceID));
				$data->EnrollNO = htmlspecialchars(strip_tags($data->EnrollNO));
				$data->EventId = htmlspecialchars(strip_tags($data->EventId));
				$data->EventDateTime = htmlspecialchars(strip_tags($data->EventDateTime));
				$data->EventMode = htmlspecialchars(strip_tags($data->EventMode));
				$data->EventOrigin = htmlspecialchars(strip_tags($data->EventOrigin));
				
				$EventStatus = $data->EventStatus == "true" ? (int)1 : (int)0;
				// bind the values
				$stmt->bindParam(':DeviceID', $data->DeviceID);
				$stmt->bindParam(':EnrollNO', $data->EnrollNO);
				$stmt->bindParam(':EventId', $data->EventId);
				$stmt->bindParam(':EventDateTime', $data->EventDateTime);
				$stmt->bindParam(':EventMode', $data->EventMode);
				$stmt->bindParam(':EventOrigin', $data->EventOrigin);
				$stmt->bindParam(':ParaEventStatus', $EventStatus,PDO::PARAM_INT);
				
				if($stmt->execute()){
					
				}
				else
				{
					echo json_encode(array("IsSuccess" => "false" ,"Message" => $stmt->errorInfo()));
					return;
				}
	}
	echo json_encode(array("IsSuccess" => "true" ,"Message" => "Success"));
	return;
}
catch(Exception  $e)
{
	var_dump("q");
	echo json_encode(array("IsSuccess" => "false" ,"Message" => $e->getMessage()));
	return;
}
?>