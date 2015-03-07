<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>OpenHackDay</title>
  </head>
  <body>
    <form action="./login/auth" method="POST">
<table class="table table-striped">
<tbody>
<tr>
      <td><label>User: </label><input name="username" /></td>
      <td><label>Password: </label><input name="password" type="password" /></td>
</tr>
</tbody>
</table>
      <input type="submit" value="Login" />
    </form>
  </body>
<?php echo Asset::css("bootstrap.css"); ?>
<?php echo Asset::js("bootstrap.min.js"); ?>
</html>
