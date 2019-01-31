<?php

//判断登陆权限
//成员名|最后访问时间|KEY|上线|快捷登录入口标记
function confirm_power($path = './') {
  global $web, $session;
  if (isset($_COOKIE['usercookie'])) {
    //$_COOKIE['usercookie'] = preg_replace('/[\"\'\<\>\=]+/', '', $_COOKIE['usercookie']);
    if (!empty($_COOKIE['usercookie'])) {
      $session = @explode('|', $_COOKIE['usercookie']);
      if (is_array($session)) {
        $n = count($session);
        if ($n >= 4 && $n < 7) {
          if ($session[0] != $web['manager']) {
            return 1; //成员
          } else {
            if (!($GLOBALS['session_key'] = get_session_key())) {
              $GLOBALS['session_key'] = substr(@file_get_contents($path.'writable/__temp__/'.urlencode($session[0]).'.php'), 15);
            }
            if ($session[1].'|'.$session[2] == $GLOBALS['session_key']) {
              return 5; //基础管理员
            } else {
              $GLOBALS['session_err'] = ' <span class="redword">身份密钥已更改！请重新在此浏览器<a href="'.$path.'login.php">登陆</a>恢复。</span>';
              return 1; //成员
            }
          }
        }
      }
    }
  }
  return 0;
}

function get_session_key() {
  global $web, $sql, $session, $db;
  if (!isset($GLOBALS['session_key']) || !$GLOBALS['session_key']) {
    $GLOBALS['session_key'] = false;
    if (!isset($sql['db_err'])) {
      db_conn();
    }
    if ($sql['db_err'] == '') {
      $result = @mysql_query('SELECT session_key FROM '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' WHERE username="'.$session[0].'" LIMIT 1', $db);
      if ($row = @mysql_fetch_assoc($result)) {
        $GLOBALS['session_key'] = $row['session_key'];
      }
      @mysql_free_result($result);
    } else {
      //echo $sql['db_err'];
    }
    //@mysql_close();
  }
  return $GLOBALS['session_key'];
}

?>