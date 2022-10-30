<?php

$xml = simplexml_load_file("https://www.news-medical.net/tag/feed/Parkinsons-Disease.aspx");

require_once('header.php');

?>
<div class="col-md-9 main_div">
    <div class="sub_div">
        <div class="panel panel-default plr10 ptb10">
            <?php
                echo "<ul><h4>Latest news about Parkinsons Disease</h4>";
                foreach($xml->channel->item as $itm) {
                  $title = $itm->title;
                  $link = $itm->link; 
                  $descript = $itm->description;
                  $date = $itm->pubDate;
                  echo '<hr><li><a href='.$link.'">' .$title. '</a>';
                  echo "<br>";
                  echo $descript. '</li>';
                  echo "<br>";
                  echo $date; 
                }
                echo "</ul>";
            ?>
        </div>
    </div>
</div>
</php
require_once('footer.php');
?>
