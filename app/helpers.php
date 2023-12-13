<?php
function getFomattedElapsedDatetime($date2, $now = null) {
  $date2 = new DateTime($date2);
  $now = new DateTime($now ?? 'now');

  // 오늘이고 1분이내면 "방금 전" 표기
  if ($now->diff($date2)->i < 1 && $now->diff($date2)->h == 0 && $now->diff($date2)->days == 0) {
    $date = '방금 전';
  }
  // 오늘이고 1시간 이내면 "n분 전" 표기
  else if ($now->diff($date2)->h < 1 && $now->diff($date2)->days == 0) {
    $date = $now->diff($date2)->i . '분 전';
  }
  // 오늘이고 24시간 이내면 "n시간 전" 표기
  else if ($now->diff($date2)->days < 1) {
    $date = $now->diff($date2)->h . '시간 전';
  }
  // 오늘이고 7일 이내면 "n일 전" 표기
  else if ($now->diff($date2)->days < 7) {
    $date = $now->diff($date2)->d . '일 전';
  }
  // 오늘이고 7일 이후면 "Y-m-d" 표기
  else {
    $date = $date2->format('Y-m-d H:i:s');
  }

  return $date;
}
