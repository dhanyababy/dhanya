<?php require('../database.php'); ?>
<?php
       $action = $_POST['action'];
       session_start();
       $researcher_email = $_SESSION['user_email'];
       $sql = "SELECT * FROM user  where email='".$researcher_email."' limit 1";
        // print_r($sql);die;
       $result = $conn->query($sql);

       if ($result->num_rows > 0) {
              $user_id = $result->fetch_assoc()['userID'];
       }
       switch($action){
              case 'get_data':
                     if(isset($_POST['file']) && !empty($_POST['file']) && !empty($user_id)){
                            $test_id = '';
                            $sql = "SELECT * FROM test_session where DataURL='".$_POST['file']."' limit 1";
                            // print_r($sql);die;
                            $result = $conn->query($sql);
                    
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                if(!empty($row)){
                                   $test_id = $row['test_SessionID'];
                                   if(!empty($test_id)){
                                          $sql1 = "SELECT * FROM annotations where test_session_id='".$test_id."' ORDER BY id desc";
                                          $result1 = $conn->query($sql1);
                                          $comments = [];
                                          while($row = $result1->fetch_assoc()) {
                                                 $comments[] = $row;
                                          }
                                          // $comments = $result1->fetch_assoc();
                                          if(!empty($comments)){
                                                 $res['status']    = true;
                                                 $res['message']    = 'Result found!';
                                                 $res['annotations'] = $comments;
                                          }
                                          else{
                                                 $res['status']    = false;
                                                 $res['message']    = 'No Result!';
                                                 $res['annotations'] = [];   
                                          }
                                          
                                   }
                                }
                                
                            }
                     }
                     else{
                            $res['status']    = false;
                            $res['message']    = 'Invalid Input';
                            $res['annotations'] = [];
                     }
              break;
              case 'add_data':
                     if(!empty($_POST['file']) && !empty($_POST['comment']) && !empty($user_id)){
                            $test_id = '';
                            $sql = "SELECT * FROM test_session where DataURL='".$_POST['file']."' limit 1";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                   $row = $result->fetch_assoc();
                                   if(!empty($row)){
                                      $test_id = $row['test_SessionID'];
                                   }
                            }
                            // $user_id = $_POST['user_id'];
                            $annotation = $_POST['comment'];
                            $created_at = date('Y-m-d H:i:s');
                            $sql1 = "INSERT INTO annotations (test_session_id,user_id,annotation,created_at) VALUES ('".$test_id."', '".$user_id."','".$annotation."','".$created_at."')";
                            if ($conn->query($sql1) === TRUE) {
                                   $res['status']    = true;
                                   $res['message']    = 'Comment added';
                                   $res['annotations'] = [];
                            } else {
                                   $res['status']    = false;
                                   $res['message']    = 'Failed to add comment';
                                   $res['annotations'] = [];
                            }
                     }
                     else{
                            $res['status']    = false;
                            $res['message']    = 'Invalid Input';
                            $res['annotations'] = [];
                     }
              break;
              default:
                     $res['status']    = false;
                     $res['message']    = 'Failed';
                     $res['annotations'] = [];
                     
       }
       echo json_encode($res);    
?>