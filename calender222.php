<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Trispace:wght@500&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<style>
body {
    font-family: 'Trispace', sans-serif;
}

table, td {
    /* border: 1px solid black; */
    border-collapse: collapse;
    text-align: center;
    vertical-align: top;
    margin: 0 auto;
    width:100%;
    height:100%;
}

td {
    width:70px;
    height:90px;
}

th {
    padding: 30px 0;
}

a{
    color: #a7a2a2; 
    font-size: 0.8rem;
}

a:hover {
    text-decoration: none;
    color: #ffc107;
}

.container {
    margin: 100px auto;
    min-width: 400px;
    max-width: 700px;
    border: 2px solid #7d7f82;
    box-shadow: 2px 2px 10px 2px gray;
    padding: 20px 40px;
}

.sel {
    text-align: center;
}

.todayColor {
    background: #f38080;
    box-shadow: 1px 1px 5px 5px #f18989;
    color: white;
    border-radius: 50px;
}

.otherMonth {
    color: #b1b9c1;
}

.holiday {
    font-size: 0.8rem;
    font-weight: 700;
    color: #14abe8;
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
<?php
$holiday=[
    '1-1'=>'元旦',
    '2-28'=>'和平紀念',
    '3-8'=>'婦女節',
    '4-4'=>'兒童節',
    '5-1'=>'勞動節',
    '9-3'=>'軍人節',
    '9-28'=>'教師節',
    '8-8'=>'父親節',
    '10-10'=>'國慶日',
    '10-25'=>'光復節',
    '11-12'=>'國父誕辰',
    '12-25'=>'聖誕節',
];
?>

<div class="container">
    <!-- 跳月跳年按鈕 -->
  <div class="sel row">    
    <div class="col-2"><a href="?year=<?= $prevYear ?>&month=<?= $prevMonth ?>"><i class="fas fa-angle-left"></i>上月</a></div>
    <div class="col-2"><a href="?year=<?= $year - 1?>&month=<?= $month ?>"><i class="fas fa-angle-double-left"></i>上年</a></div>
    <div class="col">
    <!-- 顯示當日日期(m-Y) -->
      <?php
      echo $em." ".$year;   
      ?>
    </div>
    <div class="col-2"><a href="?year=<?= $year + 1?>&month=<?= $month ?>">下年<i class="fas fa-angle-double-right"></i></a></div>
    <div class="col-2"><a href="?year=<?= $nextYear ?>&month=<?= $nextMonth ?>">下月<i class="fas fa-angle-right"></i></a></div>
   </div>
    
    <!-- 年曆主體 -->
    <table>
    <tr>
        <th>Su</th>
        <th>Mo</th>
        <th>Tu</th>
        <th>We</th>
        <th>Th</th>
        <th>Fr</th>
        <th>Sa</th>
    </tr>
    <?php
    for($i=0; $i<$week; $i++){
        echo "<tr>";
        for($j=0; $j<7; $j++){
            if($year==date("Y") && $month==date("m") && (($i*7)+($j+1))==date("j")){
                echo "<td class='todayColor'>". date("j");
            } else if ($i==0 && $j<$weekOfFirstDay) {
                echo "<td class='otherMonth'>".($j + 1 - $weekOfFirstDay + $prevdays);
            } else if (($i*7)+($j+1) - $weekOfFirstDay > $monthTotalDates) {
                echo "<td class='otherMonth'>".($j - $weekOfLastDay);
            } else {
                echo "<td>" . (($i*7)+($j+1)-$weekOfFirstDay);
            }
            
            if (!empty($holiday[$month . "-" . (($i*7)+($j+1)-$weekOfFirstDay)])) {
                echo "<br><div class='holiday'>" . $holiday[$month . "-" . (($i*7)+($j+1)-$weekOfFirstDay)] . "</div>";
              };
              
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