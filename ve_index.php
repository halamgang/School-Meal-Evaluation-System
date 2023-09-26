<?php
// data.json 파일에서 데이터 불러오기
$data = json_decode(file_get_contents('data.json'), true);

$totalFoodGoodOrBad = 0;
$totalFoodYangOrBad = 0;
$totalFoodPeopleOrBad = 0;

foreach ($data as $entry) {
    $totalFoodGoodOrBad += $entry['food_good_or_bad'];
    $totalFoodYangOrBad += $entry['food_yang_or_bad'];
    $totalFoodPeopleOrBad += $entry['food_people_or_bad'];
}

$averageFoodGoodOrBad = count($data) > 0 ? ($totalFoodGoodOrBad / count($data)) : "N/A";
$averageFoodYangOrBad = count($data) > 0 ? ($totalFoodYangOrBad / count($data)) : "N/A";
$averageFoodPeopleOrBad = count($data) > 0 ? ($totalFoodPeopleOrBad / count($data)) : "N/A";
?>
<?php 
function printStars($score) {
    $fullStar = "<span class='star'>&#9733;</span>";
    $emptyStar = "<span class='star'>&#9734;</span>";
    
    for ($i = 0; $i < 5; $i++) {
        if ($i < round($score)) {
            echo $fullStar;
        } else {
            echo $emptyStar;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>급식 설문조사 결과</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .box {
            color: black;
            font-family: Helvetica, Arial, sans-serif;
            font-weight: 500;
            font-size: 15px;
            border-radius: 30px;
            line-height: 22px;
            background-color: transparent;
            border: 2px solid #1ECD97;
            padding: 13px;
            width: 100%;
            box-sizing: border-box;
        }
        
        .star {
          color: #FFD700; /* 노란색 */
        }
        
        .color-mom {
          color:#1ea9cd ;
        }
        
        .color-no-mom {
           color:#c31ecd ;
        }
        
         .color-father {
          color:#1ECD97 ;
         }

         .title-text{
             background-size :200% auto ; 
             font-size :27px ; 
             color :#fff ;
             background-image :linear-gradient(45deg,#1ea9cd ,#1ECD97 ,#1ECD97 ) ; 
             animation :gradient 5s ease-in-out infinite ; 
         }

         @keyframes gradient{
              0% {background-position :0%   50% ;}
              50% {background-position :100%   50% ;}
              100% {background-position :0%   50% ;}
         }
    </style>
</head>

<body>
<h3 class="title-text color-father">급식 설문조사 조사록</h2>

<?php foreach ($data as $entry): ?>
<div class="box">
    <h2 class="color-mom">학번:<?php echo htmlspecialchars($entry['name']); ?></h2>

    <?php
      // 항목의 날짜와 시간을 DateTime 객체로 변환
      $entryDateTime = DateTime::createFromFormat('mdHi', $entry['date']);
      // 한국 시간으로 타임존 설정
      date_default_timezone_set('Asia/Seoul');
    
      // 현재 시간을 한국시간으로 DateTime 객체로 가져옴
      $now = new DateTime();

      // 두 날짜/시간 사이의 차이를 DateInterval 객체로 가져옴
      $interval = $now->diff($entryDateTime);

      if ($interval->d > 0) {
          // 일 단위로 표시 (1일 이상)
          echo "<p>(" . $interval->format('%a일 전') . ")</p>";
      } elseif ($interval->h > 0) {
          // 시간 단위로 표시 (1시간 이상, 1일 미만)
          echo "<p>(" . $interval->format('%h시간 전') . ")</p>";
      } else {
          // 분 단위로 표시 (1분 이상, 1시간 미만)
          echo "<p>(" . $interval->format('%i분 전') . ")</p>";
      }
    ?>

    <p><strong>메뉴 만족도:</strong> <?php printStars($entry['food_good_or_bad']); ?></p>
    <p><strong>양 만족도:</strong> <?php printStars($entry['food_yang_or_bad']); ?></p>
    <p><strong>서비스 만족도:</strong> <?php printStars($entry['food_people_or_bad']); ?></p>

    <?php if (!empty($entry['feedback'])) : ?>
        <p><strong class="color-mom">피드백:</strong></br><?php echo nl2br(htmlspecialchars($entry['feedback'])); ?></div><?endif;?>
    
</div>
<?endforeach;?>

<script type="text/javascript">
function printStars(score) {
    var fullStar = "<span class='star'>&#9733;</span>";
    var emptyStar = "<span class='star'>&#9734;</span>";

    for (var i = 0; i<5; i++) {
        if(i<score){
            document.write(fullStar);
        } else{
            document.write(emptyStar);
        }
    }
}

printStars(4);  
printStars(3);  
printStars(5);  
</script>


</body></html>