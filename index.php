<?php
 
    require 'vendor/autoload.php';
    
    $app = new Slim\App([
        "settings"  => [
            "determineRouteBeforeAppMiddleware" => true,
        ]
    ]);

    $app->get('/getBooks', function () 
    {
        $sql="SELECT * FROM books";die;
        try {
            $stmt = getConnection()->query($sql);
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $db = null;
            
            return json_encode($books)->withHeader('Access-Control-Allow-Origin', 'http://4f72ff56.ngrok.io/');
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    });

    $app->get('/getBookById/{bookId}', function ($request) 
    {
        $bookId = $request->getAttribute('bookId');
        $sql="SELECT * FROM books WHERE id= $bookId";
        try {
            $stmt = getConnection()->query($sql);
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $db = null;
            
            return json_encode($books)->withHeader('Access-Control-Allow-Origin', 'http://4f72ff56.ngrok.io/');
            ;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    });

    $app->get('/getBookTasks/{bookId}', function ($request) 
    {
        $bookId = $request->getAttribute('bookId');
        $sql="SELECT * FROM tasks WHERE belongsTo= $bookId";
        try {
            $stmt = getConnection()->query($sql);
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $db = null;
            
            return json_encode($books);
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    });

    $app->run();

    function getConnection() {
    $dbhost="localhost";
    $dbuser="root";
    $dbpass="";
    $dbname="todo";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
    }

?>
