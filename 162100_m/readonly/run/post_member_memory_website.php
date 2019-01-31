<?php
require ('authentication_member.php');
?>
<?php
if (POWER > 0) {
  unset($text);
  if (!isset($sql['db_err'])) {
    db_conn();
  }
  if ($sql['db_err'] == '') {

    $result = @mysql_query('SELECT memory_website FROM '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' WHERE username="'.$session[0].'" LIMIT 1', $db);
    $row = @mysql_fetch_assoc($result);
    @mysql_free_result($result);

    if (!empty($_GET['linkhttp']) && !empty($_GET['linkname'])) {
      @ require ('readonly/function/filter.php');

      $_GET['linkhttp'] = preg_replace('/^(https?:\/\/[^\/]+)\/?$/', '$1/', filter1($_GET['linkhttp']));
      $_GET['linkname'] = filter1(strip_tags($_GET['linkname']), true);
      $text = '<span><a href="'.$_GET['linkhttp'].'">'.$_GET['linkname'].'</a></span>';
      $text = $text.preg_replace('/<(li|span)><a [^>]*=\"'.preg_quote($_GET['linkhttp'], '/').'\".+<\/(li|span)>/iU', '', $row['memory_website']);
      //if (!empty($row['memory_website'])) {
        if (strlen($text) > 40000) {
          $text = substr($text, 0, 40000);
          $text = preg_replace('/<\/(li|span)>.*$/iU', '</(li|span)>', $text);
        }
      //}
      $text = addslashes($text);
      $eval = '';
    } else {
      if ($_GET['act'] == 'clear') {
        $text = '';
        $eval = 'alert("清除完毕", "./");';
      }
    }
    if (isset($text)) {
      @mysql_query('UPDATE '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' SET memory_website="'.$text.'" WHERE username="'.$session[0].'" LIMIT 1', $db);
    }
    eval( $eval);
    //err('OK', 'ok');
  }
  @mysql_close();

}

?>