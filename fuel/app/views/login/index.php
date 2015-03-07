<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>OpenHackDay</title>
  </head>
<style>

#wrapper {
    position:absolute;
    top:50%;
    left:50%;
    width:200px;
    margin:-250px 0 0 -200px;
    height:200px;
    padding:100px;
}

h1 {
    width:200px;
    text-align:center;
    padding-bottom:20px;
}

input {
    width:200px;
    padding:6px;
}

input#submit {
    background-color:#5EBABA;
    border:none;
    color:white;
    width:200px;
    height:50px;
}


</style>
  <body>
    <div id="wrapper">
    <h1>GaraponFav</h1>
    <form action="./login/auth" method="POST">
        <p><input name="username" placeholder="username" /></p>
        <p><input name="password" type="password" placeholder="password" /></p>
        <input id="submit" type="submit" value="Login" />
    </form>
    </div>
  </body>
<?php echo Asset::css("bootstrap.css"); ?>
<?php echo Asset::js("bootstrap.min.js"); ?>
</html>
