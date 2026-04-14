<?php
/*
Plugin Name: LP Student Enhancer
Description: Adds notification bar, course info shortcode, and custom styles for LearnPress.
Version: 1.0
Author: Student
*/

// 1. Notification Bar
add_action('wp_head', function() {
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $message = "Chào " . $current_user->display_name . ", bạn đã sẵn sàng bắt đầu bài học hôm nay chưa?";
    } else {
        $message = "Đăng nhập để lưu tiến độ học tập!";
    }

    echo '<div id="lp-notification-bar">' . $message . '</div>';
});

// 2. Shortcode [lp_course_info id="xxx"]
add_shortcode('lp_course_info', function($atts) {
    $atts = shortcode_atts(array('id' => 0), $atts);
    $course_id = intval($atts['id']);

    if (!$course_id) return "Không có ID khóa học.";

    // Dummy values (you can replace with LearnPress functions)
    $lessons = count(get_posts(array(
        'post_type' => 'lp_lesson',
        'post_parent' => $course_id
    )));

    $duration = get_post_meta($course_id, '_lp_duration', true);

    $status = "Chưa đăng ký";
    if (is_user_logged_in()) {
        $status = "Đã đăng ký"; // Simplified
    }

    return "<div class='lp-course-info'>
        <p><strong>Số bài học:</strong> $lessons</p>
        <p><strong>Thời gian:</strong> $duration</p>
        <p><strong>Trạng thái:</strong> $status</p>
    </div>";
});

// 3. Custom CSS
add_action('wp_head', function() {
    echo "<style>
    #lp-notification-bar {
        background: #ff6600;
        color: white;
        text-align: center;
        padding: 10px;
        font-weight: bold;
    }
    .learn-press .button-enroll,
    .learn-press .button-finish-course {
        background-color: #28a745 !important;
        color: white !important;
    }
    </style>";
});
?>
