<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Playlist generator</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
    <script>
      $(document).ready(function(){
        $("#btnSearch").click(function(){
        if ($('#sort').is(":checked")){
          var sort = $("#sort").val();
        }
        else {
          var sort = ""
        }
      
        var output = $('#output').val();
        var output = $("input[name='output']:checked").val();
        var login = $('#login').val();
        var password = $('#password').val();
        var url= location.href.substring(0, location.href.lastIndexOf("/")) + sort +"/lista.php?login=" + login +"&password=" + password +"&groups[]=";
        var flag=false;
        $("input:checkbox[name=groups]:checked").each(function(){
          if(!flag){
            url=url+$(this).val();
            flag=true;
          }
          else{
            url=url+"&groups[]="+$(this).val();
          }         
        });
        $('#url').val(url)
      });
    });

    </script>
    <script language="JavaScript">
      function toggle(source) {
        checkboxes = document.getElementsByName('groups');
        for(var i=0, n=checkboxes.length;i<n;i++) {
          checkboxes[i].checked = source.checked;
        }
      }
    </script>
  </head>
  <body>
    <?php 
      $myUsername = $_POST['user'];
      $myPassword = $_POST['pass'];
      $myData = json_decode(file_get_contents("http://cdn.megaplay.xyz/panel_api.php?username=$myUsername&password=$myPassword"), true);
    ?>

    <form action="" method="post" class="form-horizontal">
      <div class="col-sm-10">
        <label class="col-sm-2 control-label">Login</label>
        <input class="form-control" id="login" value="<?php echo $_POST['user']; ?>" name="user" >
      </div>
      <div class="col-sm-10">
        <label class="col-sm-2 control-label">Password</label>
        <input class="form-control" id="password" value="<?php echo $_POST['pass']; ?>" name="pass">
      </div>
      <div class="col-sm-10">
        <input type="submit" value="get list">
      </div>
      <div class="form-group">    
        <div class="col-sm-offset-2 col-sm-10">      
          <div class="checkbox">
            <label><input type="checkbox" id="sort" value="sort&" name="sort" ><b>Sort playlist alphabetically</b></label>
            <div>
              <label><input type="checkbox" onClick="toggle(this)"  ><b>Select All</b></label>
            </div>
          </div>
        </div>
      </div>

      <?php
        foreach($myData['categories']['live'] as $key=>$val){
          $cat_name2 = $val['category_name'];
          echo '<div class="form-group">    <div class="col-sm-offset-2 col-sm-10">      <div class="checkbox"><label><input type="checkbox" value="'.$cat_name2.'" name="groups">'.$cat_name2.'</label></div></div></div>';
			
        }
      ?>

      <div class="form-group">    
        <div class="col-sm-offset-2 col-sm-10">      
          <div class="checkbox">
            <input type="button" id="btnSearch" value="Get Url" >
          </div>
        </div>
      </div>
    </form>
  
    <div class="form-group">    
      <div class="col-sm-offset-2 col-sm-10">      
        <div class="checkbox">
          <textarea id="url" rows="2" cols="100"></textarea>
        </div>
      </div>
    </div>

  </body>
</html>