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
		 empty($data->EnrollNO) ||
		 empty($data->Type) || 
		 empty($data->RequestNo) || 
		 empty($data->INDateTime) || 
		 empty($data->OUTDateTime))
		{
			var_dump($data->EnrollNO);
			echo json_encode(array("IsSuccess" => "false" ,"Message" => "Please send all mandatory feilds."));
			return;
		}
		
				// get database connection
				$database = new Database();
				$Conn = $database->getConnection();
				
				
			 
				// prepare the query
				
				$stmt = $Conn->prepare("CALL EventProcessedDataInsert( :ParaRequestNO , :ParaDataFromDate, :ParaDataFromTime, :ParaEnrollNO, :ParaType , :ParaInDate , :ParaInTime , :ParaOutDate , :ParaOutTime)");
				
				// sanitize
				$data->RequestNo = htmlspecialchars(strip_tags($data->RequestNo));
				$data->EnrollNO = htmlspecialchars(strip_tags($data->EnrollNO));
				$data->Type = htmlspecialchars(strip_tags($data->Type));
				$data->INDateTime = htmlspecialchars(strip_tags($data->INDateTime));
				$data->OUTDateTime = htmlspecialchars(strip_tags($data->OUTDateTime));
				
				$ParaInDate = date("Y-m-d",strtotime($data->INDateTime));
				$ParaInTime = date("H:i:s",strtotime($data->INDateTime));
				$ParaOutDate = date("Y-m-d",strtotime($data->OUTDateTime));
				$ParaOutTime = date("H:i:s",strtotime($data->OUTDateTime));
				
				$DataFromDate = date("Y-m-d",strtotime($data->DataFromDateTime));
				$DataFromTime = date("H:i:s",strtotime($data->DataFromDateTime));
				
				// bind the values
				
				$stmt->bindParam(':ParaRequestNO', $data->RequestNo);
				$stmt->bindParam(':ParaDataFromDate', $DataFromDate);
				$stmt->bindParam(':ParaDataFromTime', $DataFromTime);
				$stmt->bindParam(':ParaEnrollNO', $data->EnrollNO);
				$stmt->bindParam(':ParaType', $data->Type);
				$stmt->bindParam(':ParaInDate', $ParaInDate);
				$stmt->bindParam(':ParaInTime', $ParaInTime);
				$stmt->bindParam(':ParaOutDate', $ParaOutDate);
				$stmt->bindParam(':ParaOutTime', $ParaOutTime);
				
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