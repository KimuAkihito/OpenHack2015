<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>これが見たい！</title>
    <?php echo Asset::css("bootstrap.css"); ?>
    <?php echo Asset::js("bootstrap.min.js"); ?>
    <style>
      #container {
          width:100%;
          height:100%;
          background-color:#F5F5F5;
          margin:0;padding:0;
      }

      h1 {
          padding:20px 10px;
          margin:0 0 20px 0;
          background-color:#79D1B0;
          color:white;
      }

      body,html {
          margin:0;
      padding:0;
      }
      
    </style>
  </head>
  <body>
    <div id="container">
      <h1>今日の録画リスト</h1>
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
		    <td><?php echo intval($i) + 1; ?></td>
		    <td><img src="<?php echo $response[$i]["thumbnail_url"]; ?>"</td>
			     <td><?php echo $response[$i]["title"]; ?></td>
			     <?php if (true) { // データベースでレコードがありかつフラグがtrueの時?>
			     <form action="../home/index.php" method="post">
			       <input type="hidden" name="gtvid" value="<?php echo $response[$i]["gtvid"]; ?>">
			       <input type="hidden" name="mvurl" value="<?php echo $response[$i]["movie_url"]; ?>">
			       <input type="hidden" name="thumb" value="<?php echo $response[$i]["thumbnail_url"]; ?>">
			       <td><button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-play"></i></button></td>
			     </form>	
			     <?php } else { ?>
		    <td><button type="button" class="btn btn-default">未達成</button></td>
		    <?php } ?>

		    <?php if (true) {  // データベースに入っているかどうかで出し分け?>
		    <form action="./list/index.php" method="post">
		      <input type="hidden" name="gtvid" value="<?php echo $response[$i]["gtvid"]; ?>">
		      <td><button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-heart"></i></button></td>
		    </form>	
		    <?php } else { ?>
		    <input type="hidden" name="gtvid" value="<?php echo $response[$i]["gtvid"]; ?>">
		    <td><button type="submit" class="btn btn-default">挑戦中</button></td>
		    <?php } ?>
		  </tr>
		  <?php } ?>
	  </tbody>
	</table>
      </div>
    </div>
  </body>
</html>
