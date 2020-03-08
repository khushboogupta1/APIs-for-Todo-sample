<?php
 
    require 'vendor/autoload.php';
    
    $app = new Slim\App([
        "settings"  => [
            "determineRouteBeforeAppMiddleware" => true,
        ]
    ]);

    $app->get('/getBooks', function () 
    {
        $sql="SELECT * FROM books";
        try {
            $stmt = getConnection()->query($sql);
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $db = null;
            
            return json_encode($books);
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
            
            return json_encode($books);
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

    $app->get('/tasks', function ($request) 
    {
        $sql="SELECT * FROM tasks";
        try {
            $stmt = getConnection()->query($sql);
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $db = null;
            
            return json_encode($books);
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    });

    $app->post('/creatBook', function ($request,$args) 
    {
        $data = $request->getParsedBody();
        $bookName = $data['bookName'];
        $sql="INSERT INTO books (name) VALUES ('$bookName') ";
        try {
            $stmt = getConnection()->query($sql);
            
            return json_encode("BOOK_CREATED_SUCCESSFULLY");
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