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

        var elStep1 = document.getElementById("step1");
        var elStep2Saml = document.getElementById("step2-saml");
        var elStep2Manual = document.getElementById("step2-manual");
        var elStep2Navitas = document.getElementById("step2-navitas");
        var elStepHelp = document.getElementById("step-help");
        var elStepRestart = document.getElementById("step-restart");

        var domains = [
          { domain: 'navitas.com', next: 'step2-saml' },
          { domain: 'gmail.com', next: 'step2-manual' },
          { domain: 'acap.com', next: 'step2-navitas' },
          { domain: 'college.edu.au', next: 'step2-manual' }
          //{ domain: 'example.com', next:'step-help' },
        ];

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

            // Determine what Auth to use based on the domain
            var next_step = 'step-help';
            for (var i = 0; i < domains.length; i++) {
              if (domains[i].domain === domain) {
                next_step = domains[i].next;
              }
            }

            window.console.log('next_step', next_step);

            // Hide Step 1
            elStep1.style.display = "none";

            // Show Step2 - SAML
            if (next_step === 'step2-saml') {
              window.console.log('SHOW step2-saml');
              elStep2Saml.style.display = "block";
            }

            // Show Step2 - Manual
            if (next_step === 'step2-manual') {
              window.console.log('SHOW step2-manual');
              elStep2Manual.style.display = "block";
            }

            // Show Step2 - Navitas
            if (next_step === 'step2-navitas') {
              window.console.log('SHOW step2-navitas');
              elStep2Navitas.style.display = "block";
            }

            // Show Step2 - Help
            if (next_step === 'step-help') {
              window.console.log('SHOW step-help');
              elStepHelp.style.display = "block";
            }

            elStepRestart.style.display = "block";
          });

        // Click on NAVITAS Login
        $('button#btn-navitas-section').click(
          function() {
            elStep2Saml.style.display = "block";
            elStep2Manual.style.display = "none";
            elStep2Navitas.style.display = 'none';
            elStepRestart.style.display = "block";
            elStepHelp.style.display = "none";
            elStep1.style.display = "none";
          }
        );
        // Click on MANUAL Login
        $('button#btn-manual-section').click(
          function() {
            elStep2Saml.style.display = "none";
            elStep2Manual.style.display = "block";
            elStep2Navitas.style.display = "none";
            elStepRestart.style.display = "block";
            elStepHelp.style.display = "none";
            elStep1.style.display = "none";
          }
        );
        // Click on Reset button
        $('button#btn-login-reset').click(
          function() {
            elStep2Saml.style.display = "none";
            elStep2Manual.style.display = "none";
            elStep2Navitas.style.display = "none";
            elStepRestart.style.display = "block";
            elStepHelp.style.display = "none";
            elStep1.style.display = "block";
          }
        );

        // Button for HELP Section
        $('button#btn-help-section').click(
          function() {
            elStep2Saml.style.display = "none";
            elStep2Manual.style.display = "none";
            elStep2Navitas.style.display = "none";
            elStepRestart.style.display = "block";
            elStepHelp.style.display = "block";
            elStep1.style.display = "none";
          }
        );

        // Button to submit fore-navitas section
        $('button#submit-step2-navitas').click(
          function() {
            elStep2Saml.style.display = "block";
            elStep2Manual.style.display = "none";
            elStep2Navitas.style.display = "none";
            elStepRestart.style.display = "block";
            elStepHelp.style.display = "none";
            elStep1.style.display = "none";
          }
        );

        // Put whatever you like here. $ is available
        // to you as normal.
      });
    }
  };
});
