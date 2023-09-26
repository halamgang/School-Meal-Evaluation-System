<?php foreach ($data as $entry): ?>
    <div class="box">
        <h2 class="color-mom">학번: <?php echo htmlspecialchars($entry['name']); ?> 
        <small style="font-size: 0.8em;">
            (23.<?php echo substr(htmlspecialchars($entry['date']), 0, 4); ?>)
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
                    echo "(" . $interval->format('%a일 전') . ")";
                } elseif ($interval->h > 0) {
                    // 시간 단위로 표시 (1시간 이상, 1일 미만)
                    echo "(" . $interval->format('%h시간 전') . ")";
                } else {
                    // 분 단위로 표시 (1분 이상, 1시간 미만)
                    echo "(" . $interval->format('%i분 전') . ")";
                }
            ?>
        </small></h2>
        
        <p><strong>메뉴 만족도:</strong> <?php printStars($entry['food_good_or_bad']); ?></p>
        <p><strong>양 만족도:</strong> <?php printStars($entry['food_yang_or_bad']); ?></p>
        <p><strong>서비스 만족도:</strong> <?php printStars($entry['food_people_or_bad']); ?></p>

        <?php if (!empty($entry['feedback'])) : ?>
            <p><strong class="color-mom">피드백:</strong><br><?php echo nl2br(htmlspecialchars($entry['feedback'])); ?></div><?endif;?>
    </div>
<?endforeach;?>