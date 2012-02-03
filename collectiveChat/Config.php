<?php       
       
       defined ( 'MySQLHostname' ) || define ( 'MySQLHostname' , '127.0.0.1' ) ;
       defined ( 'MySQLDatabase' ) || define ( 'MySQLDatabase' , 'chat' ) ;
       defined ( 'MySQLUsername' ) || define ( 'MySQLUsername' , 'root' ) ;
       defined ( 'MySQLPassword' ) || define ( 'MySQLPassword' , '' ) ;
       

       defined ( 'AllowedTagsOnText' ) || define ( 'AllowedTagsOnText' , '<b><i><a><u><font>' ) ;
       defined ( 'JoinMessage' ) || define ( 'JoinMessage' , '%NICKNAME% entrou !' ) ;
       defined ( 'MessageSent' ) || define ( 'MessageSent' , '%NICKNAME% disse: %TEXT%' ) ;
       defined ( 'UserOut' ) || define ( 'UserOut' , '%NICKNAME% saiu !' ) ;
       
       if ( defined ( 'PRODUCTION' ) ) {
              error_reporting ( E_ALL & ~E_DEPRECATED ) ;
              ini_set ( 'display_errors' , 'Off' ) ;
       } else {
              error_reporting ( E_ALL | E_STRICT ) ;
              ini_set ( 'display_errors' , 'On' ) ;
       }

       setlocale ( LC_ALL , 'pt_BR' , 'pt_BR.iso-8859-1' , 'pt_BR.utf-8' , 'portuguese' ) ;
       ini_set ( 'date.timezone' , 'America/Sao_Paulo' ) ;
              
       require_once 'MySQL.php' ;
       
       function getDbConnection ( ) {
              return MySQL::getInstance ( ) ;
       }
       