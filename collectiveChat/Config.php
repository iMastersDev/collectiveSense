<?php       
       
       /** Defina o endereço do servidor MySQL (padrão: localhost) **/
       defined ( 'MySQLHostname' ) || define ( 'MySQLHostname' , '' ) ;
       
       /** Defina o nome do banco de dados do chat **/
       defined ( 'MySQLDatabase' ) || define ( 'MySQLDatabase' , '' ) ;
       
       /** Defina o nome do usuário de acesso ao banco de dados **/
       defined ( 'MySQLUsername' ) || define ( 'MySQLUsername' , '' ) ;
       
       /** Defina a senha desse usuário **/
       defined ( 'MySQLPassword' ) || define ( 'MySQLPassword' , '' ) ;
       
       /** Defina as tags permitidas no chat **/
       defined ( 'AllowedTagsOnText' ) || define ( 'AllowedTagsOnText' , '<b><i><a><u><font>' ) ;
       
       /** Quando um usuário entra, qual mensagem será exibida? **/
       defined ( 'JoinMessage' ) || define ( 'JoinMessage' , '%NICKNAME% entrou !' ) ;
       
       /** Quando um usuário diz alguma coisa, como a mensagem será exibida? **/
       defined ( 'MessageSent' ) || define ( 'MessageSent' , '%NICKNAME% disse: %TEXT%' ) ;
       
       /** Quando um usuário sai, qual mensagem será exibida? **/
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
       