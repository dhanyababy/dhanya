<?php

function goToAuthUrl()
{
    $client_id = "89268328b0acc55062fe";
    $redirect_url = "http://localhost/dhanya/web/github/login.php";
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $url = 'https://github.com/login/oauth/authorize?client_id='. $client_id. "&redirect_url=".$redirect_url."&scope=user";
        header("location: $url");
    }
}

function fetchData()
{
    if(empty($_SESSION['user'])){
        $client_id = "89268328b0acc55062fe";
        $redirect_url = "http://localhost/dhanya/web/github/login.php";
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET['code'])) {
                $code = $_GET['code'];
                $post = http_build_query(array(
                        'client_id' => $client_id,
                        'redirect_url' => $redirect_url,
                        'client_secret' => '287b4fc3f4c6ddf8c0758bd4759a159f7e4c19d6',
                        'code' => $code,

                ));
                $access_data = file_get_contents("https://github.com/login/oauth/access_token?". $post);
            
                $exploded1 = explode('access_token=', $access_data);
                $exploded2 = explode("&", $exploded1[1], 2)[0];

                $access_token = $exploded2;
                

                $opts = [ 'http' => [
                                'method' => 'GET',
                                'header' => [ 'User-Agent: PHP']
                            ]
                ];
                $ch = curl_init('https://api.github.com/user');
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization: Bearer '.$access_token,
                    'user-agent: PHP'
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $data = curl_exec($ch);
                
                curl_close($ch);

            
                $user_data = json_decode($data, true);
                $username = $user_data['login'];


                //fetching email data
                $ch = curl_init('https://api.github.com/user/emails');
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization: Bearer '.$access_token,
                    'user-agent: PHP'
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $emails = curl_exec($ch);
                
                curl_close($ch);
                $emails = json_decode($emails, true);

                $email = $emails[0]['email'];
                if(!empty($username)){
                    session_start();
                    $_SESSION['user_name'] = $username;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user'] = $username;
                }
            }

        }
        else {
            die('error');
        }
    }
    
}