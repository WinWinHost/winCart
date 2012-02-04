<?php
session_start();
session_cache_expire(10);
require '/inc/HTML.php';

echo $header;
if (isset($_POST['page'])) {
    if ($_POST['page'] == 'step1') {
        echo $step1;
    } else if ($_POST['page'] == 'step2') {
        $_SESSION['database'] = array(
            'database' => $_POST['database'],
            'hostname' => $_POST['hostname'],
            'username' => $_POST['username'],
            'password' => $_POST['password']
        );
        echo $step2;
    } else if ($_POST['page'] == 'done') {
        $db = $_SESSION['database'];
        if(mysql_connect($db['hostname'], $db['username'], $db['password'])) {
            if(mysql_select_db($db['database'])){
                require '/inc/SQL.php';
                foreach($sql as $table) {
                    if(mysql_query($table)) {
                        //ok
                    } else {
                        //bad
                    }
                }
                
                mysql_query(sprintf("INSERT INTO `options` (`id`, `title`, `meta_description`, `meta_keywords`, `cEmail`) VALUES(1, '%s', '%s', '%s', '%s')",
                       $_POST['title'], $_POST['description'], $_POST['keywords'], $_POST['cemail']
                ));
        var_dump($_POST);
                mysql_query(sprintf("INSERT INTO `users` (`id`, `role`, `username`, `password`) VALUES (1, 'administrator', '%s', '%s')",
                        $_POST['name'], md5($_POST['pass'])
                        ));
                
                echo $finish;
            }
        }
    }
} else {
    echo $intro;
}
echo $footer;