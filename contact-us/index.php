<?php
error_reporting(-1);
ini_set('display_errors', 'On');
$basepath = __DIR__;
$template_path = $basepath.'/templates/';
require $basepath.'/../inc/template.inc.php';
require $basepath.'/../inc/init.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="UTF-8">
  <title>Contact Us - Biorhythm</title>
<?php
include template('head.contact');
include template('ga');
?>
  </head>
  <body class="contact" data-href="<?php echo base_url(); ?>/contact-us/">
<?php
include template('header');
?>
    <main class="main">
      <div class="container-fluid contact px-0">
        <div class="container p-5">
          <h2 class="h1-responsivefooter text-center my-4">Contact Us</h2>
          <div class="row">
            <!--Grid column-->
            <div class="col-md-9 mb-md-0 mb-5">
              <form id="contact-form" name="contact-form" action="/contact-us/" method="POST">

                <!--Grid row-->
                <div class="row">

                  <!--Grid column-->
                  <div class="col-md-6">
                    <div class="md-form mb-0">
                      <input type="text" id="name" name="name" class="form-control">
                      <label for="name" class="">Your name</label>
                    </div>
                  </div>
                  <!--Grid column-->

                  <!--Grid column-->
                  <div class="col-md-6">
                    <div class="md-form mb-0">
                      <input type="text" id="email" name="email" class="form-control">
                      <label for="email" class="">Your email</label>
                    </div>
                  </div>
                  <!--Grid column-->

                </div>
                <!--Grid row-->

                <!--Grid row-->
                <div class="row">
                  <div class="col-md-12">
                    <div class="md-form mb-0">
                      <input type="text" id="subject" name="subject" class="form-control">
                      <label for="subject" class="">Subject</label>
                    </div>
                  </div>
                </div>
                <!--Grid row-->

                <!--Grid row-->
                <div class="row">

                  <!--Grid column-->
                  <div class="col-md-12">

                    <div class="md-form">
                      <textarea type="text" id="message" name="message" rows="8" class="form-control md-textarea"></textarea>
                      <label for="message">Your message</label>
                    </div>

                  </div>
                </div>
                <!--Grid row-->

              </form>

              <div class="text-center text-md-left">
                <a class="btn btn-warning" onclick="validateForm();">Send</a>
              </div>
              <div id="status"></div>
            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-3 text-center">
              <ul class="list-unstyled mb-0">
                <li><i class="fas fa-map-marker-alt fa-2x"></i>
                  <p>Your City, 700000, <br/>Country</p>
                </li>

                <li><i class="fas fa-phone mt-4 fa-2x"></i>
                  <p>+ Phone</p>
                </li>

                <li><i class="fas fa-envelope mt-4 fa-2x"></i>
                  <p><a href="mailto:<?php echo $system_mail; ?>"><?php echo $system_mail; ?></a></p>
                </li>
              </ul>
            </div>
            <!--Grid column-->
          </div>
        </div>
      </div>
<?php
include template('script.contact');
?>
      <script>
      function validateForm() {
        document.getElementById('status').innerHTML = "Sending...";
        formData = {
            'name'     : $('input[name=name]').val(),
            'email'    : $('input[name=email]').val(),
            'subject'  : $('input[name=subject]').val(),
            'message'  : $('textarea[name=message]').val()
        };
        $.ajax({
          url : "<?php echo $base_url; ?>" + "/contact-us/mail.php",
          type: "POST",
          data : formData,
          success: function(data, textStatus, jqXHR)
          {
            $('#status').text(data.message);
            if (data.code) //If mail was sent successfully, reset the form.
            $('#contact-form').closest('form').find("input[type=text], textarea").val("");
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            $('#status').text(jqXHR);
          }
        });
      }
      </script>
    </main>
<?php
include template('footer');
include template('service_worker');
?>
    <script>
    manipulateAjax();
    </script>
  </body>
</html>