<?php
       ob_start ( ) ;
       require_once '../Config.php' ;
       require_once '../Replace.php';

       $messageBody = isset ( $_REQUEST [ 'text' ] ) ? $_REQUEST [ 'text' ] : null ;
       if ( ! is_null ( $messageBody ) && strlen ( $messageBody ) > 0 ) {
              $text = strip_tags ( $messageBody , AllowedTagsOnText ) ;
              $uid = isset ( $_REQUEST [ 'uid' ] ) ? ( int ) $_REQUEST [ 'uid' ] : false ;
              $nickname = isset ( $_REQUEST [ 'nickname' ] ) ? $_REQUEST [ 'nickname' ] : false ;
              if ( $uid !== false && $nickname !== false ) {
                     $db = getDbConnection ( ) ;
                     $text = replace ( array ( 
                         'nickname' => $nickname ,
                         'uid' => $uid ,
                         'text' => $text
                     ) , MessageSent ) ;
                     $stmt = $db->prepare ( 'INSERT INTO `messages`( `uid`, `text` ) VALUES ( ? , ? )' ) ;
                     $stmt->bindValue ( 1 , $uid , PDO::PARAM_INT ) ;
                     $stmt->bindValue ( 2 , bbCode ( $text ) , PDO::PARAM_STR ) ;
                     try {
                            if ( $stmt->execute ( ) ) {
                                   $db->query ( 'DELETE FROM `messages` WHERE `date` < ( NOW() - INTERVAL 1 MINUTE )' ) ;
                                   echo json_encode ( array ( 'status' => true ) ) ;
                                   exit ; 
                            } else echo false ;
                     } catch ( PDOException $e ) { }
              } else {
                     header ( 'HTTP/1.1 Bad Request' , true ) ;
                     exit ;
              }
       }
       