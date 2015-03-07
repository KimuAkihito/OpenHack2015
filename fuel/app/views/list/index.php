<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>これが見たい！</title>
  </head>
  <body>
<blockquote>
    <h1>今日の録画リスト</h1>
</blockquote>
 <div  class="container">
    <table class="table table-striped">
    <thead>
      <tr>
        <th>番号</th>
        <th>キャプチャ</th>
        <th>タイトル</th>
        <th>視聴</th>
        <th>見たい</th>
      </tr>
    </thead>
    <tbody>
      <?php $cnt = count($response); ?>
      <?php for($i = 0; $i < $cnt; $i++) { ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td><img src="<?php echo $response[$i]["thumbnail_url"]; ?>"</td>
        <td><?php echo $response[$i]["title"]; ?></td>
	<?php if (true) { ?>
        <td><button type="button" class="btn btn-default">未達成</button></td>
	<?php } else { ?>
        <td><button type="button" class="btn btn-primary">Clear!!</button></td>
	<?php } ?>
	<form action="#" method="post">
	<input type="hidden" name="gtvid" value="<?php echo $response[$i]["gtvid"]; ?>">
        <td><button type="submit" class="btn btn-warning">見たい！！(課題をやる)</button></td>
	</form>	
      </tr>
      <?php } ?>
    </tbody>
  </table>
  </div>
  </body>
	<?php echo Asset::css("bootstrap.css"); ?>
	<?php echo Asset::js("bootstrap.min.js"); ?>
</html>
