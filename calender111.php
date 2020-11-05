<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>

/* body {
    display: flex;
    justify-content: center;
    align-items: center;
}

table, td {
    border:1px solid black;
    border-collapse: collapse;
}

table {
    width: 500px;
    height:400px;
    text-align: center;
} */

</style>
<body>

<h1>萬年曆</h1>

<table>
<thead>
<tr>
    <td>Sun</td>
    <td>Mon</td>
    <td>Tue</td>
    <td>Wen</td>
    <td>Thur</td>
    <td>Fri</td>
    <td>Sat</td>
</tr>
</thead>

<tbody>
<?php
date_default_timezone_set('Asia/Taipei');

//定義變數
$year = isset($_GET['year']) ? $_GET['year'] : date('Y'); //當前年
$thisMonth = isset($_GET['month']) ? $_GET['month'] : date('m'); //當前月
$fDate = strtotime("{$year}-{$thisMonth}-1"); //當月一號時間 Y-m-d
$monthDay = date('t', $fDate); //當月天數28-31
$startDayWeek = date('w', $fDate); //當月一號是周幾0-6
$today = date('d', $fDate); //今日日期    //?    
$pDays = date('t', strtotime("{$year}-{$thisMonth}-1 -1 Months")); //上月天數 
$nDays = date('w', strtotime("{$year}-{$thisMonth}-{$monthDay}")); //本月結束是周幾
//定義一個月有幾週
if ($startDayWeek + $monthDay <= 28) {
  $week = 4;
} elseif ($startDayWeek + $monthDay <= 35) {
  $week = 5;
} elseif ($startDayWeek + $monthDay > 35 && $startDayWeek + $monthDay < 38) {
  $week = 6;
}
//定義跳月計算邏輯
    //下一月
    $nextYear = $year;
    $nextMonth = $thisMonth + 1;
    if ($nextMonth > 12) {
      $nextYear = $year + 1;
      $nextMonth = 1;
    }
    //上一月
    $preYear = $year;
    $preMonth = $thisMonth - 1;
    if ($preMonth < 1) {
      $preYear = $year - 1;
      $preMonth = 12;
    }
    //月份換算英文格式
    $enmonth = [
      '1'  => "January",
      '2'  => "February",
      '3'  => "March",
      '4'  => "April",
      '5'  => "May",
      '6'  => "June",
      '7'  => "July",
      '8'  => "August",
      '9'  => "September",
      '10' => "October",
      '11' => "November",
      '12' => "December"
    ];
    $ec = $enmonth[$thisMonth];
?>

<?php
//萬年曆本體
for ($i = 0; $i < $week; $i++) {
  echo "<tr>";
  for ($j = 0; $j < 7; $j++) {
    if ($year == date('Y') && $thisMonth == date('m') && (($i * 7) + ($j + 1)) == date('j')) { //標註今日
      echo "<td style='background:skyblue;'>" . date('j');
    } elseif ($i == 0 && $j < $startDayWeek) {
      echo "<td>" . ($j + 1 - $startDayWeek + $pDays); //none   //?
    } elseif ((($i * 7) + ($j + 1)) - $startDayWeek > $monthDay) {
      echo "<td>" . ($j - $nDays); //none
    } else {
      echo "<td>" . (($i * 7) + ($j + 1) - $startDayWeek);
    }
    echo "</td>";
  }
  echo "<tr>";
}
?>
</tbody>
</table>
<div class="overlay">
   <div class="syear display-1"><?= $year ?></div>
   <div class="smonth display-6 border-bottom"><?= $ec ?></div>
   <!-- <div class="today">TODAY</div>
   <div class="year"><?= date('Y') ?></div>
   <div class="month"><?= date('M') ?></div>
   <div class="month"><?= date('d') ?></div>
   <div class="month"><?= date('l') ?></div>
   <div class="time"><?= date('H:i:s') ?></div> -->
</div>
<div class="btn1">
    <a class="carousel-control-prev" href="?year=<?= $preYear ?>&month=<?= $preMonth ?>" role="button">
      <p class="text-dark h2 fas fa-angle-left"></p>
      <p class="d1 text-dark">Previous Month</p>
    </a>
    <a class="btn2-p carousel-control-prev" href="?year=<?php echo $year - 1 ?>&month=<?php echo $thisMonth ?>" role="button" data-slide="prev">
      <p class="text-dark h2 fas fa-angle-double-left"></p>
      <p class="d1 text-dark">Previous Year</p>
    </a>
    <a class="carousel-control-next" href="?year=<?php echo $nextYear ?>&month=<?php echo $nextMonth ?>" role="button" data-slide="next">
      <span class="text-dark h2 fas fa-angle-right"></span>
      <p class="d2 text-dark">Next Month</p>
    </a>
    <a class="btn2-n carousel-control-next" href="?year=<?php echo $year + 1 ?>&month=<?php echo $thisMonth ?>" role="button" data-slide="prev">
      <p class="text-dark h2 fas fa-angle-double-right"></p>
      <p class="d2 text-dark">Next Year</p>
</a>
<div>

    
</body>
</html>