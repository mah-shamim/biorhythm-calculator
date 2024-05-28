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
  <title>About Us - Biorhythm</title>
<?php
include template('head.about');
include template('ga');
?>
  </head>
  <body class="about" data-href="<?php echo base_url(); ?>/about-us/">
<?php
include template('header');
?>
    <main class="main">
      <div class="container-fluid about px-0">
        <div class="container p-5">
          <h2 class="h1-responsivefooter text-center my-4">About Us</h2>
          <div class="row">
            <p>A biorhythm (from Greek βίος - bios, "life" and ῥυθμός - rhuthmos, "any regular recurring motion, rhythm") is an attempt to predict various aspects of a person's life through simple mathematical cycles. Most scientists believe that the idea has no more predictive power than chance and consider the concept an example of pseudoscience.</p>
            <p>According to the theory of biorhythms, a person's life is influenced by rhythmic biological cycles that affect his or her ability in various domains, such as mental, physical and emotional activity. These cycles begin at birth and oscillate in a steady (sine wave) fashion throughout life, and by modeling them mathematically, it is suggested that a person's level of ability in each of these domains can be predicted from day to day. The theory is built on the idea that the biofeedback chemical and hormonal secretion functions within the body could show a sinusoidal behavior over time.</p>
            <p>Most biorhythm models use three cycles: a 23-day physical cycle, a 28-day emotional cycle, and a 33-day intellectual cycle. Although the 28-day cycle is the same length as the average woman's menstrual cycle and was originally described as a "female" cycle (see below), the two are not necessarily in any particular synchronization. Each of these cycles varies between high and low extremes sinusoidally, with days where the cycle crosses the zero line described as "critical days" of greater risk or uncertainty.</p>
            <p>In addition to the three popular cycles, various other cycles have been proposed, based on linear combination of the three, or on longer or shorter rhythms.</p>
            <h3 class="w-100">Calculation</h3>
            <p class="w-100">The equations for the cycles are:</p>
            <ul>
              <li>Physical: sin(2π t/23)</li>
              <li>Emotional: sin(2π t/28)</li>
              <li>Intellectual: sin(2π t/33)</li>
            </ul>
            <p class="w-100">Where t indicates the number of days since birth.</p>
            <p>Basic arithmetic shows that the simpler 23- and 28-day cycles repeats every 644 days (or 1-3/4 years), while the triple 23-, 28-, and 33-day cycles repeats every 21,252 days (or 58.2+ years).</p>
            <h3 class="w-100">History</h3>
            <p>The notion of periodic cycles in human fortunes is ancient; for instance, it is found in natal astrology and in folk beliefs about "lucky days". The 23- and 28-day rhythms used by biorhythmists, however, were first devised in the late 19th century by Wilhelm Fliess, a Berlin physician and patient of Sigmund Freud. Fliess believed that he observed regularities at 23- and 28-day intervals in a number of phenomena, including births and deaths. He labeled the 23-day rhythm "male" and the 28-day rhythm "female", matching the menstrual cycle.</p>
            <p>In 1904, psychology professor Hermann Swoboda claimed to have independently discovered the same cycles. Later, Alfred Teltscher, professor of engineering at the University of Innsbruck, came to the conclusion that his students' good and bad days followed a rhythmic pattern of 33 days. Teltscher believed that the brain's ability to absorb, mental ability, and alertness ran in 33-day cycles. One of the first academic researchers of biorhythms was also Estonian-born Nikolai Pärna, who published a book in German called Rhythm, Life and Creation in 1923.</p>
            <p>The practice of consulting biorhythms was popularized in the 1970s by a series of books by Bernard Gittelson, including Biorhythm — A Personal Science, Biorhythm Charts of the Famous and Infamous, and Biorhythm Sports Forecasting. Gittelson's company, Biorhythm Computers, Inc., made a business selling personal biorhythm charts and calculators, but his ability to predict sporting events was not substantiated.</p>
            <p>Charting biorhythms for personal use was popular in the United States during the 1970s; many places (especially video arcades and amusement areas) had a biorhythm machine that provided charts upon entry of date of birth. Biorhythm charts were common in newspapers, usually found with horoscopes, at the time as well. Biorhythm programs were a common application on personal computers; and in the late 1970s, there were also handheld biorhythm calculators on the market, the Kosmos 1 and the Casio Biolator. Though biorhythms have declined in popularity, there are numerous websites on the Internet that offer free biorhythm readings. In addition, there exist free and proprietary software programs that offer more advanced charting and analysis capabilities.</p>
          </div>
        </div>
      </div>
<?php
include template('script.about');
?>
    </main>
<?php
include template('footer');
include template('service_worker');
?>
  </body>
</html>