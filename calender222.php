<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Document</title>
</head>

<style>
table, td {
    border: 1px solid black;
    border-collapse: collapse;
    text-align: center;
    margin: 0 auto;
}

td {
    width:70px;
    height:70px;
}

.container {
    margin: 0 auto;
    padding:0;
}

.today .button {
    display: flex;
    justify-content: center;
}

.button {
    display:flex;
    justify-content:space-around;
}



</style>

<body>

<?php
//定義變數
date_default_timezone_set('Asia/Taipei'); //默認時區設定為台灣時間

if(isset($_GET['year'])){   //年
    $year = $_GET['year'];
} else {
    $year = date('Y');
}

if(isset($_GET['month'])){   //月
    $month = $_GET['month'];
} else {
    $month = date('m');
}

$eMonth = [         //月份:英文縮寫
    '1' => 'Jan',
    '2' => 'Feb',
    '3' => 'Mar',
    '4' => 'Apr',
    '5' => 'May',
    '6' => 'Jun',
    '7' => 'Jul',
    '8' => 'Aug',
    '9' => 'Sep',
    '10' => 'Oct',
    '11' => 'Nov',
    '12' => 'Dec'
];
$em = $eMonth[$month];

$firstDay = date("{$year}-{$month}-1"); //當月第一天
$weekOfFirstDay = date('w', strtotime($firstDay)); //當月一號是周幾(0-6)
$monthTotalDates = date('t', strtotime($firstDay)); //當月的天數
$prevdays = date('t', strtotime("{$year}-{$month}-1 -1 Months"));  //上個月天數
$weekOfLastDay = date('w', strtotime("{$year}-{$month}-{$monthTotalDates}")); //當月的最後一天周幾(0-6)

if($weekOfFirstDay + $monthTotalDates <= 28) {     //定義一個月有幾周
    $week = 4;
} else if ($weekOfFirstDay + $monthTotalDates <= 35) {
    $week = 5;
} else if ($weekOfFirstDay + $monthTotalDates > 35 && $weekOfFirstDay + $monthTotalDates <= 38) {
    $week = 6;
}


//定義跳月邏輯
 $prevMonth = $month - 1;  //上月
 $prevYear = $year;
 if($prevMonth < 1) {
     $prevMonth = '12';
     $prevYear = $year - 1;   
 }
 
 $nextMonth = $month + 1;  //下月
 $nextYear = $year;
 if($nextMonth > 12) {
     $nextMonth = '1';
     $nextYear = $year +1;
 }
?>

<div class="container">
    <!-- 顯示當日日期(m-Y) -->
    <?php
    echo $em." ".$year;   
    ?>
    
    <!-- 跳月跳年按鈕 -->
    <div class="button">    
    <a href="?year=<?= $prevYear ?>&month=<?= $prevMonth ?>">上月</a>
    <a href="?year=<?= $year - 1?>&month=<?= $month ?>">上年</a>
    <a href="?year=<?= $nextYear ?>&month=<?= $nextMonth ?>">下月</a>
    <a href="?year=<?= $year + 1?>&month=<?= $month ?>">下年</a>
    </div>
    
    <!-- 年曆主體 -->
    <table>
    <tr>
        <td>Su</td>
        <td>Mo</td>
        <td>Tu</td>
        <td>We</td>
        <td>Th</td>
        <td>Fr</td>
        <td>Sa</td>
    </tr>
    <?php
    for($i=0; $i<$week; $i++){
        echo "<tr>";
        for($j=0; $j<7; $j++){
            if($year==date("Y") && $month==date("m") && (($i*7)+($j+1))==date("j")){
                echo "<td style='background:lightgray;'>". date("j");
            } else if ($i==0 && $j<$weekOfFirstDay) {
                echo "<td>".($j + 1 - $weekOfFirstDay + $prevdays);
            } else if (($i*7)+($j+1) - $weekOfFirstDay > $monthTotalDates) {
                echo "<td>".($j - $weekOfLastDay);
            } else {
                echo "<td>" . (($i*7)+($j+1)-$weekOfFirstDay);
            }
            echo "</td>";
        }
        echo "</tr>";
    }
    ?>
    </table>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>  
</body>
</html>