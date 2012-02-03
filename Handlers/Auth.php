<?php
       require_once '../Config.php' ;
       require_once '../Replace.php';
       
       $login = isset ( $_REQUEST [ 'login' ] ) ? $_REQUEST [ 'login' ] : false ;
       $password = isset ( $_REQUEST [ 'password' ] ) ? $_REQUEST [ 'password' ] : false ;
       
       if ( $login !== false && $password !== false ) {
              $db = getDbConnection ( ) ;
              $stmt = $db->prepare ( 'SELECT `uid`, `nickname`, `messages` FROM `users` WHERE `login` = ? AND `passwd` = SHA1(?)' ) ;
              $stmt->bindValue ( 1 , $login , PDO::PARAM_STR ) ;
              $stmt->bindValue ( 2 , $password , PDO::PARAM_STR ) ;
              try {
                     $stmt->execute ( ) ;
                     if ( $stmt->rowCount ( ) ) {
                            $data = $stmt->fetch ( PDO::FETCH_ASSOC ) ;
                            $db->query ( 'UPDATE `users` SET `status` = 1 WHERE `uid` = "'. $data [ 'uid' ] . '"' ) ;
                            $replace = replace ( $data , JoinMessage ) ;
                            $stmt = $db->prepare ( 'INSERT INTO `messages`( `uid`, `text` ) VALUES ( ? , ? )' ) ;
                            $stmt->bindValue ( 1 , $data [ 'uid' ] , PDO::PARAM_INT ) ;
                            $stmt->bindValue ( 2 , $replace , PDO::PARAM_STR ) ;
                            $stmt->execute ( ) ;
                            echo json_encode ( array ( 'status' => true , 'uid' => $data [ 'uid' ] , 'nickname' => $data [ 'nickname' ] ) ) ;
                     } else echo json_encode ( array ( 'status' => false , 'uid' => 0 , 'nickname' => null ) ) ;
              } catch ( PDOException $e ) { 
                     echo $e->getMessage ( ) ;
              }
       }