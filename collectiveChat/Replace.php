<?php

       /**
        * Faz um replace de variáveis
        * @param array $from
        * @param mixed $with
        * @return string
        */
       function replace ( array $from , $with ) {
              $vars = array ( '%NICKNAME%' , '%DATE%' , '%MINUTES%' , '%UID%' , '%TEXT%' , '%MESSAGES%' , '%TIMESTAMP%' , '%JOINED%' , '%LID%' ) ;
              $others = array ( '%TIMESTAMP%' => time () ) ;
              $others [ '%DATE%' ] = strftime ( '%Y-%m-%d' ) ;
              $others [ '%MINUTES%' ] = strftime ( '%H:%M:%S' ) ;
              $f = '%Y,%m,%d,%H,%M,%S,%B,%A,%b,%a' ;

              foreach ( explode ( ',' , $f ) as $ft ) {
                     $others [ $ft ] = strftime ( $ft , time () ) ;
                     $vars [ ] = $ft ;
              }
              $str = $with ;
              foreach ( $vars as $var ) {
                     $v = strtolower ( str_replace ( '%' , null , $var ) ) ;
                     if ( isset ( $from [ $v ] ) && ! array_key_exists ( $var , $others ) ) {
                            $str = str_replace ( $var , $from [ $v ] , $str ) ;
                     } elseif ( array_key_exists ( $var , $others ) ) {
                            $str = str_replace ( $var , $others [ $var ] , $str ) ;
                     }
              }
              return $str ;
       }

       /**
        * BBCode para formatação
        * @param string $text
        * @return string
        */
       function bbCode ( $text ) {
              $codes = array (
                  "/\[i\](.*?)\[\/i\]/is" => '<i>$1</i>',
                  "/\[b\](.*?)\[\/b\]/is" => "<b>$1</b>",
                  "/\[u\](.*?)\[\/u\]/is" => '<u>$1</u>' ,
                  "/\[url=(.*?)\](.*?)\[\/url\]/is" => '<a href="$1" target="_blank">$2</a>' ,
                  '/\[color=(.*?)\](.*?)\[\/color]/is' => '<font color=$1>$2</font>'
              ) ;
              $text = preg_replace ( array_keys ( $codes ) , array_values ( $codes ) , $text ) ;
              return $text ;
       }
