<?php
require '../inc/init.inc.php';
if (isset($_GET['lang_code'])) {
  header('Content-Type: application/json; charset=utf-8');
  header('Cache-Control: public, max-age=31536000');
  header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60 * 24 * 7 * 4)));
  render_proverb_json($_GET['lang_code']);
}
exit();