<?php
error_reporting(-1);
ini_set('display_errors', 'On');
header("Expires: Mon, 29 Jan 1990 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
$basepath = __DIR__;
$template_path = $basepath.'/templates/';
require $basepath.'/inc/template.inc.php';
require $basepath.'/inc/init.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="UTF-8">
  <title>Home - Biorhythm</title>
<?php
include template('head.home');
include template('ga');
?>
  </head>
  <body class="home" data-href="<?php echo base_url(); ?>/">
<?php
include template('header');
?>
    <input type="hidden" id="baseUrl" value="<?php echo $base_url; ?>" />
    <main class="main">
      <div class="container-fluid hero px-0">
        <div class="container">
          <div class="row mx-auto py-5 px-3">
            <div class="hero-box mx-auto w-75 shadow-lg rounded">
              <ul class="nav nav-tabs rounded-top">
                <li class="active rounded-top"><a class="rounded-top" data-toggle="tab" href="#calculate">Calculate Biorhythm</a></li>
                <li class="rounded-top"><a data-disable-interaction="true" data-step="2" data-intro="Choose this item to find out your sleep cycles" class="rounded-top" data-toggle="tab" href="#sleep_time">Sleep Rhythm</a></li>
                <li class="rounded-top"><a href="#compatibility">Compatibility</a></li>
              </ul>
              <div class="tab-content p-4">
                <section id="calculate" class="tab-pane fade in show active">
                  <form class="form-inline mb-3" id="dob-form" action="<?php echo $base_url; ?>/#result">
                    <label class="sr-only" for="dob">Date of Birth</label>
                    <input data-toggle="tooltip" data-placement="top" data-original-title="Format: YYYY-MM-DD" data-disable-interaction="true" data-step="1" data-intro="Pick a Date with the order year, month, and day. Click `Run` to start calculating your biorhythms." type="text" pattern="\d{4}-\d{2}-\d{2}" class="form-control mb-2 mr-sm-2 col-12 col-xl-5 col-lg-5 col-md-4 col-sm-12" name="dob" id="dob" placeholder="Date of Birth" required="required" value="<?php echo $dob; ?>" data-date-start-view="decade">
                    <a data-toggle="tooltip" data-placement="top" data-original-title="Click to start" class="btn btn-warning mb-2 mr-xl-2 mr-lg-2 mr-md-2 col-12 col-xl-2 col-lg-2 col-md-2 col-sm-12" onclick="submitDob()">Run</a>
                    <a data-toggle="tooltip" data-placement="top" data-original-title="Click to take a tour" class="btn btn-info mb-2 col-12 col-xl-4 col-lg-4 col-md-5 col-sm-12" id="how-to-use">How to use</a>
                    <button type="submit" class="d-none"></button>
                  </form>
                  <p class="desc my-0">This is a <b>Biorhythm Calculator</b>. Use this tool to get to know more about yourself. To use, pick a Date using our Date Picker, the date format is <b>YYYY-MM-DD</b> (year-month-day). Then click "Run" to know your <b>physical, emotional, and intellectual</b> values. If you only care about <b>Sleep Rhythm</b>, you can ignore this form.</p>
                </section>
                <section id="sleep_time" class="tab-pane fade">
                  <p>If you plan to get up at</p>
                  <div class="row p-3">
                    <select id="sleep_time_hour" class="custom-select col-12 col-xl-5 col-lg-5 col-md-5 col-sm-12 mb-2 mr-xl-2 mr-lg-2 mr-md-2">
                      <option>Select hour</option>
                      <option>0</option>
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                      <option>6</option>
                      <option>7</option>
                      <option>8</option>
                      <option>9</option>
                      <option>10</option>
                      <option>11</option>
                      <option>12</option>
                      <option>13</option>
                      <option>14</option>
                      <option>15</option>
                      <option>16</option>
                      <option>17</option>
                      <option>18</option>
                      <option>19</option>
                      <option>20</option>
                      <option>21</option>
                      <option>22</option>
                      <option>23</option>
                      <option>24</option>
                    </select>
                    <select id="sleep_time_minute" class="custom-select col-12 col-xl-5 col-lg-5 col-md-5 col-sm-12 mb-2 ml-xl-2 ml-lg-2 ml-md-2">
                      <option>Select minute</option>
                      <option>00</option>
                      <option>05</option>
                      <option>10</option>
                      <option>15</option>
                      <option>20</option>
                      <option>25</option>
                      <option>30</option>
                      <option>35</option>
                      <option>40</option>
                      <option>45</option>
                      <option>50</option>
                      <option>55</option>
                    </select>
                  </div>
                  <div>
                    <p>You should try to fall asleep at one of the following times:</p>
                    <span id="sleep_time_results">
                      <ul>
                        <li>N/A</li>
                      </ul>
                    </span>
                  </div>
                  <p>Or if you want to sleep right now</p>
                  <a class="btn btn-warning mb-2" id="sleep_now"><i class="fas fa-bed"></i> Sleep now</a>
                  <div>
                    <p>You should try to get up at one of the following times:</p>
                    <span id="wake_up_time_results">
                      <ul>
                        <li>N/A</li>
                      </ul>
                    </span>
                  </div>
                </section>
              </div>
            </div>
<?php
include template('script.home');
?>
            <script>
            function isDate(txtDate) {
              var currVal = txtDate;
              if (currVal === '') {
                return false;
              }
              var rxDatePattern = /^(\d{4})(-)(\d{1,2})(-)(\d{1,2})$/; //Declare Regex
              var dtArray = currVal.match(rxDatePattern); // is format OK?

              if (dtArray === null) {
                return false;
              }
              dtMonth = dtArray[3];
              dtDay= dtArray[5];
              dtYear = dtArray[1];    

              if (dtMonth < 1 || dtMonth > 12) {
                return false;
              } else if (dtDay < 1 || dtDay> 31) {
                return false;
              } else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31) {
                return false;
              } else if (dtMonth == 2) {
                var isleap = (dtYear % 4 === 0 && (dtYear % 100 !== 0 || dtYear % 400 === 0));
                if (dtDay> 29 || (dtDay ==29 && !isleap)) {
                  return false;
                }
              }
              return true;
            }
            function countChar(string, character) {
              var charRegex = new RegExp(character, 'g');
              return (string.match(charRegex)||[]).length;
            }
            function maskInput(input, textbox, location, delimiter) {
              //Get the delimiter positons
              var locs = location.split(',');
              var locsLength = locs.length;
              var inputLength = input.length;
              //Iterate until all the delimiters are placed in the textbox
              for (var delimCount = 0; delimCount <= locsLength; ++delimCount) {
                for (var inputCharCount = 0; inputCharCount <= inputLength; ++inputCharCount) {
                  //Check for the actual position of the delimiter
                  if (inputCharCount == locs[delimCount]) {
                    //Confirm that the delimiter is not already present in that position
                    if (input.substring(inputCharCount, inputCharCount + 1) != delimiter) {
                      input = input.substring(0, inputCharCount) + delimiter + input.substring(inputCharCount, input.length);
                    }
                  }
                }
              }
              textbox.val(input);
            }
            function maskField(selector) {
              jQuery(selector).on('keypress', function(e) {
                if (e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40 && e.keyCode != 46 && countChar(jQuery(selector).val(), '-') < 2) {
                  maskInput(jQuery(selector).val(),jQuery(selector),'4,7','-');
                }
              }).on('keyup', function(e) {
                if (e.which != 8 && e.which != 37 && e.which != 38 && e.which != 39 && e.which != 40 && e.which != 46 && countChar(jQuery(selector).val(), '-') < 2) {
                  maskInput(jQuery(selector).val(),jQuery(selector),'4,7','-');
                }
              }).on('keydown', function(e) {
                if (e.which != 8 && e.which != 37 && e.which != 38 && e.which != 39 && e.which != 40 && e.which != 46 && countChar(jQuery(selector).val(), '-') < 2) {
                  maskInput(jQuery(selector).val(),jQuery(selector),'4,7','-');
                }
              });
            }
            function disableHyphen(fieldName) {
              jQuery('#'+fieldName).on('keypress', function(e) {
                if (e.which == 45) {
                  return false;
                }
              }).on('keyup', function(e) {
                if (e.which == 189 || e.which == 173 || e.which == 109) {
                  return false;
                }
              }).on('keydown', function(e) {
                if (e.which == 189 || e.which == 173 || e.which == 109) {
                  return false;
                }
              });
            }
            function maskDob() {
              maskField('#dob');
            }
            maskDob();
            disableHyphen('dob');
            function submitDob() {
              if (!isEmpty('#dob')) {
                Cookies.set('BIO:remembered_dob', $('#dob').val());
              }
              $('#dob-form').find('[type="submit"]').trigger('click');
            }
            $('#dob-form').on({
              keypress: function(e) {
                if (e.keyCode == 13 || e.which == 13) {
                  submitDob();
                }
              },
              keyup: function(e) {
                if (e.which == 13) {
                  submitDob();
                }
              },
              keydown: function(e) {
                if (e.which == 13) {
                  submitDob();
                }
              }
            }, '#dob');
            $('#dob').datepicker({
              format: 'yyyy-mm-dd',
              defaultViewDate: '<?php echo ($dob != '') ? date('Y-m-d',strtotime($dob)): '1961-09-26'; ?>',
              endDate: '<?php echo date('Y-m-d'); ?>',
              autoclose: true,
              immediateUpdates: true,
              todayHighlight: true,
              todayBtn: true,
              orientation: 'bottom'
            }).attr('readonly','readonly');
            $('.nav-tabs li a').each(function(){
              $(this).on('click', function(){
                $('.nav-tabs li').removeClass('active');
                if ($(this).parent('li').hasClass('active')) {
                  $(this).parent('li').removeClass('active');
                } else if (!$(this).parent('li').hasClass('active')) {
                  $(this).parent('li').removeClass('active').addClass('active');
                }
              })
            });
            $('#how-to-use').on('click', function(){
              introJs().setOptions({"nextLabel": "Next", "prevLabel": "Back", "skipLabel": "Skip", "doneLabel": "Done", "showProgress": true, "showButtons": true, "showBullets": true, "exitOnOverlayClick": false, "hidePrev": true, "hideNext": true, "disableInteraction": true}).start();
            });
            $(function () {
              if (!Modernizr.touch) {
                $('[data-toggle="tooltip"]').tooltip();
              }
            })
            </script>
            <div id="proverb" class="w-75 mx-auto my-1">
<?php
render_proverb('en');
?>
            </div>
          </div>
        </div>
      </div>
      <div id="result"></div>
      <div class="container-fluid chart px-0">
        <div class="container mx-auto px-0">
          <div class="row w-100 mx-auto py-5 px-0 position-relative" id="ajax-chart">
<?php
echo $chart->output_main_chart();
?>
          </div>
        </div>
      </div>
      <div class="container-fluid info px-0 border-top">
        <div class="container mx-auto px-0">
          <div class="row w-100 mx-auto p-5" id="ajax-info">
<?php
echo $chart->output_info();
?>
          </div>
        </div>
      </div>
      <div id="compatibility"></div>
      <div class="container-fluid compat px-0 border-top">
        <div class="container mx-auto px-0">
          <div class="row w-100 mx-auto py-5 px-0">
            <div class="px-5 w-100">
              <h2 class="mb-4">Compatibility with your friends</h2>
              <section class="rhythms" data-disable-interaction="true" data-step="12" data-intro="How compatible are you and your friends? Choose the Date of birth for you two.">
                <article class="rhythm physical" title="Physical: 100%">
                  <h3>Physical</h3>
                  <div class="percent">100%</div>
                  <div class="percentage">
                    <div class="percentage-bar"></div>
                  </div>
                </article>
                <article class="rhythm emotional" title="Emotional: 100%">
                  <h3>Emotional</h3>
                  <div class="percent">100%</div>
                  <div class="percentage">
                    <div class="percentage-bar"></div>
                  </div>
                </article>
                <article class="rhythm intellectual" title="Intellectual: 100%">
                  <h3>Intellectual</h3>
                  <div class="percent">100%</div>
                  <div class="percentage">
                    <div class="percentage-bar"></div>
                  </div>
                </article>
                <article class="rhythm average" title="Average: 100%">
                  <h3>Average</h3>
                  <div class="percent">100%</div>
                  <div class="percentage">
                    <div class="percentage-bar"></div>
                  </div>
                </article>
              </section>
            </div>
            <form class="dates mx-auto" id="date-input">
              <div class="date shadow-lg rounded" data-disable-interaction="true" data-step="13" data-intro="Choose your birthday">
                <select name="yyyy" data-original-title="Year" class="custom-select" data-toggle="tooltip" data-placement="top"><option value="">Year</option></select>
                -
                <select name="mm" data-original-title="Month" class="custom-select" data-toggle="tooltip" data-placement="top"><option value="">Month</option></select>
                -
                <select name="dd" data-original-title="Day" class="custom-select" data-toggle="tooltip" data-placement="top"><option value="">Day</option></select>
              </div>
              <span class="separator">+</span>
              <div class="date shadow-lg rounded" data-disable-interaction="true" data-step="14" data-intro="Choose your friend's birthday">
                <select name="yyyy2" data-original-title="Year" class="custom-select" data-toggle="tooltip" data-placement="top"><option value="">Year</option></select>
                -
                <select name="mm2" data-original-title="Month" class="custom-select" data-toggle="tooltip" data-placement="top"><option value="">Month</option></select>
                -
                <select name="dd2" data-original-title="Day" class="custom-select" data-toggle="tooltip" data-placement="top"><option value="">Day</option></select>
              </div>
            </form>
            <script>
            function daysInMonth(month, year) {
              return new Date(year, month, 0).getDate();
            }
            function updateDays(year, month, day) {
              $(year + ', ' + month).on('change', function() {
                if ($(year).val().length > 0 && $(month).val().length > 0) {
                  $(day).prop('disabled', false);
                  $(day).find('option').remove();
                  var daysInSelectedMonth = daysInMonth($(month).val(), $(year).val());
                  for (var i = 1; i <= daysInSelectedMonth; i++) {
                    i = ('0' + i).slice(-2);
                    $(day).append($("<option></option>").attr("value", i).text(i));
                  }
                }
              });
            }
            </script>
            <script src="<?php echo $cdn_url; ?>/static/js/compat.js"></script>
            <script>
            updateDays('select[name="yyyy"]','select[name="mm"]','select[name="dd"]');
            updateDays('select[name="yyyy2"]','select[name="mm2"]','select[name="dd2"]');
            </script>
          </div>
        </div>
      </div>
    </main>
<?php
include template('footer');
include template('service_worker');
?>
    <script>
    manipulateHome();
    manipulateEnd();
    </script>
  </body>
</html>