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
    background: #545050;
}

table, td {
    /* border: 1px solid black; */
    border-collapse: collapse;
    text-align: center;
    margin: 0 auto;
    height:100%;
}

table {
    padding: 20px;
}

td {
    width:80px;
    height:90px;
}

td:hover {
    background-color: lightgray;
    border-radius: 50px;
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
    margin: 50px auto;
    min-width: 750px;
    
    border: 2px solid #7d7f82;
    box-shadow: 2px 2px 20px 2px gray;
    /* padding: 0px 40px; */
    padding-left: 0px;
  
    overflow: hidden;
    background: #fff;
    border-radius: 10px;
}

.sel {
    text-align: center;
    padding: 30px 0;
}

.todayColor {
    background-color: #ecc1c1;
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

.sideBar {
    float: left;
    height:100%;
    width: 40%;
    overflow: hidden;
}
.sideBar::after{
    content:"載入圖片中...";
    width:100%;
    text-align:center;
    line-height:500px;
    display:block;
    font-size:20px;
    font-weight:bolder;
}
.ipt {
    display:flex;
    justify-content: center;
    margin-top: 50px;
}

</style>

<body>


<?php
//定義變數
date_default_timezone_set('Asia/Taipei'); //默認時區設定為台灣時間

if(isset($_GET['year'])){   //年
    $year = $_GET['year'];
} else if(isset($_GET['ym'])) {
    $year = mb_substr($_GET['ym'],0,4);
} else {
    $year = date('Y');
}

if(isset($_GET['month'])){   //月
    $month = $_GET['month'];
} else if(isset($_GET['ym'])) {
    $month = mb_substr($_GET['ym'],5,2);
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

<!-- 年月選單 -->
<form action="index.php" method="GET" class="ipt form-inline">
  <input type="text" class="form-control mb-2 mr-sm-2" name="ym" placeholder="YYYY-MM" value="<?=date("Y-m");?>">
  <button type="submit" class="btn btn-info mb-2">Submit</button>
</form>


<div class="container">

  <div class="sideBar" style="width:500px;height:700px">
     <img src="https://picsum.photos/500/700/?random=1">
  </div>

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