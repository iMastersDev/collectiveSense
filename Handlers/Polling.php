<?php
       set_time_limit ( 0 ) ;
       require_once '../Config.php' ;
       
       $db = getDbConnection ( ) ;
       $sql = <<<STMT
      SELECT 
             `mid` AS `lid` ,
             `nickname`,
             `users`.`uid` ,
             `text`
      FROM 
             `messages` 
             INNER JOIN `users` 
                     ON ( `messages`.`uid` = `users`.`uid` )
      WHERE
             `messages`.`mid` > ?            
STMT;
       
       $last = <<<LASTStmt
      SELECT 
             `mid` AS `lid` ,
             `nickname`,
             `users`.`uid` ,
             `text`
      FROM 
             `messages` 
             INNER JOIN `users` 
                     ON ( `messages`.`uid` = `users`.`uid` )
      ORDER BY 
             `mid` DESC
      LIMIT 1
LASTStmt;
       while ( true ) {
              
              $lid = isset ( $_REQUEST [ 'lid' ] ) ? $_REQUEST [ 'lid' ] : false ;
              if ( $lid !== false ) {
                     if ( $lid > 0 ) {
                            $stmt = $db->prepare ( $sql ) ;
                     } else {
                            $stmt = $db->prepare ( $last ) ;
                     }
                     $stmt->bindValue ( 1 , $lid , PDO::PARAM_INT ) ;
                     $stmt->execute ( ) ;
                     
                     if ( $stmt->rowCount ( ) ) {
                            $messages = $stmt->fetchAll ( PDO::FETCH_ASSOC ) ;
                            $stmt = $db->query ( 'SELECT `uid`, `nickname`, `messages` FROM `users` WHERE `status` = 1 ORDER BY `nickname`' ) ;
                            $users = $stmt->fetchAll ( PDO::FETCH_ASSOC ) ;
                            
                            $last = end ( $messages ) ;
                            $response = array ( 
                                'users' => $users ,
                                'messages' => $messages ,
                                'lid' => ( int ) $last [ 'lid' ]
                            ) ; 
                            break ;
                     } else {
                            usleep ( 300 ) ;
                     }
                     
              }
              
       }
       
       echo json_encode ( $response ) ;
       exit ;
       
       