<?php

ob_start();
?>
<?php

$host = "localhost";
$db = "ict_forum";
$user = "root";
$pass = "";

function register($fullname, $studentId, $username, $email, $password, $role, $batch, $designation) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $userNameQuery = "select * from user where user_name = '$username'";
    $emailQuery = "select * from user where email = '$email'";
    $userNameResult = mysqli_query($con, $userNameQuery);
    $emailResult = mysqli_query($con, $emailQuery);
    if (mysqli_num_rows($userNameResult) > 0) {
        mysqli_close($con);
        return "userNameExist";
    } else if (mysqli_num_rows($emailResult) > 0) {
        mysqli_close($con);
        return "emailExist";
    } else {
        $insertQuery = NULL;
        if ($role == "STUDENT") {
            $insertQuery = "insert into user (fullname, student_id, user_name, email, password, role, batch) values ('$fullname','$studentId','$username','$email','$password','$role','$batch')";
        } else {
            $insertQuery = "insert into user (fullname, user_name, email, password, role, designation) values ('$fullname','$username','$email','$password','$role','$designation')";
        }
        if (mysqli_query($con, $insertQuery)) {
            mysqli_close($con);
            header("Location:login.php");
            exit();
        } else {
//            echo "<p style='text-align:center; color:red;'>Error: " . $query . "<br>" . mysqli_error($con) . "</p>";
            mysqli_close($con);
            return "error";
        }
    }
}

function login($usernameOrEmail, $password, $frompage) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $query = "select * from user where (email = '$usernameOrEmail' and password='$password' ) or (user_name='$usernameOrEmail' and password = '$password')";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        $userNameQuery = "select user_name from user where (email = '$usernameOrEmail' and password='$password' ) or (user_name='$usernameOrEmail' and password = '$password')";
        $userNameresult = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($userNameresult);
        session_start();
        $_SESSION['authenticated'] = "true";
        $_SESSION['userName'] = $row['user_name'];
        mysqli_close($con);
        header("Location:" . $frompage);
        exit();
    } else {
        mysqli_close($con);
        return "userNotFound";
    }
}

function getAllUserInfo() {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $query = "select user_name,fullname,role,student_id,expert_in,batch,designation from user;";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        return $result;
    } else {
        mysqli_close($con);
        return "empty";
    }
}

function getUserDetails($userName) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $query = "select user_name,email,role,fullname,student_id,expert_in,batch,designation,description,profile_picture from user where user_name='$userName';";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        mysqli_close($con);
        return $result;
    } else {
        mysqli_close($con);
        return "";
    }
}

function uploadPhoto($imageName, $userName) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $prevImageFileName = NULL;
    $prevImageQuery = "select profile_picture from user where user_name = '$userName'";
    $prevImageResult = mysqli_query($con, $prevImageQuery);
    if (mysqli_num_rows($prevImageResult) > 0) {
        $row = mysqli_fetch_assoc($prevImageResult);
        $prevImageFileName = $row['profile_picture'];
    }

    $updateImageQuery = "update user set profile_picture='$imageName' where user_name='$userName'";
    if (mysqli_query($con, $updateImageQuery)) {
        mysqli_close($con);
        unlink("images/" . $prevImageFileName);
    } else {
        mysqli_close($con);
        return "error";
    }
}

function updateProfile($fullname, $expertIn, $description, $userName) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $updateProfileQuery = "update user set fullname='$fullname', expert_in='$expertIn', description='$description' where user_name='$userName'";
    if (mysqli_query($con, $updateProfileQuery)) {
        mysqli_close($con);
        header("Location:profile.php");
    } else {
        mysqli_close($con);
        return "error";
    }
}

function saveQuestion($userName, $title, $tags, $questionBody) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $tagArray = explode(",", $tags);
    $tagArrayLower = array();
    $tagArrayNotToInsert = array();
    for ($i = 0; $i < count($tagArray); $i++) {
        array_push($tagArrayLower, strtolower($tagArray[$i]));
    }
    $tagsInDbQuery = "select * from tag";
    $tagsInDb = mysqli_query($con, $tagsInDbQuery);
    if (mysqli_num_rows($tagsInDb) > 0) {
        while ($row = mysqli_fetch_assoc($tagsInDb)) {
            if (in_array(strtolower($row['tag_name']), $tagArrayLower)) {
                array_push($tagArrayNotToInsert, strtolower($row['tag_name']));
            }
        }
    }
    $tagArrayToInsert = array_diff($tagArrayLower, $tagArrayNotToInsert);
    foreach ($tagArrayToInsert as $value) {
        $tagInsertQuery = "insert into tag (tag_name) values('$value')";
        mysqli_query($con, $tagInsertQuery);
    }

    $questionInsertQuery = "insert into question (user_name,title,question_body,date) values('$userName','$title','$questionBody',now())";
    mysqli_query($con, $questionInsertQuery);
    $questionId = mysqli_insert_id($con);
    $findTagsOfQuestionQuery = "select * from tag where tag_name in ('";
    for ($j = 0; $j < count($tagArrayLower); $j++) {
        $findTagsOfQuestionQuery = $findTagsOfQuestionQuery . '' . $tagArrayLower[$j];
        if ($j < count($tagArrayLower) - 1) {
            $findTagsOfQuestionQuery = $findTagsOfQuestionQuery . "','";
        }
    }
    $findTagsOfQuestionQuery = $findTagsOfQuestionQuery . "')";
    $tagsOfQuestion = mysqli_query($con, $findTagsOfQuestionQuery);
    if (mysqli_num_rows($tagsOfQuestion) > 0) {
        while ($row = mysqli_fetch_assoc($tagsOfQuestion)) {
            $mappingQuery = 'insert into question_tag_mapping (question_id,tag_id) values(' . $questionId . ',' . $row['tag_id'] . ')';
            mysqli_query($con, $mappingQuery);
        }
    }
    mysqli_close($con);
    return $questionId;
}

function getAllTag() {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $tagQuery = "select * from tag";
    $allTags = mysqli_query($con, $tagQuery);
    if (mysqli_num_rows($allTags) > 0) {
        mysqli_close($con);
        return $allTags;
    } else {
        mysqli_close($con);
        return "";
    }
}

function getQusetionCountByTag($tagId) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $query = "select count(tag_id) as question_count_by_tag from question_tag_mapping where tag_id=$tagId";
    $questionCountByTag = mysqli_query($con, $query);
    mysqli_close($con);
    return $questionCountByTag;
}

function getQuestionDetails($questionId) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $questionQuery = "select * from question where question_id=$questionId";
    $questionDetails = mysqli_query($con, $questionQuery);
    if (mysqli_num_rows($questionDetails) > 0) {
        mysqli_close($con);
        return $questionDetails;
    } else {
        mysqli_close($con);
        return "";
    }
}

function getNewQuestions() {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $newQuestionQuery = "select * from question order by date desc";
    $newQuestions = mysqli_query($con, $newQuestionQuery);
    if (mysqli_num_rows($newQuestions) > 0) {
        mysqli_close($con);
        return $newQuestions;
    } else {
        mysqli_close($con);
        return "";
    }
}

function getTagsOfQuestion($questionId) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $tagOfQuestionQuery = "select * from question_tag_mapping where question_id=" . $questionId;
    $tagsName = array();
    $tagOfQuestion = mysqli_query($con, $tagOfQuestionQuery);
    if (mysqli_num_rows($tagOfQuestion) > 0) {
        while ($row = mysqli_fetch_assoc($tagOfQuestion)) {
            $tagNameQuery = "select * from tag where tag_id=" . $row['tag_id'];
            $tagNameResult = mysqli_query($con, $tagNameQuery);
            $tagRow = mysqli_fetch_assoc($tagNameResult);
            $tagsName[$tagRow['tag_id']] = $tagRow['tag_name'];
        }
        mysqli_close($con);
        return $tagsName;
    } else {
        mysqli_close($con);
        return "";
    }
}

function getQuestionsByTag($tagId) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $questionsByTagQuery = "select * from question where question_id in "
            . "(select question_id from question_tag_mapping where tag_id = $tagId) order by date desc;";
    $questionsByTag = mysqli_query($con, $questionsByTagQuery);
    if (mysqli_num_rows($questionsByTag) > 0) {
        mysqli_close($con);
        return $questionsByTag;
    } else {
        mysqli_close($con);
        return "";
    }
}

function getTagNameById($tagId) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $tagNameQuery = "select tag_name from tag where tag_id = $tagId";
    $tagName = mysqli_query($con, $tagNameQuery);
    if (mysqli_num_rows($tagName) > 0) {
        $result = mysqli_fetch_assoc($tagName);
        mysqli_close($con);
        return $result['tag_name'];
    } else {
        mysqli_close($con);
        return "";
    }
}

function getQuestionsOfWeek() {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $questionOfWeekQuery = "select * from question where  date >= DATE_SUB(CURDATE(), INTERVAL 1 week) ORDER BY date DESC";
    $questionOfWeek = mysqli_query($con, $questionOfWeekQuery);
    if (mysqli_num_rows($questionOfWeek) > 0) {
        mysqli_close($con);
        return $questionOfWeek;
    } else {
        mysqli_close($con);
        return "";
    }
}

function getQuestionsOfMonth() {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $questionOfWeekQuery = "select * from question where  date >= DATE_SUB(CURDATE(), INTERVAL 1 month) ORDER BY date DESC";
    $questionOfWeek = mysqli_query($con, $questionOfWeekQuery);
    if (mysqli_num_rows($questionOfWeek) > 0) {
        mysqli_close($con);
        return $questionOfWeek;
    } else {
        mysqli_close($con);
        return "";
    }
}

function getQuestionsByUser($userName) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $questionByUserQuery = "select * from question where user_name = '$userName' ORDER BY date DESC";
    $questionByUser = mysqli_query($con, $questionByUserQuery);
    if (mysqli_num_rows($questionByUser) > 0) {
        mysqli_close($con);
        return $questionByUser;
    } else {
        mysqli_close($con);
        return "";
    }
}

function saveAnswer($questionId, $userName, $answerBody) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $asnwerSaveQuery = "insert into answer (question_id, user_name, answer_body, date)"
            . "values($questionId,'$userName','$answerBody',now())";
    if (mysqli_query($con, $asnwerSaveQuery)) {
        $questionDetails = getQuestionDetails($questionId);
        $questionOwnerName = mysqli_fetch_assoc($questionDetails)['user_name'];
        $notifQuery = "insert into notification (question_id, user_name, notification_body, date) values ($questionId, '$questionOwnerName','".$userName." has answered to your question.', now())";
        if (mysqli_query($con, $notifQuery)) {
            $notificationId = mysqli_insert_id($con);
            $notifUnviewedQuery = "insert into notification_unviewed (notification_id, question_id, user_name) values($notificationId,$questionId,'$questionOwnerName')";
            mysqli_query($con, $notifUnviewedQuery);
        }
        mysqli_close($con);
        header("Location:questionDetails.php?questionId=" . $questionId);
        exit();
    }
}

function getAnswers($questionId) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $getAnsQuery = "select * from answer where question_id = " . $questionId . " order by date desc";
    $answers = mysqli_query($con, $getAnsQuery);
    if (mysqli_num_rows($answers) > 0) {
        mysqli_close($con);
        return $answers;
    } else {
        mysqli_close($con);
        return "";
    }
}

function getAnswersCount($questionId) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $getAnsCountQuery = "select count(answer_id) as ans_count from answer where question_id = " . $questionId;
    $answersCount = mysqli_query($con, $getAnsCountQuery);
    mysqli_close($con);
    return $answersCount;
}

function deleteAnswer($answerId, $questionId) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $deleteAnsCountQuery = "delete from answer where answer_id = " . $answerId;
    if (mysqli_query($con, $deleteAnsCountQuery)) {
        mysqli_close($con);
        header("Location: questionDetails.php?questionId=" . $questionId . "&&msg=success");
    }
}

//will be modify 
function deleteQuestion($questionId) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $answers = getAnswers($questionId);
    while ($ansRow = mysqli_fetch_assoc($answers)) {
        $deleteAnswerUpvote = "delete from answer_up_vote where answer_id=" . $ansRow['answer_id'];
        $isAnswerUpvoteDeleted = mysqli_query($con, $deleteAnswerUpvote);
        $deleteAnswerDownvote = "delete from answer_down_vote where answer_id=" . $ansRow['answer_id'];
        $isAnswerDownvoteDeleted = mysqli_query($con, $deleteAnswerDownvote);

        $answerBody = $ansRow['answer_body'];
        $imagesAttachedToAnswer = findAttachedImagesToPost($answerBody);
        for ($i = 0; $i < count($imagesAttachedToAnswer); $i++) {
            unlink("ckeditor/uploads/" . $imagesAttachedToAnswer[$i]);
        }
    }

    $deleteQuestionTag = "delete from question_tag_mapping where question_id=$questionId";
    $isTagDeleted = mysqli_query($con, $deleteQuestionTag);

    $deleteUpvote = "delete from question_up_vote where question_id=$questionId";
    $isUpVoteDeleted = mysqli_query($con, $deleteUpvote);

    $deleteDownvote = "delete from question_down_vote where question_id=$questionId";
    $isDownVoteDeleted = mysqli_query($con, $deleteDownvote);

    $deleteQuestionAns = "delete from answer where question_id=$questionId";
    $isAnsDeleted = mysqli_query($con, $deleteQuestionAns);
    
    $deleteNotif = "delete from notification where question_id=$questionId";
    $isNotifDeleted = mysqli_query($con, $deleteNotif);
    $deleteNotifUnviewed = "delete from notification_unviewed where question_id=$questionId";
    $isNotifDeleted = mysqli_query($con, $deleteNotifUnviewed);
    

    $deleteQuestionQuery = "delete from question where question_id=$questionId";
    if ($isTagDeleted && $isAnsDeleted) {
        $isQuestionDeleted = mysqli_query($con, $deleteQuestionQuery);
        mysqli_close($con);
        return TRUE;
    } else {
        mysqli_close($con);
        return FALSE;
    }
}

function getAnswerById($answerId) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $answerQuery = "select * from answer where answer_id=$answerId";
    $answerDetails = mysqli_query($con, $answerQuery);
    if (mysqli_num_rows($answerDetails) > 0) {
        mysqli_close($con);
        return $answerDetails;
    } else {
        mysqli_close($con);
        return "";
    }
}

function getQuestionVoteCount($questionId) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $totalUpvote = NULL;
    $totalDownVote = NULL;
    $upvoteQuery = "select count(*) as total_up_vote from question_up_vote where question_id=$questionId";
    $totalUpVoteResult = mysqli_query($con, $upvoteQuery);
    $totalUpVoteRow = mysqli_fetch_assoc($totalUpVoteResult);
    $totalUpVote = $totalUpVoteRow['total_up_vote'];

    $downvoteQuery = "select count(*) as total_down_vote from question_down_vote where question_id=$questionId";
    $totalDownVoteResult = mysqli_query($con, $downvoteQuery);
    $totalDownVoteRow = mysqli_fetch_assoc($totalDownVoteResult);
    $totalDownVote = $totalDownVoteRow['total_down_vote'];

    return $totalUpVote - $totalDownVote;
}

function questionUpVote($questionId, $userName) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $upvoteExistQuery = "select * from question_up_vote where question_id=$questionId and user_name='$userName'";
    $upvoteExist = mysqli_query($con, $upvoteExistQuery);
    if (mysqli_num_rows($upvoteExist) > 0) {
        mysqli_close($con);
        return "";
    } else {
        $query = "insert into question_up_vote values($questionId,'$userName')";
        mysqli_query($con, $query);
        $deleteQuery = "delete from question_down_vote where question_id=$questionId and user_name='$userName'";
        mysqli_query($con, $deleteQuery);
        mysqli_close($con);
        return getQuestionVoteCount($questionId);
    }
}

function questionDownVote($questionId, $userName) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $downvoteExistQuery = "select * from question_down_vote where question_id=$questionId and user_name='$userName'";
    $downvoteExist = mysqli_query($con, $downvoteExistQuery);
    if (mysqli_num_rows($downvoteExist) > 0) {
        mysqli_close($con);
        return "";
    } else {
        $query = "insert into question_down_vote values($questionId,'$userName')";
        mysqli_query($con, $query);
        $deleteQuery = "delete from question_up_vote where question_id=$questionId and user_name='$userName'";
        mysqli_query($con, $deleteQuery);
        mysqli_close($con);
        return getQuestionVoteCount($questionId);
    }
}

function getAnswerVoteCount($answerId) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $totalUpvote = NULL;
    $totalDownVote = NULL;
    $upvoteQuery = "select count(*) as total_up_vote from answer_up_vote where answer_id=$answerId";
    $totalUpVoteResult = mysqli_query($con, $upvoteQuery);
    $totalUpVoteRow = mysqli_fetch_assoc($totalUpVoteResult);
    $totalUpVote = $totalUpVoteRow['total_up_vote'];

    $downvoteQuery = "select count(*) as total_down_vote from answer_down_vote where answer_id=$answerId";
    $totalDownVoteResult = mysqli_query($con, $downvoteQuery);
    $totalDownVoteRow = mysqli_fetch_assoc($totalDownVoteResult);
    $totalDownVote = $totalDownVoteRow['total_down_vote'];

    return $totalUpVote - $totalDownVote;
}

function answerUpVote($answerId, $userName) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $upvoteExistQuery = "select * from answer_up_vote where answer_id=$answerId and user_name='$userName'";
    $upvoteExist = mysqli_query($con, $upvoteExistQuery);
    if (mysqli_num_rows($upvoteExist) > 0) {
        mysqli_close($con);
        return "";
    } else {
        $query = "insert into answer_up_vote values($answerId,'$userName')";
        mysqli_query($con, $query);
        $deleteQuery = "delete from answer_down_vote where answer_id=$answerId and user_name='$userName'";
        mysqli_query($con, $deleteQuery);
        mysqli_close($con);
        return getAnswerVoteCount($answerId);
    }
}

function answerDownVote($answerId, $userName) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $downvoteExistQuery = "select * from answer_down_vote where answer_id=$answerId and user_name='$userName'";
    $downvoteExist = mysqli_query($con, $downvoteExistQuery);
    if (mysqli_num_rows($downvoteExist) > 0) {
        mysqli_close($con);
        return "";
    } else {
        $query = "insert into answer_down_vote values($answerId,'$userName')";
        mysqli_query($con, $query);
        $deleteQuery = "delete from answer_up_vote where answer_id=$answerId and user_name='$userName'";
        mysqli_query($con, $deleteQuery);
        mysqli_close($con);
        return getAnswerVoteCount($answerId);
    }
}

function getTopQuestions() {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $topQuestionQuery = "select * from question";
    $topQuestion = mysqli_query($con, $topQuestionQuery);
    $questionArray = array();
    if (mysqli_num_rows($topQuestion) > 0) {
        while ($row = mysqli_fetch_assoc($topQuestion)) {
            $questionArray[getQuestionVoteCount($row['question_id'])] = $row;
        }
    }
    krsort($questionArray);
    return array_slice($questionArray, 0, 19);
}

function getAnsweredQuestionsByUser($userName) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $answerByUserQuery = "select * from question where question_id in (select question_id from answer where user_name='$userName') ORDER BY date DESC";
    $answerByUser = mysqli_query($con, $answerByUserQuery);
    if (mysqli_num_rows($answerByUser) > 0) {
        mysqli_close($con);
        return $answerByUser;
    } else {
        mysqli_close($con);
        return "";
    }
}

function getSearchedQuestions($searchValue) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $searchQuery = "SELECT * FROM question WHERE title LIKE '%$searchValue%' OR user_name in
                    (SELECT user_name FROM user WHERE user_name LIKE '%$searchValue%' OR fullname LIKE '%$searchValue%') 
                    OR question_id IN 
                    (SELECT question_id FROM question_tag_mapping WHERE tag_id IN 
                    (SELECT tag_id FROM tag WHERE tag_name LIKE '%$searchValue%' ))";
    $searchResult = mysqli_query($con, $searchQuery);
    if (mysqli_num_rows($searchResult) > 0) {
        mysqli_close($con);
        return $searchResult;
    } else {
        mysqli_close($con);
        return "";
    }
}

function saveNotice($userName, $title, $noticeBody, $batch) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $saveNoticeQuery = "insert into notice (user_name, title, notice_body, batch, date) values('$userName','$title','$noticeBody','$batch',now())";
    if (mysqli_query($con, $saveNoticeQuery)) {
        $noticeId = mysqli_insert_id($con);
        $noticeUnviewedQuery = "INSERT INTO notice_unviewed(notice_id, user_name) SELECT $noticeId, user.user_name FROM user WHERE batch='$batch'";
        mysqli_query($con, $noticeUnviewedQuery);
        mysqli_close($con);
        return $noticeId;
    } else {
        mysqli_close($con);
        return "";
    }
}

function getNoticeDetails($noticeId) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $noticeQuery = "select * from notice where notice_id=$noticeId";
    $noticeDetails = mysqli_query($con, $noticeQuery);
    if (mysqli_num_rows($noticeDetails) > 0) {
        mysqli_close($con);
        return $noticeDetails;
    } else {
        mysqli_close($con);
        return "";
    }
}

function deleteNotice($noticeId) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $deleteViewedNoticeQuery = "delete from notice_unviewed where notice_id=$noticeId";
    $deleteNoticeQuery = "delete from notice where notice_id=$noticeId";
    if (mysqli_query($con, $deleteViewedNoticeQuery)) {
        mysqli_query($con, $deleteNoticeQuery);
        mysqli_close($con);
        return TRUE;
    } else {
        mysqli_close($con);
        return FALSE;
    }
}

function getNewNotices($userName) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $userDetails = getUserDetails($userName);
    $newNoticesQuery = NULL;
    if (mysqli_fetch_assoc($userDetails)['role'] == 'TEACHER') {
        $newNoticesQuery = "select * from notice order by date desc";
    } else {
        $newNoticesQuery = "select * from notice where batch = (select batch from user where user_name = '$userName') order by date desc";
    }
    $newNotices = mysqli_query($con, $newNoticesQuery);
    if (mysqli_num_rows($newNotices) > 0) {
        mysqli_close($con);
        return $newNotices;
    } else {
        mysqli_close($con);
        return "";
    }
}

function getNoticesOfWeek($userName) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $userDetails = getUserDetails($userName);
    $noticeOfWeekQuery = NULL;
    if (mysqli_fetch_assoc($userDetails)['role'] == 'TEACHER') {
        $noticeOfWeekQuery = "select * from notice ORDER BY date DESC";
    } else {
        $noticeOfWeekQuery = "select * from notice where batch = (select batch from user where user_name = '$userName') and date >= DATE_SUB(CURDATE(), INTERVAL 1 week) ORDER BY date DESC";
    }
    $noticeOfWeek = mysqli_query($con, $noticeOfWeekQuery);
    if (mysqli_num_rows($noticeOfWeek) > 0) {
        mysqli_close($con);
        return $noticeOfWeek;
    } else {
        mysqli_close($con);
        return "";
    }
}

function getNoticesOfMonth($userName) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $userDetails = getUserDetails($userName);
    $noticeOfMonthQuery = NULL;
    if (mysqli_fetch_assoc($userDetails)['role'] == 'TEACHER') {
        $noticeOfMonthQuery = "select * from notice order by date desc";
    } else {
        $noticeOfMonthQuery = "select * from notice where batch = (select batch from user where user_name = '$userName') and date >= DATE_SUB(CURDATE(), INTERVAL 1 month) ORDER BY date DESC";
    }
    $noticeOfMonth = mysqli_query($con, $noticeOfMonthQuery);
    if (mysqli_num_rows($noticeOfMonth) > 0) {
        mysqli_close($con);
        return $noticeOfMonth;
    } else {
        mysqli_close($con);
        return "";
    }
}

function getUnviewedNoticeCount($userName) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $query = "select count(*) as total_unviewed_notice from notice_unviewed where user_name = '$userName'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total_unviewed_notice'];
}

function getUnviewedNotificationCount($userName) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $query = "select count(*) as total_unviewed_notfication from notification_unviewed where user_name = '$userName'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total_unviewed_notfication'];
}

function noticeViewed($noticeId, $userName) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $query = "delete from notice_unviewed where notice_id = $noticeId and user_name = '$userName'";
    mysqli_query($con, $query);
}

function notifViewed($notifId) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $query = "delete from notification_unviewed where notification_id = $notifId";
    mysqli_query($con, $query);
}

function isViewed($noticeId, $userName) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $query = "select * from notice_unviewed where notice_id = $noticeId and user_name = '$userName'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        mysqli_close($con);
        return 'unviewed';
    }
    mysqli_close($con);
    return 'viewed';
}

function isNotificationViewed($notificationId, $userName) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $query = "select * from notification_unviewed where notification_id = $notificationId and user_name = '$userName'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        mysqli_close($con);
        return 'unviewed';
    }
    mysqli_close($con);
    return 'viewed';
}

function changePassword($userName, $currentPassword, $newPassword) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $query = "select * from user where user_name='$userName' and password='$currentPassword'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        $updateQuery = "update user set password='$newPassword' where user_name='$userName'";
        if (mysqli_query($con, $updateQuery)) {
            mysqli_close($con);
            return 'success';
        }
    }
    mysqli_query($con, $query);
    return 'passwordMismatch';
}

function emailExists($email) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $query = "select * from user where email='$email'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        mysqli_close($con);
        return "true";
    } else {
        mysqli_close($con);
        return "false";
    }
}

function insertPasswordResetToken($email, $token) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $query = "insert into password_recovery values ('$email','$token')";
    $result = mysqli_query($con, $query);
}

function isTokenValid($email, $token) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $query = "select * from password_recovery where email='$email' and token='$token'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        mysqli_close($con);
        return "true";
    } else {
        mysqli_close($con);
        return "false";
    }
}

function recoverPassword($email, $newPassword) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $query = "update user set password = '$newPassword' where email='$email'";
    if (mysqli_query($con, $query)) {
        $tokeDeleteQuery = "delete from password_recovery where email='$email'";
        mysqli_query($con, $tokeDeleteQuery);
        return "success";
    } else {
        return "failed";
    }
}

function getUserNotification($userName) {
    global $host, $db, $user, $pass;
    $con = mysqli_connect($host, $user, $pass, $db);
    $notificationsQuery ="select * from notification where user_name='$userName' order by date desc";
    $notifications = mysqli_query($con, $notificationsQuery);
    if (mysqli_num_rows($notifications) > 0) {
        mysqli_close($con);
        return $notifications;
    } else {
        mysqli_close($con);
        return "";
    }
}
?>