<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

$db_conn= mysqli_connect("localhost","root","","reactphp");
if($db_conn===false)
{
    die("ERROR:could not connect".mysqli_connect_error());
}
 $method = $_SERVER['REQUEST_METHOD'];
 //echo "test..".$method; die;
 switch($method)
 {
    case "GET":
        $alluser= mysqli_query($db_conn, "SELECT * FROM tlb_user");
        if(mysqli_num_rows($alluser) > 0)
        {
            $json_array["userdata"] = array();
            
            while($row = mysqli_fetch_array($alluser))
            {
                $json_array["userdata"][]= array("id"=>$row["userid"],"username"=>$row["username"],"useremail"=>$row["useremail"],"status"=>$row["status"]);

            }
            echo json_encode($json_array["userdata"]);
            return;

        }else{
            echo json_encode(["result"=>"Please check the Data"]);
            return;

        }
        break;
        case "POST":
            $userpostdata=json_decode(file_get_contents("php://input"));
            //echo "sucess data";
            //print_r($userpostdata);die;
            $uesrname=$userpostdata ->username;
            $useremail=$userpostdata ->email;
            $status=$userpostdata ->status;
            $result =mysqli_query($db_conn, "INSERT INTO tlb_user (username, useremail, status) VALUES ('$username','$useremail','$status')");
            if($result)
            {
                echo json_encode(["success"=>"User added successfully"]);
                return;

            } else{
                echo json_encode(["success"=>"Check user data"]);
                return;
            }
            break;
            
            case "PUT":
                $userupdate=json_decode(file_get_contents("php://input"));
            //echo "sucess data";
            //print_r($userpostdata);die;
            $uesrid=$userupdate ->userid;
            $uesrname=$userupdate ->username;
            $useremail=$userupdate ->email;
            $status=$userupdate ->status;
            $updateresult =mysqli_query($db_conn, "UPDATE tlb_user SET username='$username',useremail='$useremail', status='$status'WHERE userid='$userid'");
            if($updateresult)
            {
                echo json_encode(["success"=>"User updated successfully"]);
                return;

            } else{
                echo json_encode(["success"=>"Check user data"]);
                return;
            }
            print_r($updateresult);die;
            break;


 }
?>