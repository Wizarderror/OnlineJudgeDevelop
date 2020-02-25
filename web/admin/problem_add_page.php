<html>
<head>
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Cache-Control" content="no-cache">
  <meta http-equiv="Content-Language" content="zh-cn">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Problem Add</title>
</head>
<hr>

<?php 
$cas_num = 1;
  require_once("../include/db_info.inc.php");
  require_once("admin-header.php");
  if (!(isset($_SESSION[$OJ_NAME.'_'.'administrator']) || isset($_SESSION[$OJ_NAME.'_'.'contest_creator']) || isset($_SESSION[$OJ_NAME.'_'.'problem_editor']))) {
    echo "<a href='../loginpage.php'>Please Login First!</a>";
    exit(1);
  }
  echo "<center><h3>".$MSG_PROBLEM."-".$MSG_ADD."</h3></center>";
  include_once("kindeditor.php") ;
?>

<body leftmargin="30" >
  <div class="container">
    <form method=POST action=problem_add.php>
      <input type=hidden name=problem_id value="New Problem">
        <p align=left>
          <?php echo "<h3>".$MSG_TITLE."</h3>"?>
          <input class="input input-xxlarge" style="width:100%;" type=text name=title><br><br>
        </p>
        <p align=left>
          <?php echo $MSG_Time_Limit?><br>
          <input class="input input-mini" type=text name=time_limit size=20 value=1> sec<br><br>
          <?php echo $MSG_Memory_Limit?><br>
          <input class="input input-mini" type=text name=memory_limit size=20 value=128> MB<br><br>
        </p>
        <p align=left>
          <?php echo "<h4>".$MSG_Description."</h4>"?>
          <textarea class="kindeditor" rows=13 name=description cols=80></textarea><br>
        </p>
        <p align=left>
          <?php echo "<h4>".$MSG_Input."</h4>"?>
          <textarea class="kindeditor" rows=13 name=input cols=80></textarea><br>
        </p>
        <p align=left>
          <?php echo "<h4>".$MSG_Output."</h4>"?>
          <textarea  class="kindeditor" rows=13 name=output cols=80></textarea><br>
        </p>

        <div class='sample-case'>
        <!-- <button type="button" class="btn delcase-btn" style="left: 1285px;position: absolute;padding: 2px 10px 1px 10px;font-size: 25px;margin-top: -5px;">×</button> -->
        <div style='float: left; margin-right: 52.514px;'>
          <p align=left>
            <h4><?php echo $MSG_Sample_Input . "1"; ?></h4>
            <textarea class='input input-large' style='width:543px;font-size:20px' rows=8 name='sample_input[]' required></textarea><br><br>
          </p>
        </div>
        <div style='float: left'>
          <p align=left>
            <h4><?php echo $MSG_Sample_Output . "1"; ?></h4>
            <textarea class='input input-large' style='width:543px;font-size:20px' rows=8 name='sample_output[]' required></textarea><br><br>
          </p>
        </div>
        <div style='clear: both'></div>
      </div>


      <button class="btn" onclick="add_sample_case()" type="button"><?php echo $OJ_ADD_MORE_SAMPLE ?></button>
      <br><br>


        <p align=left>
          <?php echo "<h4>".$MSG_Test_Input."</h4>"?>
          <?php echo "(".$MSG_HELP_MORE_TESTDATA_LATER.")"?><br>
          <textarea class="input input-large" style="width:100%;" rows=13 name=test_input></textarea><br><br>
        </p>
        <p align=left>
          <?php echo "<h4>".$MSG_Test_Output."</h4>"?>
          <?php echo "(".$MSG_HELP_MORE_TESTDATA_LATER.")"?><br>
          <textarea class="input input-large" style="width:100%;" rows=13 name=test_output></textarea><br><br>
        </p>
        <p align=left>
          <?php echo "<h4>".$MSG_HINT."</h4>"?>
          <textarea class="kindeditor" rows=13 name=hint cols=80></textarea><br>
        </p>
        <p>
          <?php echo "<h4>".$MSG_SPJ."</h4>"?>
          <?php echo "(".$MSG_HELP_SPJ.")"?><br>
          <?php echo "No "?><input type=radio name=spj value='0' checked><?php echo "/ Yes "?><input type=radio name=spj value='1'><br><br>
        </p>
        <p align=left>
          <?php echo "<h4>".$MSG_SOURCE."</h4>"?>
          <textarea name=source style="width:100%;" rows=1></textarea><br><br>
        </p>
        <p align=left><?php echo "<h4>".$MSG_CONTEST."</h4>"?>
          <select name=contest_id>
            <?php
            $sql="SELECT `contest_id`,`title` FROM `contest` WHERE `start_time`>NOW() order by `contest_id`";
            $result=pdo_query($sql);
            echo "<option value=''>none</option>";
            if (count($result)==0){
            }else{
              foreach($result as $row){
                echo "<option value='{$row['contest_id']}'>{$row['contest_id']} {$row['title']}</option>";
              }
            }?>
          </select>
        </p>

        <div align=center>
          <?php require_once("../include/set_post_key.php");?>
          <input type=submit value='<?php echo $MSG_SAVE?>' name=submit>
        </div>
      </input>
    </form>
  </div>
  <script>
   var cas_num = 2;
  var MSG_Sample_Input = "<?php echo $MSG_Sample_Input ?>";
  var MSG_Sample_Output = "<?php echo $MSG_Sample_Output ?>";

  function add_sample_case() {
    $(".sample-case:last").after("<div class='sample-case'><button type='button' class='btn delcase-btn' style='left: 1135px;position: absolute;padding: 2px 10px 1px 10px;font-size: 25px;margin-top: -5px;outline: none;'>×</button><div style='float: left; margin-right: 52.514px;'><p align=left><h4>" + MSG_Sample_Input + cas_num + "</h4><textarea class='input input-large' style='width:543px;font-size:20px' rows=8 name='sample_input[]'></textarea><br><br></p></div><div style='float: left'><p align=left><h4>" + MSG_Sample_Output + cas_num + "</h4><textarea class='input input-large' style='width:543px;font-size:20px' rows=8 name='sample_output[]'></textarea><br><br></p></div><div style='clear: both'></div></div>");
    cas_num++;
  }

  $(document).ready(function() {
    $("form").on("click", ".sample-case .delcase-btn", function() {
      var index = $(this).parent().parent().children(".sample-case").index($(this).parent());
      $("form").children(".sample-case").eq(index).remove();
      cas_num--;
      $(".sample-case").each(function(){
          var index = $(this).parent().children(".sample-case").index($(this));
          $(this).children("div").eq(0).children("h4").html(MSG_Sample_Input + (index+1));
          $(this).children("div").eq(1).children("h4").html(MSG_Sample_Output + (index+1));
      });
    });
  });
  </script>
</body>
</html>
