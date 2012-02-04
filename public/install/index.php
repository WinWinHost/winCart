<?php
session_start();
session_cache_expire(10);
set_include_path(implode(PATH_SEPARATOR, array(
    realpath( '../../library'),
    get_include_path(),
)));
require 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();
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
                
                mysql_query(sprintf("INSERT INTO `users` (`id`, `role`, `username`, `password`) VALUES (1, 'administrator', '%s', '%s')",
                        $_POST['name'], md5($_POST['pass'])
                        ));
                
           
                
                $config = new Zend_Config_Ini('/../../application/configs/application.ini');
                $data = $config->toArray();
                $data['production']['resources']['db']['params']['host'] = $db['hostname'];
                $data['production']['resources']['db']['params']['database'] = $db['database'];
                $data['production']['resources']['db']['params']['username'] = $db['username'];
                $data['production']['resources']['db']['params']['password'] = $db['password'];
                var_dump($data);
                
                $writer = new Zend_Config_Writer_Ini(array(
                    'config'   => new Zend_Config($data),
                    'filename' => realpath('../../application/configs/application.ini'), 
                ));
                $writer->write();
                
                echo $finish;
            }
        }
    }
} else {
    echo $intro;
}
echo $footer;