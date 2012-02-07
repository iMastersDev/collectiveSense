<?php
       
       final class MySQL {
              
              private static $instance = null ;
              
              final public static function getInstance ( ) {
                     
                     if ( is_null ( self::$instance ) ) {
                            $DSN = sprintf ( 'mysql:host=%s;dbname=%s' , MySQLHostname , MySQLDatabase ) ;
                            self::$instance = new PDO ( $DSN , MySQLUsername , MySQLPassword ) ;
                            
                            self::$instance->setAttribute ( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION ) ;
                            self::$instance->setAttribute ( PDO::ATTR_TIMEOUT , 5 ) ;
                            
                     }
                     
                     return self::$instance ;
              }
              
              
       }