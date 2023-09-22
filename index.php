<?php

function getSchoolMeal($schoolId, $officeCode) {
    $apiKey = '45a042fca35c42a4bccad5d7c5c67e04'; // 나이스 키 값 - > 추후 삭제
    $baseUrl = 'https://open.neis.go.kr/hub/mealServiceDietInfo';

    $today = date('Ymd');
    
    $params = array(
        'KEY' => $apiKey,
        'Type' => 'json',
        'ATPT_OFCDC_SC_CODE' => $officeCode,
        'SD_SCHUL_CODE' => $schoolId,
        'MLSV_YMD' => $today,
    );

    $url = sprintf("%s?%s", $baseUrl, http_build_query($params));

    try {
        $response = file_get_contents($url);

        if ($response !== false) {
            $data = json_decode($response, true);

            try {
                if (isset($data['mealServiceDietInfo'][1]['row'][0]['DDISH_NM'])) {
                    // 급식 정보가 있는 경우
                    return str_replace('<br/>', PHP_EOL, 
                        @$data['mealServiceDietInfo'][1]['row'][0]['DDISH_NM']);
                } else {
                    // 해당 날짜의 급식 정보가 없는 경우 //  return 추후 정리
                    return "해당 날짜의 급식 정보가 없습니다.";
                }
            } catch (Exception$e) {
                return "해당 날짜의 급식 정보를 불러오지 못했습니다.";
            }
        } else {
            return "API 요청에 실패했습니다."; // 요청 실패시 재요청하기
        }
    } catch (Exception$e) {
        echo "API 요청 중 오류가 발생했습니다: ",$e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        #feedback-counter {
        text-align: right;
        color: #1ECD97;
        }
        .color-mom {
          color: #1ea9cd;
        }
        .color-father {
          color: #1ECD97;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
			margin-bottom :5px ;
		}
      .title-text {
          background-size: 200% auto;
          font-size: 27px;
          color: #fff;
          background-image: linear-gradient(45deg, #1ea9cd, #1ECD97, #1ECD97);
          animation: gradient 5s ease-in-out infinite;
      }

      @keyframes gradient {
          0% {background-position: 0% 50%;}
          50% {background-position: 100% 50%;}
          100% {background-position: 0% 50%;}
      }
		.form-group input[type='text'],
		.form-group input[type='number'],
		.form-group textarea,
		.form-group select{
			color:black; 
			font-family : Helvetica , Arial , sans-serif ; 
			font-weight :500; 
			font-size :18px; 
			border-radius :5px; 
			line-height :22px; 
			background-color :transparent ; 
			border :2px solid #1ECD97 ; 
			padding :13px ;
 			width :100% ;
 			box-sizing:border-box ;
 			outline:none;}
      
    button {
      outline:none;
      height: 40px;
      text-align: center;
      width: 130px;
      border-radius:40px;
      background: #fff;
      border:2px solid #1ECD97;
      color:#1ECD97;
      letter-spacing:1px;
      text-shadow:none;
    
    /* 중앙 정렬 관련 속성 추가 */
    display:block ;
    margin-left:auto ;
    margin-right:auto ;
    
    font:{
        size:.7em ;
        weight:bold ;
    }
    cursor:pointer ;
    
    transition:
    all .25s ease ;
    
    &hover{
    color:white ;
    background:$green ;
    }
    &active{
    letter-spacing:.05em ;
    }
    &after{
    content:"SUBMIT" ;
    }
  
    @keyframes rotating{    /* 애니메이샨 버그 고치기 추가 */
    from{transform rotate(0deg) ;
    }to{transform rotate(360deg) ;
    }
    }

    </style>
</head>

<body>
<div class="container">
<h3 class="title-text color-father">급식 설문조사 | 아이디어 : <?php echo $ideaCount; ?>개</h3>

<form action="post_data.php" method="POST">

<div class = "form-group">

<label for = "meal-info" class = "color-mom"> 급식 정보: </label> 

<textarea id="meal-info" name="meal-info" readonly style="resize: none; height: 170px;">
<?php echo getSchoolMeal('7010182', 'B10', '20230901'); ?>
</textarea>


<div class="form-group">
    <label for="name" class="color-mom">학번:</label>
    <input type="text" id="name" name="name" required maxlength="5" value="익명" readonly />
    <p id="studentid-warning" style="color: red; display: none;">잘못된 학번입니다. 올바른 학번 정보를 입력 해주세요!</p>
</div>

<div class = "form-group">
<label for = "food-good-or-bad" class = "color-mom">급식 메뉴에 만족 하십니까?</label> 

<select id ="food-good-or-bad"name ="food-good-or-bad"> 

<option value ="5"> 매우 만족 </option> 

<option value ="4"> 만족 </option> 

<option value ="3"> 보통 </option> 

<option value ="2"> 불만족 </option> 

<option value ="1"> 매우불만족 </option> 
</select></div>

<div class = "form-group">
<label for = "food-yang-or-bad" class = "color-mom">급식 양에 만족 하십니까?</label> 

<select id ="food-yang-or-bad"name ="food-yang-or-bad"> 

<option value ="5"> 매우 만족 </option> 

<option value ="4"> 만족 </option> 

<option value ="3"> 보통 </option> 

<option value ="2"> 불만족 </option> 

<option value ="1"> 매우불만족 </option> 
</select></div>

<div class = "form-group">
<label for = "food-yang-or-bad" class = "color-mom">급식 도우미 분들 의 서비스에 만족하십니까?</label> 
<select id ="food-people-or-bad"name ="food-people-or-bad"> 

<option value ="5"> 매우 만족 </option> 

<option value ="4"> 만족 </option> 

<option value ="3"> 보통 </option> 

<option value ="2"> 불만족 </option> 

<option value ="1"> 매우불만족 </option> 
</select></div>

<div class="form-group">
    <label for="feedback" class="color-mom">피드백:</label> 
    <textarea id="feedback" name="feedback" style="resize: none;" maxlength="50" oninput="updateFeedbackCounter(this)"></textarea>
    <div id="feedback-counter">욕설 및 비속어 방지 | 0/50자</div>
</div>
  
<div class=bt-container><button type=submit id=button >제출하기</button>

<script>
    function checkStudentId(input) {
        var studentId = input.value;
        
        // 유효한 범위인지 확인
        if (isNaN(studentId)) {
            // 입력값이 숫자가 아닌 경우
            setTimeout(function() {
                document.getElementById('studentid-warning').style.display = 'block';
                document.getElementById('button').disabled = true; // 제출 버튼 비활성화
            }, 2000); // 2초 후에 경고 메시지를 표시하고 제출 버튼 비활성화
        } else { // 2초후가 처리된다면 처기해주기!
            document.getElementById('studentid-warning').style.display = 'none';
            document.getElementById('button').disabled = false; // 제출 버튼 활성화
        }
    }

    function checkFeedback(textarea) {
        var feedback = textarea.value;

        // 금지된 단어 목록 가져오기
        fetch('no_feed.txt') // 나중에 가져올꺼임
            .then(response => response.text())
            .then(data => {
                var forbiddenWords = data.split('\n').map(word => word.trim());

                // 금지된 단어가 포함되었는지 확인
                for (var i = 0; i < forbiddenWords.length; i++) {
                    if (feedback.includes(forbiddenWords[i])) {
                        document.getElementById('feedback-warning').style.display = 'block';
                        document.getElementById('button').disabled = true; // 제출 버튼 비활성화
                        return;
                    }
                }

                // 금지된 단어가 없으면 안내 메시지 숨김 및 제출 버튼 활성화
                document.getElementById('feedback-warning').style.display = 'none';
                document.getElementById('button').disabled = false; // 제출 버튼 활성화
            })
            .catch(error => console.error(error));
    }
</script>
<script>
function updateFeedbackCounter(textarea) {
    var feedback = textarea.value;
    
    // 현재 입력된 문자 수 계산
    var currentLength = feedback.length;
    
    // 카운터 업데이트
    document.getElementById('feedback-counter').innerText = currentLength + '/50자';
}
</script>
</form></div></body></html>
