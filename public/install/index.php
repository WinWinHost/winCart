<?php if(isset($_GET['step'])) {}
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Installation process</title>
        <link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz' rel='stylesheet' type='text/css' />
        <link rel="stylesheet" type='text/css' href="main.css"/>
        <script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
        <script src="application.js"></script>
    </head>
    <body>
        <div id="wrapper">
            <div id="intro" class="block">
                <h1>Intro Slide</h1>
                <h3>Minimal requirements:</h3>
                <ul>
                    <li>PHP 5.2+</li>
                    <li>MySQL 5.0+</li>
                    <li>Zend library in your include path</li>
                </ul>
                <input type="button" value="Next" class="submit"/>
            </div>  
            <div id="step1" class="block">
                <h1>Step 1: Database Information</h1>
                <form action="" method="POST">
                    <fieldset id="database-settings">
                        <label for="hostname">Hostname:</label>
                        <input type="text" name="hostname" value="localhost" />
                        <label for="database">Database name:</label> 
                        <input type="text" name="database" value=""  />
                        <label for="username">Username:</label> 
                        <input type="text" name="username" value=""  /> 
                        <label for="password">Password:</label> 
                        <input type="password" name="password" value=""  />
                        <input type="submit" value="Test Connection" name="test" class="submit" />
                        <input type="button" value="Next" name="submit" class="submit" />
                    </fieldset>
                </form>
            </div>
            <div id="step2" class="block">
                <h1>Step 2: Site Information</h1>
                <form action="" method="POST" onsubmit="install(this);">
                    <fieldset id="site-settings">
                        <label for="title">Title:</label>
                        <input type="text" name="title" value="" />
                        <label for="keywords">Meta keywords:</label> 
                        <textarea name="keywords"></textarea>
                        <label for="description">Meta description :</label> 
                        <textarea type="text" name="description"></textarea>
                        <label for="name">Username:</label> 
                        <input type="text" name="name" value=""  />
                        <label for="pass">Password:</label>
                        <input type="password" name="pass" value=""  />
                        <input type="button" value="Install" name="submit" class="submit" />
                    </fieldset>
                </form>
            </div>
            <div id="done" class="block">
                <h1>Finish</h1>
                <p>You have successful installed winCart e-commerce CMS.</p>
                <p>Please remove 'install' directory from you 'public' directory.</p>
            </div>
        </div>
    </body>
</html>