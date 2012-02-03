<?php

       require_once '../Config.php' ; 
       
       $login = isset ( $_REQUEST [ 'login' ] ) ? $_REQUEST [ 'login' ] : false ;
       $password = isset ( $_REQUEST [ 'password' ] ) ? $_REQUEST [ 'password' ] : false ;
       $nickname = isset ( $_REQUEST [ 'nickname' ] ) ? $_REQUEST [ 'nickname' ] : false ;
       
       if ( $login !== false && $password !== false && $nickname !== false ) {
              if ( ! loginInUse ( $login ) ) {
                     if ( ! nickNameInUse ( $nickname ) ) {
                            $db = getDbConnection ( ) ;
                            $ent = htmlentities ( $nickname , ENT_NOQUOTES , 'UTF-8' ) ;
                            $nickname = htmlspecialchars_decode ( $ent , ENT_NOQUOTES ) ;
                            $stmt = $db->prepare ( 'INSERT INTO `users` ( `nickname`, `login`, `passwd` ) VALUES ( ?, ?, SHA1( ? ) )' ) ;
                            $stmt->bindValue ( 1 , $nickname , PDO::PARAM_STR ) ;
                            $stmt->bindValue ( 2 , $login , PDO::PARAM_STR ) ; 
                            $stmt->bindValue ( 3 , $password , PDO::PARAM_STR ) ;
                            try {
                                   if ( $stmt->execute ( ) ) {
                                          echo json_encode ( array ( 'status' => true ) ) ;
                                   } else {
                                          $response = array (
                                              'status' => false ,
                                              'unkownError' => true
                                          ) ;
                                          echo json_encode ( $response ) ;
                                   }
                            } catch ( PDOException $e ) { 
                                   echo $e->getMessage ( ) ;
                            }
                     } else {
                            $response = array ( 
                                'status' => false ,
                                'nickNameInUse' => true
                            ) ;
                            echo json_encode ( $response ) ;
                     }
              } else {
                     $response = array (
                         'status' => false ,
                         'loginInUse' => true
                     ) ;
                     echo json_encode ( $response ) ;
              }
       }
       
       function loginInUse ( $login ) {
              $db = getDbConnection ( ) ;
              $stmt = $db->prepare ( 'SELECT 1 FROM `users` WHERE `login` = ?' ) ;
              $stmt->bindValue ( 1 , $login , PDO::PARAM_STR ) ;
              try {
                     $stmt->execute ( ) ;
                     return $stmt->rowCount ( ) > 0 ;
              } catch ( PDOException $e ) { 
                     echo $e->getMessage ( ) ;
              }
       }
       
       function nickNameInUse ( $nickname ) {
              $db = getDbConnection ( ) ;
              $stmt = $db->prepare ( 'SELECT 1 FROM `users` WHERE `nickname` = ?' ) ;
              $stmt->bindValue ( 1 , $nickname , PDO::PARAM_STR ) ;
              try {
                     $stmt->execute ( ) ;
                     return $stmt->rowCount ( ) > 0 ;
              } catch ( PDOException $e ) { 
                     echo $e->getMessage ( ) ;
              }
       }
       