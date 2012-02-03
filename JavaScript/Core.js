$ ( function ( ) { 
       
       var lang = 'en' ;
       $.store = {
              rcTime : 5 ,
              lid : 0 ,
              uid : 0 ,
              nickname : null ,
              showSystemErrors : true ,
              display : 10 ,
              onuid : [ ] ,
              tms : new Date ( ) ,
              langs : {
                     'pt' : {
                            sendMessageError : 'Não foi possível enviar a mensagem !' ,
                            authenticationError : 'Não foi possível autenticar você !' ,
                            emptyLoginOrPassword : 'Login ou Senha não podem estar vazios !' ,
                            noAuth : 'Sem autenticação !' ,
                            emptyRegisterFields : 'Preencha todos os campos no formulário' ,
                            pollError : function ( time ) { 
                                   return 'Erro na escuta do servidor, reconectando em '.concat ( time , ' segundos' ) 
                            } ,
                            loginInUse : 'Esse login já está sendo usado, escolha um outro !' ,
                            nickNameInUse : 'Esse apelido já está sendo usado por outro usuário ...' ,
                            unknownError : 'Desculpe, nós temos um erro de sistema. Tente novamente mais tarde!' ,
                            reconecting : 'Reconectando ...' 
                     },
                     'en' : {
                            sendMessageError : "Can't send the message !" ,
                            authenticationError : "Can't authenticate you !" ,
                            emptyLoginOrPassword : "Login or Password can't be empty" ,
                            noAuth : 'Without Authentication !' ,
                            emptyRegisterFields : 'Fill all fields in the form' ,
                            pollError : function ( time ) { 
                                   return 'Polling error, trying reconect in '.concat ( time , ' seconds' )
                            } ,
                            loginInUse : 'This login is already in use, choose another one !' ,
                            nickNameInUse : 'This nickname already in use by other user ...' ,
                            unknownError : 'Sorry, we got a system error. Try again later !' ,
                            reconecting : 'Reconecting ...'
                     }
              } 
       } ;

       window.rcTime = parseInt ( $.store.rcTime ) ;
       
       $ ( '#message-text' ).on ( 'keyup' , function ( event ) { 
              var keyCode = event.keyCode ? event.keyCode : event.which ;
              var text = $.trim ( $ ( this ).val ( ) )  ;
              if ( parseInt ( keyCode ) === 13 && text.length > 0 ) {
                     $.ajax ( {
                          url : 'Handlers/Message.php' ,
                          type : 'POST' ,
                          data : {
                                 uid : $.store.uid ,
                                 tms : $.store.tms.getTime ( ) ,
                                 text : text.toString ( ) ,
                                 nickname : $.store.nickname
                          } ,
                          error : function ( ) {
                                   if ( $.showSysErrors ( ) ) {
                                          $.showError ( $.store.langs [ lang ].sendMessageError ) ;
                                   }
                          } 
                     } ) ;
                     $ ( this ).val ( '' ) ;
              }
       } ) ;  
       
       $ ( '#joinForm #joinButton' ).on ( 'click' , function ( ) {
              var login = $ ( '#joinForm #login' ).val ( ) ;
              var password = $ ( '#joinForm #password' ).val ( ) ;
              
              if ( login.length !== 0 && password.length !== 0 ) {
                     $.ajax ( { 
                            type : 'POST' ,
                            data : {
                                   login : login.toString ( ) ,
                                   password : password.toString ( )
                            } ,
                            url : 'Handlers/Auth.php' ,
                            dataType : 'json' ,
                            success : function ( response ) {
                                   if ( response.status !== undefined && response.status === true ) {
                                          $ ( '#join' ).fadeOut ( function ( ) {
                                                 $ ( '#chat' ).fadeIn ( function ( ) {
                                                        $.init ( undefined ) ;
                                                 } ) ;
                                                 $.store.uid = response.uid ;
                                                 $.store.nickname = response.nickname ;
                                          } ) ;
                                   } else {
                                          $ ( '#main' ).shake ( {
                                                 timeout : 500 ,
                                                 positions : [
                                                        [ 'L' , 50 ] ,
                                                        [ 'R' , 50 ] ,
                                                        [ 'U' , 0 ] ,
                                                        [ 'D' , 0 ]
                                                 ]
                                          } ) ;
                                   } 
                            }
                     } ) ;
              } else {
                     alert ( $.store.langs [ lang ].emptyLoginOrPassword ) ;
              }
              
       } ) ;

       
       $.showMessage = function ( text ) {
              $ ( '.message' ).children ( ). filter ( function ( index ) { 
                     return ( index >= $.store.display ) ; 
              } ). fadeOut ( function ( ) {
                     $ ( this ) .remove ( ) ;
              } ) ;
              var message = $ ( '<div />' ).addClass ( 'text-message' ) ;
              message = message.html ( text ) ;
              $ ( '.message' ).prepend ( message ) ;
       }

       $.showError = function ( text ) {
              var error = $ ( '<div />' ).addClass ( 'system-message' ) ;
              error.html ( text ) ;
              $ ( '.message' ).prepend ( error ) ;
       }

       $.init = function ( data ) {
              $.ajax ( {
                     cache : false ,
                     url : 'Handlers/Polling.php' ,
                     data : {
                            uid : $.store.uid ,
                            lid : $.store.lid ,
                            usr : $.unique ( $.store.onuid ).join ( ',' ) 
                     } ,
                     success : function ( data ) {
                            $.store.lid = data.lid ;
                            $.init ( data ) ;
                     } ,
                     error : function ( error ) {
                            if ( $.showSysErrors ( ) ) {
                                   $.showError ( $.store.langs [ lang ].pollError ( $.store.rcTime ) ) ;
                            }
                            setTimeout ( function ( ) {
                                   $.init ( undefined ) ;
                                   if ( $.showSysErrors ( ) ) {
                                          $.showError ( $.store.langs [ lang ].reconecting ) ;
                                   }
                            } , ( $.store.rcTime * 1000 ) ) ;
                     } ,
                     dataType : 'json'
              } ) ;
              if ( data !== undefined ) {
                     $.handle ( data ) ;
              }
       }
       
       $.handle = function ( data ) {
              if ( $.isPlainObject ( data ) ) {
                     var users = data.users , usersList = [ ] ;
                     $.each ( users , function ( ) {
                            var $u = $ ( this ) [ 0 ] ;
                            usersList.push ( '<li>'.concat ( $u.nickname , '</li>' ) ) ;
                            $.store.onuid.push ( $u.uid ) ;
                     } ) ;
                     $ ( '#online-users-list' ).html ( usersList.join ( new String ( ) ) ) ;

                     $.each ( data.messages , function ( ) {
                            var $m = $ ( this ) [ 0 ] ;
                            $.showMessage ( $m.text ) ;
                     } ) ;
              }
       }
       
       $ ( '#registerForm #registerButton' ).on ( 'click' , function ( ) {
              var nickname = $ ( '#registerForm #nickname' ).val ( ) ;
              var login = $ ( '#registerForm #login' ).val ( ) ;
              var password = $ ( '#registerForm #password' ).val ( ) ;
              
              if ( nickname.length > 0 && login.length > 0 && password.length > 0 ) {
                     $.ajax ( {
                            url : 'Handlers/Register.php' ,
                            data : {
                                   'nickname' : nickname ,
                                   'login' : login ,
                                   'password' : password
                            } ,
                            cache : false ,
                            type : 'POST' ,
                            dataType : 'json' ,
                            success : function ( response ) {
                                   if ( response.status !== undefined && response.status === true ) {
                                          $ ( '#joinForm #login' ).val ( login ) ;
                                          $ ( '#joinForm #password' ).val ( password ) ;
                                          $ ( '#joinForm #joinButton' ).trigger ( 'click' ) ;
                                   } else {
                                          if ( response.loginInUse !== undefined ) {
                                                 alert ( $.store.langs [ lang ].loginInUse ) ;
                                          } else if ( response.nickNameInUse !== undefined ) {
                                                 alert ( $.store.langs [ lang ].nickNameInUse ) ;
                                          } else {
                                                 alert ( $.store.langs [ lang ].unknownError ) ;
                                          }
                                   }
                            }
                     } ) ;
              } else {
                     $ ( '#main' ).shake ( {
                            timeout : 500 ,
                            positions : [
                                   [ 'L' , 50 ] ,
                                   [ 'R' , 50 ] ,
                                   [ 'U' , 50 ] ,
                                   [ 'D' , 50 ]
                            ]
                     } , function ( ) {
                            alert ( $.store.langs [ lang ].emptyRegisterFields ) ;
                     } ) ;
              }
       } ) ;
       $ ( window ).unload ( function ( ) { 
              if ( $.store.uid !== 0 ) {
                     $.ajax ( {
                            async : false ,
                            url : 'Handlers/Exit.php' ,
                            data : {
                                   uid : parseInt ( $.store.uid ) ,
                                   nickname : $.store.nickname || false
                            } 
                     } ) ;
              }
       } ) ;
       
       $.showSysErrors = function ( ) {
              return $.store.showSystemErrors === true ;
       }
} ) ;