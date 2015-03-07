<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
<div class="theater">
<?php echo Asset::img('imagen.jpg', array('width' => '1100', 'height' => '1000')); ?>
</div>
    <h1><?php echo $title; ?></h1>
   <div style="position: absolute; top: 70px; left:200px;">
    <video id="hls_player" poster="<?php echo $thumbnail_url; ?>" controls="controls" preload="preload" autoplay="autoplay" width="765" height="510" style="width: 765px; height: 510px;">
      <source src="<?php echo $movie_url; ?>" type="video/quicktime" />
      <track label="Japanese" kind="subtitles" src="<?php echo $caption_file_path?>" srclang="ja" default />
      <p>このブラウザは動画再生に対応していません</p>
    </video>
    </div>
  </body>
</html>
