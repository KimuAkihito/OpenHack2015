<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>これが見たい！</title>
  </head>
  <body>
    <h1>録画リスト</h1>
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
      <?php for($i = 0; $i < $response; $i++) { ?>
      <tr>
        <td>1</td>
        <td><img src="<?php echo $response[1]["thumbnail_url"]; ?>"</td>
        <td><?php echo $response[1]["title"]; ?></td>
	<?php if (true) { ?>
        <td><button type="button" class="btn btn-default">未達成</button></td>
	<?php } else { ?>
        <td><button type="button" class="btn btn-primary">Clear!!</button></td>
	<?php } ?>
        <td><button type="button" class="btn btn-warning">見たい！！</button></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  </div>
  </body>
	<?php echo Asset::css("bootstrap.css"); ?>
	<?php echo Asset::js("bootstrap.min.js"); ?>
</html>
