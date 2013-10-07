<!DOCTYPE HTML>
<html>
<head>
	<title>Wave</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://connect.soundcloud.com/sdk.js"></script>
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
      <li class='desktop'><a href="#">Sign In</a></li>
      <li class='desktop'><a href="#">Sign Up</a></li>
    </div>

<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav">
      <li><a href="#" data-toggle="modal" data-target="#login">Sign In</a></li>
      <li><a href="#" data-toggle="modal" data-target="#register">Sign Up</a></li>
  </div>
</ul>
</div>
</nav>
<div class="table-responsive">
<table class='table'>
<tr>
	<td class="sidebar"><b>Sign Up | Sign In</b></td>
	<td width='75%'><b>Hot</b></td>
</tr>
<tr>
	<td class="sidebar">
	<button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#login">Sign In</button>
	<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#register">Sign Up</button>
	</td>
	<td>
	<table>
	<tr>
		<?php
		$string = file_get_contents("http://soundcloud.com/oembed?format=json&url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F55920758&iframe=true");
		$json = json_decode($string,true);
		$title = $json['title'];
		$desc = $json['description'];
		$author = $json['author_name'];
		$aurl = $json['author_url'];
		$thumbnail = $json['thumbnail_url'];
		?>
		<td><?php echo "<img class='img-thumbnail' height='100px' width='100px' src='$thumbnail'>"; ?></td>
		<td>
		<?php
		echo "<b>$title</b><br />";
		echo "$desc<br />";
		echo "By <a href='$aurl'>$author</a>";
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
	<form role="form">
	  <div class="form-group">
	    <label for="Username">Username</label>
	    <input type="text" class="form-control" id="Username" placeholder="Username">
	  </div>
	  <div class="form-group">
	    <label for="Password">Password</label>
	    <input type="password" class="form-control" id="Password" placeholder="Password">
	  </div>
	  <div class="form-group">
	    <p class="help-block">Example block-level help text here.</p>
	  </div>
	  <button type="submit" class="btn btn-success">Sign In</button>
	</form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Save changes</button>
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
	<form role="form">
	  <div class="form-group">
	    <label for="Username">Username</label>
	    <input type="text" class="form-control" id="Username" placeholder="Username">
	  </div>
	  <div class="form-group">
	    <label for="Email">Email</label>
	    <input type="email" class="form-control" id="Email" placeholder="Email">
	  </div>
	  <div class="form-group">
	    <label for="Password">Password</label>
	    <input type="password" class="form-control" id="Password" placeholder="Password">
	  </div>
	  <div class="form-group">
	    <label for="Password">Confirm Password</label>
	    <input type="password" class="form-control" id="ConPass" placeholder="Password">
	  </div>
	  <div class="form-group">
	    <p class="help-block">Example block-level help text here.</p>
	  </div>
	  <button type="submit" class="btn btn-success">Sign Up</button>
	</form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

</div>

<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
<?php
$string = file_get_contents("http://soundcloud.com/oembed?format=json&url=http://soundcloud.com/thebeatles/09-being-for-the-benefit-of-mr&iframe=true");
$html = json_decode($string,true);
echo  $html['html'];
?>
</nav>
</body>
</html>
