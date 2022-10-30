<?php require('../database.php'); ?>
<?php
    $user_id = '';
    $patient_details = [];
    $patient_activities = [];
    if(!empty($_POST['id'])){
        $user_id = $_POST['id'];
        $sql = "SELECT * FROM User left join organization on Organization=organizationID where userID = ".$user_id." limit 1";
        // print_r($sql);die;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $patient_details = $result->fetch_assoc();
        }
        // $conn->close();

        $sql1 = "SELECT * FROM test_session left join test on Test_IDtest=testID left join therapy on Therapy_IDtherapy=therapyID left join user on User_IDpatient=userID where userID = ".$user_id;
        // print_r($sql1);die;
        $result1 = $conn->query($sql1);

        if ($result1->num_rows > 0) {
            while($row1 = $result1->fetch_assoc()) {
                $patient_activities[] = $row1;
            }
            // $patient_activities = $result1->fetch_assoc();
        }
        $conn->close();
    }
?>
<?php
session_start();
 require_once('header.php'); 
?>
<div class="col-md-9 main_div">
    <div class="sub_div">
        <?php
            if(!empty($patient_details)){
        ?>
        <div class="panel panel-default plr10 ptb10">
            <h4>Patient Info:</h4>
            <p>User ID: <?= $patient_details['userID'] ?></p>
            <p>Organization: <?= $patient_details['name'] ?></p>
            <p>Username: <?= $patient_details['username'] ?></p>
            <p>Email: <?= $patient_details['email'] ?></p>
            <br>
            <h4>Patient Activity Info:</h4>
            <form id="form" method="post" action="patient_activity.php" target="iframe" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <select class="form-control" name="file" id="file">
                                <option value="" selected> - Choose data file name-
                            <?php
                            if(!empty($patient_activities)){
                                foreach($patient_activities as $key=>$value){
                            ?>
                            <option value="<?= $value['DataURL']?>"><?= $value['DataURL']?></option>
                                    
                            <?php
                                    }
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                    <input class="btn btn-success" type="submit" name="submit" value="View">
                    </div>
                </div>
                <div id="graph_div" class="graph" style="display:none">
                    <iframe name="iframe" frameborder="0" width="320" height="220" allowfullscreen>
                    <img src="patient_activity.php"/>
                    </iframe>
                </div>
            </form>
        </div>
        
        <div class="panel panel-default plr10 ptb10 comment_section">
            <h4>Annotations</h4>
            <div class="row">
                <div class="col-md-12">
                <div id="success_div" class="alert alert-success" style="display: none;">
                    
                </div>
                <div id="error_div" class="alert alert-danger" style="display: none;">
                    
                </div>
                </div>
                <div class="col-md-10">
                    <!-- <div class="form-control"> -->
                        <textarea id="comment" name="" class="form-control" id="" cols="6" rows="2"></textarea>
                    <!-- </div> -->
                </div>
                <div class="col-md-2">
                        <button class="btn btn-success" id="add">Add</button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12" id="comment_div">

                </div>
            </div>
        </div>
        <div class="panel panel-default plr10 ptb10 comment_section">
            <h4>Patient Location:</h4>
            <iframe 
            width="100%" 
            height="170" 
            frameborder="0" 
            scrolling="no" 
            marginheight="0" 
            marginwidth="0" 
            src="https://maps.google.com/maps?q=<?= $patient_details['Lat'] ?>,<?= $patient_details['Long'] ?>&hl=es&z=14&amp;output=embed"
            >
            </iframe>
            </small>
        </div>
        <?php
            }
            else{
        ?>
        <div class="panel panel-default plr10 ptb10">
            <p>Failed to get patient details</p>
        </div>
        <?php
            }
        ?>
    </div>
</div>
<?php require_once('footer.php'); ?>
<script>
    $("#form").submit(function(){
        $('#graph_div').css({display: 'block'})
    });
    function get_comments(){
        $('#comment_div').html('');
        var file = $('#file').val();
        var form_data = {
            'file'     : file,
            'action'   : 'get_data'
        };
        if(file){
            $.ajax({
                url: "annotations.php",
                type: "post",
                data: form_data ,
                success: function (response) {
                    let response_obj = jQuery.parseJSON(response);
                    let html='';
                    if(response_obj.status){                        
                        if(response_obj.annotations.length){
                            let res = response_obj.annotations;
                            html += `<h4>Previous Comments</h4>`;
                            for(let key in res){
                                html += `<p>*<b>${res[key].created_at} : </b>${res[key].annotation}</p>`;
                            }
                             
                        }
                    }
                    else{
                        html+='';
                    }
                    $('#comment_div').html(html);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
                }
            });
        }
    }
    $('#file').on('change',function(e){
        e.preventDefault();
        get_comments()
    });
    $('#add').on('click',function(e){
        e.preventDefault();
        let file = $('#file').val();
        let comment = $('#comment').val();
        if(file && comment){
            var form_data = {
                'file'     : file,
                'action'     : 'add_data',
                'comment'   : comment
            };
            $.ajax({
                url: "annotations.php",
                type: "post",
                data: form_data ,
                success: function (response) {
                    let response_obj = jQuery.parseJSON(response);
                    if(response_obj.status){
                        $('#comment').val('');
                        $('#success_div').append(`<p>${response_obj.message}</p>`);
                        $('#success_div').css({display:'block'});
                        get_comments();                        
                        setTimeout(function(){
                            $('#success_div').html('').css({display:'none'});
                        }, 3000);
                    }
                    else{
                        $('#error_div').append(`<p>${response_obj.message}</p>`);
                        $('#error_div').css({display:'block'});                     
                        setTimeout(function(){
                            $('#error_div').html('').css({display:'none'});
                        }, 3000);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
                }
            });

        }
        else{
            alert('Pleae choose data file and add an annotation');
        }
        
    });
</script>