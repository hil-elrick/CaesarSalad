<?php
header('Content-Type: application/json');
if (session_status() == PHP_SESSION_NONE) {

    if ((isset($_POST['topic'])) & (isset($_POST['for'])) & (isset($_POST['user_input']))) {
        session_start();
        $_SESSION['topic'] = $_POST['topic'];
        $_SESSION['for'] = $_POST['for'];
        $_SESSION['sent'] = json_encode(array(
            "emotion" => array(
                "anger" => "0.0",
                "joy" => "0.0",
                "fear" => "0.0",
                "sadness" => "0.0",
                "surprise" => "0.0"
            ),
            "personality" => array(
                "extraversion" => "0.0",
                "openness" => "0.0",
                "agreeableness" => "0.0",
                "conscientiousness" => "0.0"
            ),
                "sentiment" => "0.0",
                "count" => "0"
            )
        );
        $user_input = $_POST['user_input'];
        $topic = $_SESSION['topic'];
        $for = $_SESSION['for'];
        $sent = $_SESSION['sent'];
        $command = escapeshellcmd("python /Users/hannahgreer/qhacks2018/CaesarSalad/fetchResponse.py $user_input $topic $for $sent");
        $output = shell_exec($command);

        echo json_encode( $output );
    }

} else if ( (isset($_SESSION['topic'])) & (isset($_SESSION['for'])) ) {
    if (isset($_POST['user_input'])) {
        if ($_POST['user_input'] == "quit") {
            echo $_SESSION['sent']; // already json_encoded
            destroy_session();
        }
        $user_input = $_POST['user_input'];
        $topic = $_SESSION['topic'];
        $for = $_SESSION['for'];
        $sent = $_SESSION['sent'];
        $command = escapeshellcmd("python /Users/hannahgreer/qhacks2018/CaesarSalad/fetchResponse.py $user_input $topic $for $sent");
        $output = shell_exec($command);
        echo json_encode( $output );
    }
}


