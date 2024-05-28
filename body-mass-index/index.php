<?php
error_reporting(-1);
ini_set('display_errors', 'On');
$basepath = realpath($_SERVER['DOCUMENT_ROOT']);
$basepath = __DIR__;
$template_path = $basepath.'/templates/';
require $basepath.'/../inc/template.inc.php';
require $basepath.'/../inc/init.inc.php';
$sub = 'bmi';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="UTF-8">
  <title>Body Mass Index - Biorhythm</title>
<?php
include template('head.bmi');
include template('ga');
?>
  </head>
  <body class="bmi" data-href="<?php echo base_url(); ?>/body-mass-index/">
<?php
include template('header');
?>
    <main class="main">
      <div class="container-fluid bmi px-0">
        <div class="container p-5">
          <h2 class="h1-responsivefooter text-center my-4">Body Mass Index</h2>
          <div class="row">
            <div id="bmi_app" data-ng-app="bmiApp" data-ng-controller="bmiController" class="mx-auto w-100 shadow-lg rounded">
              <input id="bmi_lang" type="hidden" data-ng-model="language" value="<?php echo $lang_code; ?>">
              <div class="input-group">
                <div class="input-group-prepend col-4 col-xl-3 col-lg-3 col-md-4 col-sm-4 px-0">
                  <span class="input-group-text w-100">Weight</span>
                </div>
                <input class="form-control col-4 col-xl-6 col-lg-6 col-md-5 col-sm-5" pattern="\d*" id="weight" type="number" min="25" max="300" step="1" placeholder="84" data-ng-model="weight" required="required" >
                <div class="input-group-append col-4 col-xl-3 col-lg-3 col-md-3 col-sm-3 px-0">
                  <span class="input-group-text w-100">KG</span>
                </div>
              </div>
              <div class="input-group">
                <div class="input-group-prepend col-4 col-xl-3 col-lg-3 col-md-4 col-sm-4 px-0">
                  <span class="input-group-text w-100">Height</span>
                </div>
                <input class="form-control col-4 col-xl-6 col-lg-6 col-md-5 col-sm-5" pattern="\d*" id="height" type="number" min="100" max="300" step="1" placeholder="184" data-ng-model="height" required="required" >
                <div class="input-group-append col-4 col-xl-3 col-lg-3 col-md-3 col-sm-3 px-0">
                  <span class="input-group-text w-100">CM</span>
                </div>
              </div>
              <div class="input-group">
                <div class="input-group-prepend col-12 col-xl-3 col-lg-3 col-md-4 col-sm-12 px-0">
                  <span class="input-group-text w-100">BMI value</span>
                </div>
                <input type="text" class="form-control col-12 col-xl-9 col-lg-9 col-md-8 col-sm-12" disabled value="{{bmiValue()}}">
              </div>
              <div class="input-group">
                <div class="input-group-prepend col-12 col-xl-3 col-lg-3 col-md-4 col-sm-12 px-0">
                  <span class="input-group-text w-100">Explanation</span>
                </div>
                <input type="text" class="form-control col-12 col-xl-9 col-lg-9 col-md-8 col-sm-12" disabled value="{{bmiExplanation()}}">
              </div>
              <div class="input-group">
                <div class="input-group-prepend col-12 col-xl-3 col-lg-3 col-md-4 col-sm-12 px-0">
                  <span class="input-group-text w-100">Ideal Weight</span>
                </div>
                <input type="text" class="form-control col-12 col-xl-9 col-lg-9 col-md-8 col-sm-12" disabled value="{{idealWeight()}}">
              </div>
              <div class="input-group">
                <div class="input-group-prepend col-12 col-xl-3 col-lg-3 col-md-4 col-sm-12 px-0">
                  <span class="input-group-text w-100">Ideal Height</span>
                </div>
                <input type="text" class="form-control col-12 col-xl-9 col-lg-9 col-md-8 col-sm-12" disabled value="{{idealHeight()}}">
              </div>
              <div class="input-group">
                <div class="input-group-prepend col-12 col-xl-3 col-lg-3 col-md-4 col-sm-12 px-0">
                  <span class="input-group-text w-100">Recommendation</span>
                </div>
                <input type="text" class="form-control col-12 col-xl-9 col-lg-9 col-md-8 col-sm-12" disabled value="{{recommendation()}}">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container-fluid bmi-explanation px-0">
        <div class="container p-5">
          <h2 class="h1-responsivefooter text-center my-4">Explanation</h2>
          <div class="row">
            <p>The body mass index (BMI) or Quetelet index is a value derived from the mass (weight) and height of an individual. The BMI is defined as the body mass divided by the square of the body height, and is universally expressed in units of kg/m2, resulting from mass in kilograms and height in metres.</p>
            <p>The BMI may also be determined using a table or chart which displays BMI as a function of mass and height using contour lines or colours for different BMI categories, and which may use other units of measurement (converted to metric units for the calculation).</p>
            <p>The BMI is an attempt to quantify the amount of tissue mass (muscle, fat, and bone) in an individual, and then categorize that person as underweight, normal weight, overweight, or obese based on that value. That categorization is the subject of some debate about where on the BMI scale the dividing lines between categories should be placed. Commonly accepted BMI ranges are underweight: under 18.5 kg/m2, normal weight: 18.5 to 25, overweight: 25 to 30, obese: over 30.</p>
            <p>BMIs under 20.0 and over 25.0 have been associated with higher all-cause mortality, increasing risk with distance from the 20.0-25.0 range. The prevalence of overweight and obesity is the highest in the Americas and lowest in South East Asia. The prevalence of overweight and obesity in high income and upper middle income countries is more than double that of low and lower middle income countries.</p>
          </div>
        </div>
      </div>
<?php
include template('script.bmi');
?>
    </main>
<?php
include template('footer');
include template('service_worker');
?>
  </body>
</html>