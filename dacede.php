<!DOCTYPE HTML>
<html>
<head>
	<title>Wave - What the internet is listening to</title>
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
</script>
</head>
<?php
// Start the motherfucking session!
session_start();
session_regenerate_id(true); 
$user = $_SESSION['user'];
$id = $_SESSION['id'];
?>
<style>
body {
padding-top: 70px; 
padding-bottom: 70px;
}
.navbar{
background-color: #FFFFFF;
border-bottom: solid 1px #F0F0F0 ;
border-top: solid 1px #F0F0F0 ;
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

.like {
height: 30px;
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
	<td class="sidebar">Genres</td>
	<?php
	}
	?>
	<td width='75%'>
	<?php
	if($_GET['id']){
		echo "Play";
	}
	else
		echo "Hot";
	?>
	</td>
</tr>
<tr>
	<td class="sidebar">
	<?php
	if(!$user){
	?>
	<button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#login">Sign In</button>
	<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#register">Sign Up</button><br />
	<?php 
	}
	?>
	
	<a href='?genre=Pop'><span class="label label-default">Pop</span></a>
	<a href='?genre=Electronic'><span class="label label-success">Electronic</span></a>
	<a href='?genre=Hip-hop'><span class="label label-info">Hip-Hop</span></a><br />
	<a href='?genre=Rock'><span class="label label-warning">Rock</span></a>
	<a href='?genre=Metal'><span class="label label-danger">Metal</span></a>
	<a href='?genre=Comedy'><span class="label label-default">Comedy</span></a><br />
	<a href='?genre=Alternative'><span class="label label-success">Alternative</span></a>
	<a href='?genre=Progressive'><span class="label label-info">Progressive</span></a>
	<a href='?genre=Punk'><span class="label label-warning">Punk</span></a><br />
	<a href='?genre=Blues'><span class="label label-default">Blues</span></a>
	<a href='?genre=Podcast'><span class="label label-success">Podcast</span></a>
	<a href='?genre=Nsfw'><span class="label label-danger">NSFW</span></a>
	</td>
	<td>
	<table>
	<tr>
	<?php
	// Require some fucking important files
	require("connect.php");
	require("PasswordHash.php");
	$page = $_SERVER['PHP_SELF'];
	$date = date("M d, Y");
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	// avoid that fucking array error
	$signup = array_key_exists('signup', $_POST) ? $_POST['signup'] : null;
	if($signup){
		$username = strip_tags($_POST['username']);
		$email = strip_tags($_POST['email']);
		$password = strip_tags($_POST['password']);
		//Hash the fucking password
		$passHasher = new PasswordHash(8, FALSE);
		$hash = $passHasher->HashPassword($password);
		
		// Check if that fucking username is taken
		$sql = "SELECT * FROM Users WHERE username='$username'";			
		$rs=$mysqli->query($sql);
 
		if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
		} else {
		$rows_returned = $rs->num_rows;
		// If $rows_returned = fucking 0, continue.
		if($rows_returned == 0){
		// Check if the fucking email has already been fucking used by another fucking user	
		$sql2 = "SELECT * FROM Users WHERE email='$email'";			
			$rs=$mysqli->query($sql2);
	 
			if($rs === false) {
			trigger_error('Wrong SQL: ' . $sql2 . ' Error: ' . $mysqli->error, E_USER_ERROR);
			} else {
			$rows_returned = $rs->num_rows;
			// if $rows_returned = 0, you're golden!
			if($rows_returned == 0){
						
				$sql3 = "INSERT INTO Users (id, username, email, password, date) VALUES ('', '$username', '$email', '$hash', '$date')";
	
				if($mysqli->query($sql3) === false) {
				trigger_error('Wrong SQL: ' . $sql3 . ' Error: ' . $conn->error, E_USER_ERROR);
				} else {
				$last_inserted_id = $mysqli->insert_id;
				$affected_rows = $mysqli->affected_rows;
				// It fucking worked!
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
		// Hash the fucking password
		$hash = $passHasher->HashPassword($password);
		// Check if user even fucking exists
		$sql= "SELECT * FROM Users WHERE username='$username'";
		$rs=$mysqli->query($sql);
		if($rs === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
		} else {
		$rows_returned = $rs->num_rows;
		if($rows_returned == 1){
		$rs->data_seek(0);
		while($row = $rs->fetch_assoc()){
			// Get the fucking password and check it against the fucking hash
			$pass = $row['password'];
			$checked = $passHasher->CheckPassword($password, $pass);
			if ($checked) {
			    echo "You have been signed in!";
			    header("LOCATION: $page");
			    // Create a fucking session!
			    
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
		// Logout message
		echo "You have been logged out!";
		// reload the fucking page
		header("LOCATION: $page");
		// Destroy the fucking session
		session_destroy();
	}

	$submit = array_key_exists('submit', $_POST) ? $_POST['submit'] : null;
	if($submit){
		$url = stripslashes(strip_tags($_POST['url']));
		$video = stripslashes(strip_tags($_POST['video']));
		$genre = stripslashes(strip_tags($_POST['genre']));
		// Currently supports soundcloud
		if ( 'soundcloud.com' == parse_url($url, PHP_URL_HOST) ){
			$url = urlencode($url);
			// Get the json data from soundcloud
			$string = file_get_contents("http://soundcloud.com/oembed?format=json&url=$url&iframe=true");
			// Decode that motherfucker
			$json = json_decode($string,true);
			$title =  mysqli_real_escape_string($mysqli, strip_tags($json['title']));
			$desc = mysqli_real_escape_string($mysqli, strip_tags($json['description']));
			$thumb = mysqli_real_escape_string($mysqli, strip_tags($json['thumbnail_url']));
			$author = mysqli_real_escape_string($mysqli, strip_tags($json['author_name']));
			$aurl = mysqli_real_escape_string($mysqli, strip_tags($json['author_url']));
			$sql = "SELECT * FROM Content WHERE url='$url'";			
			
			$rs=$mysqli->query($sql);

			if($rs === false) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
			} else {
			$rows_returned = $rs->num_rows;
			if($rows_returned == 0){
				// Insert that shit!
				$sql2 = "INSERT INTO Content (id, userid, username, title, description, thumb, author, aurl, url, video, genre, score, date) VALUES ('', '$id', '$user', '$title', '$desc', '$thumb', '$author', '$aurl', '$url', '$video', '$genre', '1', '$date')";

				if($mysqli->query($sql2) === false) {
				trigger_error('Wrong SQL: ' . $sql2 . ' Error: ' . $mysqli->error, E_USER_ERROR);
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

	$getid = array_key_exists('id', $_GET) ? $_GET['id'] : null;
	if($getid){
		$sql = "SELECT * FROM Content WHERE id='$getid'";
		$rs=$mysqli->query($sql);
		if($rs === false) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
		} else {
			$rows_returned = $rs->num_rows;
			if($rows_returned == 1){
				$rs->data_seek(0);
				while($row = $rs->fetch_assoc()){
				$postid = $row['id'];
				$userid = $row['userid'];
				$username = $row['username'];
				$title = $row['title'];
				$desc = $row['description'];
				$thumb = $row['thumb'];
				$author = $row['author'];
				$aurl = $row['aurl'];
				$genre = $row['genre'];
				$score = $row['score'];
				$url = $row['url'];
				$video = $row['video'];
				$_SESSION['url'] = $url;
				?>
					<table>
					<tr>
					<td><img src="<?php echo $thumb; ?>" height="100px" width="100px"></td>
					<td width='100%'><h4><span class="label label-success"><?php echo $score; ?></span> <?php echo $title; ?></h4><br />
						Submitted By <?php echo $username; ?><br />
					By <?php echo "<a target='_blank' href='$aurl'>$author</a>"; ?>
					<?php 
					if($user){			
					?>

					<form action="menu1.php" target="like" method="post">
					<input type='submit' name='like' value='Like' class='btn btn-success btn-xs'>
					<input type='hidden' name='id' value="<?php echo $id; ?>">
					<input type='hidden' name='user' value="<?php echo $user; ?>">				
					<input type='hidden' name='postid' value="<?php echo $postid; ?>">				
					<input type='hidden' name='score' value="<?php echo $score; ?>">
					<br />
					<br />
					</form>
					<iframe style='display:none' name="like" target="like" src="menu1.php"></iframe>

					</td>
					</tr>
					</table>
					<?php
					}
					?>
					<?php
					if($desc){
						$description =  preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', '<a target="_blank" href="$1">$1</a>', $desc);
						echo "$description<br />";
						
					}
					if($video){
						echo "<a href='$video'>Music Video</a><br />";
					}
				}
			}
			else
				echo "Post not found!";
		}
	}else{

	$genrearray = array_key_exists('genre', $_GET) ? $_GET['genre'] : null;
	if($genrearray){
	$sql = "SELECT * FROM (SELECT * FROM Content WHERE genre='$genrearray') AS wave ORDER BY score DESC LIMIT 15";
	$rs=$mysqli->query($sql);
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
	} else {
		$rows_returned = $rs->num_rows;
		if($rows_returned >= 1){
			$rs->data_seek(0);
			while($row = $rs->fetch_assoc()){
			$postid = $row['id'];
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
					<img src="<?php echo $thumb; ?>" height="75" width="75"><br />
					</td>
					<td width='100%'>
					<span class="label label-success"><?php echo $score; ?></span>					
					<?php echo "<a href='?id=$postid'>$title</a>"; ?><br />
					Submitted By <?php echo $username; ?> | <?php 
					if($genre == "NSFW"){
						echo "<span class='label label-danger'>NSFW</span>";
					}else
					echo $genre; 
					?><br />
					By <a target='_blank' href="<?php echo $aurl; ?>"><?php echo $author; ?></a><br />
					<?php 
					if($user){			
					?>

					<form action="menu1.php" target="like" method="post">
					<input type='submit' name='like' value='Like' class='btn btn-success btn-xs'>
					<input type='hidden' name='id' value="<?php echo $id; ?>">
					<input type='hidden' name='user' value="<?php echo $user; ?>">				
					<input type='hidden' name='postid' value="<?php echo $postid; ?>">				
					<input type='hidden' name='score' value="<?php echo $score; ?>">				
					</form>
					
					<iframe style='display:none' name="like" target="like" src="menu1.php"></iframe>
					<?php
					}
					?>
					</td>
				</tr>
				</table>
			<?php
			}
		}
		else
			echo "No posts!";
	}
	}else{	

	$sql = "SELECT * FROM (SELECT * FROM Content WHERE genre!='NSFW') AS wave ORDER BY score DESC LIMIT 15";
	$rs=$mysqli->query($sql);
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
	} else {
		$rows_returned = $rs->num_rows;
		if($rows_returned >= 1){
			$rs->data_seek(0);
			while($row = $rs->fetch_assoc()){
			$postid = $row['id'];
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
					<img src="<?php echo $thumb; ?>" height="75" width="75"><br />
					</td>
					<td width='100%'>
					<span class="label label-success"><?php echo $score; ?></span>					
					<?php echo "<a href='?id=$postid'>$title</a>"; ?><br />
					Submitted By <?php echo $username; ?> | <?php echo $genre; ?><br />
					By <a target='_blank' href="<?php echo $aurl; ?>"><?php echo $author; ?></a><br />
					<?php 
					if($user){			
					?>

					<form action="menu1.php" target="like" method="post">
					<input type='submit' name='like' value='Like' class='btn btn-success btn-xs'>
					<input type='hidden' name='id' value="<?php echo $id; ?>">
					<input type='hidden' name='user' value="<?php echo $user; ?>">				
					<input type='hidden' name='postid' value="<?php echo $postid; ?>">				
					<input type='hidden' name='score' value="<?php echo $score; ?>">				
					</form>
					
					<iframe style='display:none' name="like" target="like" src="menu1.php"></iframe>
					<?php
					}
					?>
					</td>
				</tr>
				</table>
			<?php
			}
		}
		else
			echo "No posts!";
	}
	}
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
	<?php
	$query = "SELECT * FROM (SELECT * FROM Content WHERE username='$user') AS wave ORDER BY id DESC LIMIT 15";
	$rs=$mysqli->query($query);
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
	} else {
		$rows_returned = $rs->num_rows;
		if($rows_returned >= 1){
			$rs->data_seek(0);
			while($row = $rs->fetch_assoc()){
				$postid = $row['id'];
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
				<img src="<?php echo $thumb; ?>" height="75" width="75"><br />
				</td>
				<td width='100%'>
				<span class="label label-success"><?php echo $score; ?></span>					
				<?php echo $title; ?><br />
				Submitted By <?php echo $username; ?> | <?php echo $genre; ?><br />
				By <a target='_blank' href="<?php echo $aurl; ?>"><?php echo $author; ?></a><br />
				</td>
			</tr>
			</table>

			<?php
			}
		}
		else
			echo "no posts";
	}
	?>
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
	    <input type="text" value="" class="form-control" name="video" id="video" placeholder="Music Video(Optional)">
	  </div>
	  <div class="form-group">
	    <label for="genre">Genre</label>
	    <select name="genre" class="form-control">
	  <option>Pop</option>
	  <option>Electronic</option>
	  <option>Hip-Hop</option>
	  <option>Rock</option>
	  <option>Metal</option>
	  <option>Comedy</option>
	  <option>Jazz</option>
	  <option>Alternative</option>
          <option>Progressive</option>
	  <option>Punk</option>
	  <option>Blues</option>
	  <option>Podcast</option>
	  <option>NSFW</option>
	</select>
	  </div>
	  <div class="form-group">
	    <p class="help-block">We currently only support soundcloud.</p>
	  </div>
	  <input type="submit" name='submit' class="btn btn-success" value="Submit">
	</form>
	</div>
      </div>
    </div>
  </div>

<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
<?php
$sessionurl = array_key_exists('url', $_SESSION) ? $_SESSION['url'] : null;
if($sessionurl){
?>
	<iframe width='100%' height='100px' scrolling='no' frameborder='no' src="https://w.soundcloud.com/player/?url=<?php echo urlencode($sessionurl); ?>"></iframe>
</nav>
<?php
}
?>
<?php
$rs->free();
$mysqli->close();
?>
</body>
</html>
