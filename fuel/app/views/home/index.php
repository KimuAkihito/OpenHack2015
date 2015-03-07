<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1><?php echo $title; ?></h1>
    <video id="hls_player" poster="<?php echo $thumbnail_url; ?>" controls="controls" preload="preload" autoplay="autoplay" width="765" height="510" style="width: 765px; height: 510px;">
      <source src="<?php echo $movie_url; ?>" type="video/quicktime">
    </video>
  </body>
</html>
