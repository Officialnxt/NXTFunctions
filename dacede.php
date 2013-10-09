<!DOCTYPE HTML>
<html>
<head>
	<title>Wave</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=2.0">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<script type="text/javascript" src="../js/bootstrap.js"></script>
	<script>
	$(document).ready(function() {

		$("#login").on("click", function() {
			$(this).modal('show');
		});

		$("#register").on("click", function() {
			$(this).modal('show');
		});

		$('.close').click(function(e){
			e.preventDefault();
		    	$('.modal').modal('hide');
		    	return false;
		});

});

	});
</script>
<?php
session_start();
session_regenerate_id(true); 
$user = $_SESSION['user'];
$id = $_SESSION['id'];
?>
</head>
<style>
body {
padding-top: 70px; 
padding-bottom: 70px;
}
.navbar{
background-color: #FFFFFF;
border-bottom: solid 1px #E0E0E0;
border-top: solid 1px #E0E0E0;
}
.btn{
padding-top: 5px;
padding-bottom: 5px;
}

@media screen and (max-width: 600px) {
.desktop{
	visibility: hidden;
    	height: 0px;
	display: none;
}
.sidebar{
	visibility: hidden;
	width: 0px;
	display: none;
}
}
</style>
<body>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#">Wave</a>
    <ul class="nav navbar-nav">
      <?php
	if(!$user){
      ?>
      <li class='desktop'><a data-toggle="modal" data-target="#login" href="#">Sign In</a></li>
      <li class='desktop'><a data-toggle="modal" data-target="#register" href="#">Sign Up</a></li>
      <?php
	}else{
      ?>
	<li class='desktop'><a data-toggle="modal" data-target="#user" href="#"><?php echo $user; ?></a></li>
	<li class='desktop'><a data-toggle="modal" data-target="#submit" href="#">Submit</a></li>
      <li class='desktop'><a data-toggle="modal" data-target="#logout" href="#">Logout</a></li>
      <?php
	}
      ?>
    </div>

<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav">
      <?php
	if(!$user){
      ?>
      <li><a href="#" data-toggle="modal" data-target="#login">Sign In</a></li>
      <li><a href="#" data-toggle="modal" data-target="#register">Sign Up</a></li>
      <?php
	}else{
      ?>
      <li><a href="#" data-toggle="modal" data-target="#user"><?php echo $user; ?></a></li>
      <li><a href="#" data-toggle="modal" data-target="#submit">Submit</a></li>
      <li><a href="#" data-toggle="modal" data-target="#logout">Logout</a></li>
      <?php
	}
      ?>
  </div>
</ul>
</div>
</nav>
<div class="table-responsive">
<table class='table'>
<tr>
	<?php
	if(!$user){
	?>
	<td class="sidebar"><b>Sign Up | Sign In</b></td>
	<?php
	}else{
	?>
	<td class="sidebar"><b>Genres</b></td>
	<?php
	}
	?>
	<td width='75%'><b>Hot</b></td>
</tr>
<tr>
	<td class="sidebar">
	<?php
	if(!$user){
	?>
	<button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#login">Sign In</button>
	<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#register">Sign Up</button>
	<?php 
	}
	?>
	<span class="label label-default">Pop</span>
	<span class="label label-success">Electronic</span>
	<span class="label label-info">Hip-Hop</span><br />
	<span class="label label-warning">Rock</span>
	<span class="label label-danger">Metal</span>
	<span class="label label-default">All</span>
	<span class="label label-success">New</span>
	</td>
	<td>
	<table>
	<tr>
	<?php
	require("connect.php");
	require("PasswordHash.php");
	$date = date("M d, Y");
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	$signup = array_key_exists('signup', $_POST) ? $_POST['signup'] : null;
	if($signup){
		$username = strip_tags($_POST['username']);
		$email = strip_tags($_POST['email']);
		$password = strip_tags($_POST['password']);
			
		$passHasher = new PasswordHash(8, FALSE);
		$hash = $passHasher->HashPassword($password);
		
			
		$sql = "SELECT * FROM Users WHERE username='$username'";			
		$rs=$mysqli->query($sql);
 
		if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
		} else {
		$rows_returned = $rs->num_rows;
		if($rows_returned == 0){
				
		$sql2 = "SELECT * FROM Users WHERE email='$email'";			
			$rs=$mysqli->query($sql2);
	 
			if($rs === false) {
			trigger_error('Wrong SQL: ' . $sql2 . ' Error: ' . $mysqli->error, E_USER_ERROR);
			} else {
			$rows_returned = $rs->num_rows;
			if($rows_returned == 0){
						
				$sql3 = "INSERT INTO Users (id, username, email, password, date) VALUES ('', '$username', '$email', '$hash', '$date')";
	
				if($mysqli->query($sql3) === false) {
				trigger_error('Wrong SQL: ' . $sql3 . ' Error: ' . $conn->error, E_USER_ERROR);
				} else {
				$last_inserted_id = $mysqli->insert_id;
				$affected_rows = $mysqli->affected_rows;
				echo "Successfully Registered!";
				}	

				}
				else
					echo "This email is already being used!";
				}
				

			}
			else
				echo "Username taken!";
			}


		}
	$signin = array_key_exists('signin', $_POST) ? $_POST['signin'] : null;
	if($signin){
		$username = isset($_POST['username']) ? $_POST['username'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';
		$passHasher = new PasswordHash(8, FALSE);
		$hash = $passHasher->HashPassword($password);
		$sql= "SELECT * FROM Users WHERE username='$username'";
		$rs=$mysqli->query($sql);
		 
		if($rs === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
		} else {
		$rows_returned = $rs->num_rows;
		if($rows_returned == 1){
		$rs->data_seek(0);
		while($row = $rs->fetch_assoc()){
			$pass = $row['password'];
			$checked = $passHasher->CheckPassword($password, $pass);
			if ($checked) {
			    echo "You have been signed in!";
			    
			    $_SESSION['user'] = $row['username'];
			    $_SESSION['id'] = $row['id'];
				
			} else {
			    echo 'wrong credentials';
			}		
	
		}
		}
		else
			echo "Wrong Username!";
		}

		
	}

	$logout = array_key_exists('logout', $_POST) ? $_POST['logout'] : null;
	if($logout){
		echo "You have been logged out!";
		session_destroy();
	}

	$submit = array_key_exists('submit', $_POST) ? $_POST['submit'] : null;
	if($submit){
		$url = stripslashes(strip_tags($_POST['url']));
		$video = stripslashes(strip_tags($_POST['video']));
		$genre = stripslashes(strip_tags($_POST['genre']));

		if ( 'soundcloud.com' == parse_url($url, PHP_URL_HOST) ){
			$string = file_get_contents("http://soundcloud.com/oembed?format=json&url=$url&iframe=true");
			$json = json_decode($string,true);
			$title =  $json['title'];
			$desc = $json['description'];
			$thumb = $json['thumbnail_url'];
			$author = $json['author_name'];
			$aurl = $json['author_url'];
			$sql = "SELECT * FROM Content WHERE url='$url'";			
			
			$rs=$mysqli->query($sql);

			if($rs === false) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
			} else {
			$rows_returned = $rs->num_rows;
			if($rows_returned == 0){

				$sql2 = "INSERT INTO Content (id, userid, username, title, description, thumb, author, aurl, url, video, genre, score, date) VALUES ('', '$id', '$user', '$title', '$desc', '$thumb', '$author', '$aurl', '$url', '$video', '$genre', '0', '$date')";

				if($mysqli->query($sql2) === false) {
				trigger_error('Wrong SQL: ' . $sql2 . ' Error: ' . $conn->error, E_USER_ERROR);
				} else {
				$last_inserted_id = $mysqli->insert_id;
				$affected_rows = $mysqli->affected_rows;
				echo "Successfully submitted!";
				}

			}
			else
				echo "This url has already been submitted!";
			}

		}
		else
			echo "We currently only support soundcloud!";

		
	}
	$sql = "SELECT * FROM (SELECT * FROM Content WHERE date='$date') AS wave ORDER BY score DESC LIMIT 15";
	$rs=$mysqli->query($sql);
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
	} else {
		$rows_returned = $rs->num_rows;
		if($rows_returned >= 1){
			$rs->data_seek(0);
			while($row = $rs->fetch_assoc()){
			$userid = $row['userid'];
			$username = $row['username'];
			$title = $row['title'];
			$desc = $row['description'];
			$thumb = $row['thumb'];
			$author = $row['author'];
			$aurl = $row['aurl'];
			$genre = $row['genre'];
			$score = $row['score'];
			
				?>
				<table class='table'>
				<tr>
					<td>
					<img class='img-thumbnail' src="<?php echo $thumb; ?>" height="75" width="75">
					</td>
					<td width='100%'>
					<span class="label label-success"><?php echo $score; ?></span>					
					<?php echo $title; ?><br />
					Submitted By <?php echo $username; ?> | <?php echo $genre; ?><br />
					By <a target='_blank' href="<?php echo $aurl; ?>"><?php echo $author; ?></a>
					</td>
				</tr>
				</table>
			<?php
			}
		}
		else
			echo "No posts!";
	}
		//$string = file_get_contents("http://soundcloud.com/oembed?format=json&url=https://soundcloud.com/variouscruelties/neon-truth-2&iframe=true");
		?>
		</td>	
	</tr>
	</table>
	</td>
</tr>
</table>
  <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" onClick aria-hidden="true">&times;</button>
          <h4 class="modal-title">Sign In</h4>
        </div>
        <div class="modal-body">
	<form role="form" method="post">
	  <div class="form-group">
	    <label for="Username">Username</label>
	    <input type="text" class="form-control" name="username" id="username" placeholder="Username">
	  </div>
	  <div class="form-group">
	    <label for="Password">Password</label>
	    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
	  </div>
	  <div class="form-group">
	    <p class="help-block">Example block-level help text here.</p>
	  </div>
	  <input type="submit" name="signin" class="btn btn-success" value="Sign In">
	</form>

        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" onClick aria-hidden="true">&times;</button>
          <h4 class="modal-title">Sign Up</h4>
        </div>
        <div class="modal-body">
	<form role="form" method="post">
	  <div class="form-group">
	    <label for="Username">Username</label>
	    <input type="text" value="" class="form-control" name="username" id="username" placeholder="Username" required>
	  </div>
	  <div class="form-group">
	    <label for="Email">Email</label>
	    <input type="email" value="" class="form-control" name="email" id="email" placeholder="Email" required>
	  </div>
	  <div class="form-group">
	    <label for="Password">Password</label>
	    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
	  </div>
	  <div class="form-group">
	    <p class="help-block">Example block-level help text here.</p>
	  </div>
	  <input type="submit" name='signup' class="btn btn-success" value="Sign Up">
	</form>
        </div>
      </div>
    </div>
  </div>
</div>

  <div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" onClick aria-hidden="true">&times;</button>
          <h4 class="modal-title">Logout</h4>
        </div>
        <div class="modal-body">
	<div class="form-group">
	    <p class="help-block">Are you sure you want to logout?</p>
	  </div>
	 <form action="" method="post" role="form">
		<input type="submit" value="Logout" class="btn btn-danger" name="logout">
	</form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" onClick aria-hidden="true">&times;</button>
          <h4 class="modal-title"><?php echo $user; ?></h4>
        </div>
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" onClick aria-hidden="true">&times;</button>
          <h4 class="modal-title">Submit a Song</h4>
	</div>
	<div class="modal-body">
	<form role="form" method="post">
	  <div class="form-group">
	    <label for="url">Url</label>
	    <input type="text" value="" class="form-control" name="url" id="url" placeholder="Url" required>
	  </div>
	  <div class="form-group">
	    <label for="video">Music Video</label>
	    <input type="email" value="" class="form-control" name="video" id="video" placeholder="Music Video(Optional)">
	  </div>
	  <div class="form-group">
	    <label for="genre">Genre</label>
	    <select name="genre" class="form-control">
	  <option>Pop</option>
	  <option>Electronic</option>
	  <option>Hip-Hop</option>
	  <option>Rock</option>
	  <option>Metal</option>
	</select>
	  </div>
	  <div class="form-group">
	    <p class="help-block">We currently only support soundcloud.</p>
	  </div>
	  <input type="submit" name='submit' class="btn btn-success" value="Sign Up">
	</form>
	</div>
      </div>
    </div>
  </div>

<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
</nav>
</body>
</html>
