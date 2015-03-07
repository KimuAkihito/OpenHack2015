<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
<h1><?php echo $title; ?></h1>
<div class="theater">
<?php echo Asset::img('imagen.jpg', array('width' => '1100', 'height' => '1000')); ?>
</div>
   <div style="position: absolute; top: -10px; left:170px;">
    <video id="hls_player" poster="<?php echo $thumbnail_url; ?>" controls="controls" preload="preload" autoplay="autoplay" width="900" height="1000" style="width: 800px; height: 700px;">
      <source src="<?php echo $movie_url; ?>" type="video/quicktime" />
      <track label="Japanese" kind="subtitles" src="<?php echo $caption_file_path?>" srclang="ja" default />
      <p>このブラウザは動画再生に対応していません</p>
    </video>
    </div>
  </body>
</html>
