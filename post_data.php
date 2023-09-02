<?php

// 전송된 데이터 가져오기
$name = $_POST['name'];
$mealInfo = $_POST['meal-info'];
$foodGoodOrBad = $_POST['food-good-or-bad'];
$foodYangOrBad = $_POST['food-yang-or-bad'];
$foodPeopleOrBad = $_POST['food-people-or-bad'];
$feedback = $_POST['feedback'];

// 이름 마스킹 처리
if (strlen($name) > 3) {
    $maskedName = substr_replace($name, '**', 3);
} else {
    $maskedName = $name;
}

// 한국 시간으로 타임존 설정
date_default_timezone_set('Asia/Seoul');

// 현재 날짜와 시간 가져오기
$dateToday = date('mdHi'); // 'mdHi'는 월, 일, 시간(24시간제), 분을 나타내는 포맷입니다.


// 저장할 데이터 배열 생성
$data = array(
    'date' => $dateToday,
    'name' => $maskedName,
    'meal_info' => $mealInfo,
    'food_good_or_bad' => $foodGoodOrBad,
    'food_yang_or_bad' => $foodYangOrBad,
    'food_people_or_bad' => $foodPeopleOrBad,
    'feedback' => $feedback
);

// 기존 데이터 불러오기 (데이터가 없으면 빈 배열로 초기화)
$existingData = file_exists('data.json') ? json_decode(file_get_contents('data.json'), true) : array();

// 새로운 데이터 추가
$existingData[] = $data;  

// JSON 형식으로 변환하여 파일에 저장
file_put_contents('data.json', json_encode($existingData));

// ve_index.php로 이동
header("Location: ve_index.php");
exit;
