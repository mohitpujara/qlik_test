<?php 
class messages
{
	private $con;
	
	function __construct()
	{
		$this->con = mysql_connect("localhost","root","") or die();
		mysql_select_db("app_db",$this->con) or die();
	}
	
	public function index($id="")
	{
		if(!empty($id))
		{
			$output = array();
			$Q = "SELECT * FROM messages WHERE is_deleted=0 AND id='".$id."'";
			$res = mysql_query($Q,$this->con) or die();
			if(mysql_num_rows($res) > 0)
			{
				$row = mysql_fetch_object($res);
				$output['message']['id'] = $id;
				$output['message']['message'] = $row->message;
				$output['message']['is_palindrome'] = ($row->message == strrev( $row->message ))?"Yes":"No";
				http_response_code(200);
				echo json_encode($output);
			}
			else
			{
				$output['errors']['description'] = "Invalid Messsage Id";
				$output['errors']['code'] = "404";
				echo json_encode($output);
				http_response_code(404);
				exit;
			}
			
		}
		else
		{
			$output = array();
			$Q = "SELECT * FROM messages WHERE is_deleted=0";
			$res = mysql_query($Q,$this->con) or die();
			
			while($row = mysql_fetch_object($res))
			{
				$temp = array(
					"id"=>$row->id,
					"message"=>$row->message
				);
				$output['messages'][] = $temp;
			}
			echo json_encode($output);
			http_response_code(200);
		}
	}
	
	public function post()
	{
		$output = array();
		$_POST = filter_var_array($_POST,FILTER_SANITIZE_STRING);
		if(empty($_POST['message'])) 
		{
			$output['errors']['description'] = "Message required.";
			$output['errors']['code'] = "422";
			echo json_encode($output);
			http_response_code(422);
			exit;
		}
		
		$Q = "INSERT INTO messages (message,created_time) VALUES ('".$_POST['message']."','".time()."')";
		mysql_query($Q,$this->con) or die();
		$id = mysql_insert_id();
		$output['success']['description'] = "Message added successfully.";
		$output['success']['code'] = "201";
		$output['success']['message_id'] = $id;
		echo json_encode($output);
		http_response_code(201);
		exit;
	}
	
	public function delete($id)
	{
		$output = array();
		if(!ctype_digit($id))
		{
			$output['errors']['description'] = "Invalid Messsage Id";
			$output['errors']['code'] = "404";
			echo json_encode($output);
			http_response_code(404);
			exit;
		}
		
		$Q = "UPDATE messages SET is_deleted='1',delete_time='".time()."' WHERE id='".$id."'";
		mysql_query($Q,$this->con) or die();
		
		$rows = mysql_affected_rows();
		if($rows > 0) 
		{
			http_response_code(200);
			exit;
		}
		else
		{
			$output['errors']['description'] = "Message Not Found";
			$output['errors']['code'] = "404";
			echo json_encode($output);
			http_response_code(404);
			exit;
		}
	}
}