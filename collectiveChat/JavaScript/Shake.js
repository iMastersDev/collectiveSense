/**
 * @author Andrey Knupp, Eliseu Monar
 * @copyright (C)2011-2012
 * @description jQuery Shake Effect
 * @file Shake.js
 * @version 1.0
 */
( function ( $ ){
       $.fn.shake = function ( properties , callback ) {
              var $this = jQuery ( this ) || $ ( this ) ;
              properties = ( $.isEmptyObject ( properties ) ) ? { } : properties ;
              var $lrud = ( ( $this.parents ( ).outerWidth ( ) - $this.innerWidth ( ) ) / 4 ) ;
              if ( $this.size ( ) > 0 ) {
                     var $defaultPositions = { defaultPositions : { 'L' : $lrud , 'R' : $lrud , 'U' : $lrud , 'D' : $lrud } } ;
                     var settings = {
                               positions : $defaultPositions.defaultPositions ,
                                 timeout : 1000 ,
                                interval : 1 , 
                                  parent : false ,
                                  rotate : false 
                     } ;
                     var defaults = $.extend ( settings , properties , $defaultPositions ) ;
                     var $object = ( settings.parent === true ) ? ( $this.parent ( ) ) : $this ;
                     $.extend ( { 
                            objectToArray : function ( object ) {
                                   var $array = [ ] ;
                                   $.map ( object , function ( $y , $x ) { 
                                          $array.push ( [ $x , $y ] ) ;
                                   } ) ;
                                   return $array ;
                            }
                     } ) ;
                     if ( ! isNaN ( properties.timeout ) ) settings.timeout = parseInt ( properties.timeout ) ;
                     if ( ! isNaN ( properties.interval ) ) settings.interval = parseInt ( properties.interval ) ;
                     var $rand = function ( $x ) {
                            return parseInt ( Math.floor ( Math.random ( ) * parseInt ( $x ) ) ) ;
                     }
                     var $positions ;
                     if ( $.isPlainObject ( settings.positions ) ) {
                            var $pos = $.objectToArray ( settings.positions ) ;
                            if ( ! $.isEmptyObject ( settings.positions ) ) {
                                   $positions = $pos ;
                            } else $positions = $.objectToArray ( $defaultPositions.defaultPositions ) ; 
                     } else if ( parseInt ( properties.positions.length ) > 0 ) {
                            $positions = properties.positions ;
                     } else $positions = $.objectToArray ( $defaultPositions.defaultPositions ) ;  
                     var $length = $positions.length ;
                     var $shake = function ( $directions , $object ) { 
                                   if ( typeof $directions === 'object' ) {
                                          var $random = $directions [ $rand ( $length ) ] ;
                                          if ( settings.rotate === true ) {
                                                 var $rotation = ( ( ( Math.cos ( $rand ( $random [ 1 ] ) ) * 4 ) + Math.sin ( $rand ( $random [ 1 ] ) ) ) * 4 );
                                                 var $rad = ( $rand ( $random [ 1 ] ) * ( ( Math.PI * 2 ) / 360 ) ) ;
                                                 var $trans = $.browser.msie ? ( $.browser.version > 7 ) ? $object.css ( { 'zoom' : 1 } ) : false : false ;
                                                 var $M = { 'M11' : Math.cos ( $rad / 4 ) , 'M12' : Math.sin ( $rad / 4 ) } ;
                                                 var $MString = 'M11="' + $M [ 'M11' ] + '", M12="' + -$M [ 'M12' ] + '",M21="' + $M [ 'M12' ] + '", M22="' + $M [ 'M11' ] + '"';
                                                 var $cssObject =  {
                                                              'transform' : 'rotate(' + $rotation + 'deg)' ,
                                                           '-o-transform' : 'rotate(' + $rotation + 'deg)' ,
                                                         '-moz-transform' : 'rotate(' + $rotation + 'deg)' ,
                                                      '-webkit-transform' : 'rotate(' + $rotation + 'deg)' 
                                                 } ;
                                                 if ( $.browser.msie && $.browser.version < 9 ) {
                                                        $cssObject [ 'filter' ] = 'progid:DXImageTransform.Microsoft.Matrix ( '+ $MString +', sizingMethod="auto expand" ) !important' ;
                                                 } else $cssObject [ '-ms-transform' ] = 'rotate(' + $rotation + 'deg)' ;
                                                 $object.css ( $cssObject ) ;
                                          }
                                          switch ( $random [ 0 ].toString().toUpperCase() ) {
                                                  case 'R' : $object.css ( 'left' ,   $rand ( $random [ 1 ] ) + 'px' ) ; break ;
                                                  case 'L' : $object.css ( 'left' , - $rand ( $random [ 1 ] ) + 'px' ) ; break ;
                                                  case 'U' : $object.css (  'top' , - $rand ( $random [ 1 ] ) + 'px' ) ; break ;
                                                  case 'D' : $object.css (  'top' ,   $rand ( $random [ 1 ] ) + 'px' ) ; break ;
                                          } 
                                   }
                     } ;
                     $object.css ( 'position' , 'relative' ) ;
                     var $interval = window.setInterval ( function ( ) {
                            return  $shake ( $positions , $object ) ;
                     } , settings.interval  ) ;
                     window.setTimeout ( function ( ) {
                            $object.removeAttr ( 'style' ) ;
                            window.clearInterval ( $interval ) ;
                            if ( callback && callback !== undefined || callback != null ) {
                                   if ( typeof callback == 'function' ) {
                                          callback.call ( $object ) ;
                                   } else throw 'Invalid callback' ;
                            } 
                     } , settings.timeout ) ;
              }
       }
} ) ( jQuery );