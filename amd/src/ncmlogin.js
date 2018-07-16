/*
 * @package    theme_ncmboost
 * @copyright  2018 Nicolas Jourdain
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
/**
 * @module themencmboost
 */
/* jshint unused:false */
define(['jquery'], function($) {
  return {
    init: function() {
      $(document).ready(function() {

        $('button#submit-step1').click(
          function() {
            window.console.log('Ref', $('#username1'));
            window.console.log('Value', $("#username1").val());

            var email = $("#username1").val();
            window.console.log("email:", email);
            var name = email.substring(0, email.lastIndexOf("@"));
            var domain = email.substring(email.lastIndexOf("@") + 1);
            window.console.log("name:", name);
            window.console.log("name:", domain);

            $('#login-username').hide();
            $('#login-reset').show();
            if (domain === 'navitas.com') {
              $('#login-basic').hide();
              $('#login-saml').show();
            } else {
              $('#username').val(email);
              $('#login-saml').hide();
              $('#login-basic').show();
            }
          });

        $('button#btn-login-reset').click(
          function() {
            $('#login-saml').hide();
            $('#login-basic').hide();
            $('#login-reset').hide();
            $('#login-username').show();
          });
        // Put whatever you like here. $ is available
        // to you as normal.
      });
    }
  };
});
