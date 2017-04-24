<?php
      $bookmarks_json = file_get_contents('bookmarks.json');
      $bookmarks = json_decode($bookmarks_json);
      print_r($bookmarks);

?>