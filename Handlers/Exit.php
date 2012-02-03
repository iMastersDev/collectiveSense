<?php
       require_once '../Config.php' ;
       require_once '../Replace.php';
       
       $uid = isset ( $_REQUEST [ 'uid' ] ) ? $_REQUEST [ 'uid' ] : false ;
       $nickname = isset ( $_REQUEST [ 'nickname' ] ) ? $_REQUEST [ 'nickname' ] : false ;
       
       if ( $uid !== false && $nickname !== false ) {
              $db = getDbConnection ( ) ;
              $stmt = $db->prepare ( 'UPDATE `users` SET `status` = 0 WHERE `uid` = ?' ) ;
              $stmt->execute ( array ( $uid ) ) ;
              
              $replace = replace ( array ( 
                  'uid' => $uid ,
                  'nickname' => $nickname 
              ) , UserOut ) ;
              
              $stmt = $db->prepare ( 'INSERT INTO `messages`( `uid`, `text` ) VALUES ( ? , ? )' ) ;
              $stmt->bindValue ( 1 , $uid , PDO::PARAM_INT ) ;
              $stmt->bindValue ( 2 , $replace , PDO::PARAM_STR ) ;
              $stmt->execute ( ) ;
              
              exit ;
       }