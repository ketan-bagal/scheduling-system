<?php
echo "<label>Time:</label>";
echo "<input type='radio' name='starttime' onclick='choiceroom(9)' value='9' checked> 9";
for ($i=0; $i <= 5 ; $i++) {
  $time=$i+10;
  echo "<input type='radio' name='starttime' onclick='choiceroom(".$time.")' value='".$time."'>".$time;
}
 ?>
