<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-BR">
       <head>
              <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" />
              <script type="text/javascript" src="JavaScript/jQuery.js"></script>
              <script type="text/javascript" src="JavaScript/Shake.js"></script>
              <script type="text/javascript" src="JavaScript/Core.js"></script>
              <link rel="stylesheet" type="text/css" href="CSS/default.css" />
              <title>Chat ~ Collective Sense 2012</title>
       </head>
       <body>
              <div id="main">
                     <div id="chat" style="display: none">
                            <div id="users">
                                   <div id="online-list">
                                          <ul id="online-users-list"></ul>
                                   </div>
                                   <br clear="both" />
                            </div>
                            <div id="messages">
                                   <div id="messages-list">
                                          <div class="message">

                                          </div>
                                   </div>
                                   <br clear="both" />
                                   <div id="messsage-box">
                                          <textarea id="message-text" cols="83" rows="6"></textarea>
                                   </div>
                            </div>
                     </div>
                     <div id="join">
                            <form id="joinForm" method="GET">
                                   <table>
                                          <tr>
                                                 <td align="right">Login </td>
                                                 <td><input type="text" name="login" id="login" /></td>
                                          </tr>
                                          <tr>
                                                 <td>Password</td>
                                                 <td><input type="password" name="password" id="password" /></td>
                                          </tr>
                                          <tr>
                                                 <td></td>
                                                 <td><input type="button" id="joinButton" value="Join" /></td>
                                          </tr>
                                   </table>
                            </form>
                            <hr />
                            <form id="registerForm" method="GET">
                                   <table>
                                          <tr>
                                                 <td>Nickname</td>
                                                 <td><input type="text" name="nickname" id="nickname" /></td>
                                          </tr>
                                          <tr>
                                                 <td align="right">Login </td>
                                                 <td><input type="text" name="login" id="login" /></td>
                                          </tr>
                                          <tr>
                                                 <td>Password</td>
                                                 <td><input type="password" name="password" id="password" /></td>
                                          </tr>
                                          <tr>
                                                 <td></td>
                                                 <td><input type="button" id="registerButton" value="Register" /></td>
                                          </tr>
                                   </table>
                            </form>
                     </div>
              </div>
       </body>
</html>
