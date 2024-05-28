<?php
error_reporting(-1);
ini_set('display_errors', 'On');
ini_set('max_execution_time', 0);
set_time_limit(0);
require __DIR__.'/prep.inc.php';
//$base_url = 'http://localhost/bio';
$base_url = 'http://localhost:41076/www/';
$default_dt = new DateTime('now', new DateTimezone(date_default_timezone_get()));
$p = isset($_GET['p']) ? prevent_xss($_GET['p']): 'home';
$q = isset($_GET['q']) ? prevent_xss($_GET['q']): "";
$dob = isset($_GET['dob']) ? prevent_xss($_GET['dob']): (isset($_COOKIE['BIO:remembered_dob']) ? $_COOKIE['BIO:remembered_dob']: $default_dt->format('Y-m-d'));
$embed = isset($_GET['embed']) ? prevent_xss($_GET['embed']): 0;
//$lang_code = init_lang_code();
$lang_code = 'en';
$keywords = "biorhythm,biorhythms,biorhythm.xyz";
$og_title = "This is a Biorhythm Calculator";
$og_desc = "This is a Biorhythm Calculator. Use this tool to get to know more about yourself. To use, pick a Date using our Date Picker, the date format is YYYY-MM-DD (year-month-day). Then click `Run` to know your physical, emotional, and intellectual values. If you only care about Sleep Rhythm, you can ignore this form.";
$article_tag = "biorhythm";
$bmi_title = "This is a Body Mass Index Calculator";
$bmi_desc = "This is a Body Mass Index Calculator. Use this tool to know your Ideal Weight and Ideal Height.";
$time_zone = 6;
$system_mail = 'yourname@email.xyz';
$show_ad = false;
$show_donate = false;
$show_sponsor = false;
$show_addthis = false;
$show_sumome = false;
$hotjar = false;
$clicktale = false;
$smartlook = false;
$cdn_url = $base_url;
$number = calculate_life_path($dob);
if (isset($_GET['dob']) && isset($_GET['diff']) && isset($_GET['is_secondary']) && isset($_GET['dt_change']) && isset($_GET['partner_dob']) && isset($_GET['lang_code'])) {
	$chart = new Chart((string)$_GET['dob'],(int)$_GET['diff'],(int)$_GET['is_secondary'],(string)$_GET['dt_change'],(string)$_GET['partner_dob'],(string)$_GET['lang_code']);
} else {
	$chart = new Chart($dob,0,0,$default_dt->format('Y-m-d'),$dob,$lang_code);
}
$information_interfaces = array(
	'average' => array(
		'vi' => array(
			'excellent' => 'Xin chúc mừng bạn. Ngày hiện tại của bạn rất tốt, bạn nên tận hưởng ngày này.',
			'good' => 'Chúc mừng bạn. Ngày hiện tại của bạn khá tốt, tuy nhiên bạn không nên chủ quan trong ngày này.',
			'gray' => 'Chúc bạn một ngày tốt lành. Ngày hiện tại của bạn không được tốt lắm, bạn nên cẩn trọng hơn.',
			'bad' => 'Chúc bạn một ngày vui vẻ. Rất tiếc phải thông báo rằng ngày hiện tại của bạn hơi xấu, mong bạn cẩn thận.'
		),
		'en' => array(
			'excellent' => 'Your current day is excellent, enjoy it.',
			'good' => 'Your current day is quite good, you should take little care.',
			'gray' => 'Your current day is not good, you should take care of yourself.',
			'bad' => 'Your current day is bad, you should take a lot of care.'
		),
		'ru' => array(
			'excellent' => 'Ваш текущий день отлично, наслаждаться ею.',
			'good' => 'Ваш текущий день является достаточно хорошим, возьмите немного заботы.',
			'gray' => 'Ваш текущий день не очень хорошо, больше заботиться о себе.',
			'bad' => 'Ваш текущий день плохо, должно занять много ухода.'
		),
		'es' => array(
			'excellent' => 'Su día actual es excelente, que lo disfruten.',
			'good' => 'Su día actual es bastante buena, tomar un poco de cuidado.',
			'gray' => 'Su día actual no es bueno, tener más cuidado de ti mismo.',
			'bad' => 'Su día actual es mala, hay que tener mucho cuidado.'
		),
		'zh' => array(
			'excellent' => '您当前的一天是优秀的，享受它。',
			'good' => '您当前的一天是相当不错的，需要一点点的关心。',
			'gray' => '您当前的日子是不好的，把自己的更多的关怀。',
			'bad' => '您当前的日子是不好的，应该采取大量的关怀。'
		),
		'ja' => array(
			'excellent' => 'あなたの現在の日が優れている、それを楽しむ。',
			'good' => '現在の日はかなり良いです、少し注意してください。',
			'gray' => '現在の日はよくない、自分のことをより多くの世話をする。',
			'bad' => 'あなたの現在の日が悪い、介護の多くを取る必要があります。'
		)
	),
	'physical' => array(
		'vi' => array(
			'excellent' => 'Sức khỏe hiện tại của bạn rất sung mãn, hãy tham gia vận động nhiều hơn, như vận động thể dục, thể thao, tham gia các cuộc vui, để tận dụng năng lượng nhé. Sức đề kháng của bạn rất cao nên đây có thể là lúc phát bệnh mà bạn đã ủ trong suốt thời gian vừa qua.',
			'good' => 'Sức khỏe hiện tại của bạn khá sung mãn, hãy vận động điều độ, như các hoạt động thể dục nhẹ nhàng nha bạn.',
			'critical' => 'Sức khỏe hiện tại của bạn đang rơi vào giai đoạn chuyển tiếp, bạn nên nghỉ ngơi nhiều lên nhé, do thể lực bạn đang biến đổi khó lường.',
			'gray' => 'Sức khỏe hiện tại của bạn hơi kém, hãy nghỉ ngơi một tí, do thể lực đã ở vào mức khá thấp, hãy tích trữ năng lượng để dành vào những lúc sung mãn nha.',
			'bad' => 'Sức khỏe hiện tại của bạn khá kém, hãy nghỉ ngơi nhiều hơn, bạn đã hoạt động nhiều rồi, thời gian này nên dành để ngủ đông nhé. Sức đề kháng của bạn lúc này khá kém nên đây có thể là thời gian ủ bệnh.'
		),
		'en' => array(
			'excellent' => 'Your current health is excellent, you should work out more, take part in sport events so as to make use of this full energy time. Your immune system at this time will be high so your illness will be discovered. But no worry, your body will have overcome it easily.',
			'good' => 'Your current health is quite good, you should work out with care because your health has slightly decreased.',
			'critical' => 'Your current health is in a critical period, you should be extremely careful because it is an unstable state in your health.',
			'gray' => 'Your current health is not good, take a little rest because your physical state is quite low. You should save you energy for use in hyper states.',
			'bad' => 'Your current health is bad, take more rest, as you have worked out a lot, this time is for resting.'
		),
		'ru' => array(
			'excellent' => 'Ваше текущее здоровье отличное, вы должны работать больше.',
			'good' => 'Ваше текущее здоровье неплохое, вы должны работать с осторожностью.',
			'critical' => 'Ваше текущее здоровье в критический период, вы должны быть очень осторожны.',
			'gray' => 'Ваше текущее здоровье не хорошо, немного отдохнуть.',
			'bad' => 'Ваше текущее здоровье плохо, взять больше отдыхать.'
		),
		'es' => array(
			'excellent' => 'Su estado de salud actual es excelente, debe trabajar más.',
			'good' => 'Su estado de salud actual es bastante bueno, usted debe hacer ejercicio con cuidado.',
			'critical' => 'Su salud actual está en el período crítico , debe ser extremadamente cuidadoso.',
			'gray' => 'Su estado de salud actual no es buena, tomar un poco de descanso.',
			'bad' => 'Su estado de salud actual es mala, tener más descanso.'
		),
		'zh' => array(
			'excellent' => '您当前的健康是优秀的，你应该更多。',
			'good' => '您当前的健康是相当不错的，你应该制定出谨慎。',
			'critical' => '您当前的健康是关键时期，你应该非常小心。',
			'gray' => '你目前的身体不好，需要一点休息。',
			'bad' => '您当前的健康是不好的，需要更多的休息。'
		),
		'ja' => array(
			'excellent' => 'あなたの現在の健康状態が優れている、あなたはより多くを動作するはずです。',
			'good' => 'あなたの現在の健康状態はかなり良いですが、あなたが注意して動作するはずです。',
			'critical' => 'あなたの現在の健康状態は、臨界期に、あなたは非常に慎重であるべきです。',
			'gray' => 'あなたの現在の健康状態が良くない、少し休憩を取る。',
			'bad' => 'あなたの現在の健康状態が悪いと、より多くの休息を取る。'
		)
	),
	'emotional' => array(
		'vi' => array(
			'excellent' => 'Tâm trạng hiện tại của bạn rất ổn, hãy tham gia gặp gỡ bạn bè nhiều hơn, dành thời gian hẹn hò, đi chơi với những người thân yêu của mình để tận dụng lúc cảm xúc đang thăng hoa bạn nhé.',
			'good' => 'Tâm trạng hiện tại của bạn khá ổn, hãy gặp gỡ bạn bè, người thân, nhưng cũng chú ý tránh những xung đột nhỏ để cho cuộc vui được trọn vẹn nha bạn.',
			'critical' => 'Tâm trạng hiện tại của bạn đang rơi vào giai đoạn chuyển giao, hãy chú ý nhiều đến cảm xúc của mình, do đây là lúc cảm xúc thay đổi khó lường.',
			'gray' => 'Tâm trạng hiện tại của bạn hơi tệ, bạn hơi dễ cáu kỉnh, dễ cãi nhau, vì thế, bạn nên tìm đến những góc nhỏ cho riêng mình, để tĩnh tâm lại bạn nhé.',
			'bad' => 'Tâm trạng hiện tại của bạn khá tệ, bạn nên tránh các cuộc xung đột, cãi vã, vì lúc này điều đó rất dễ xảy ra. Bạn nên dành thời gian ở một mình, khoảng thời gian này sẽ qua mau thôi.'
		),
		'en' => array(
			'excellent' => 'Your current mood is excellent, you should meet more friends, spend time dating, go out with your beloved ones.',
			'good' => 'Your current mood is quite good, you should meet some friends and avoid some arguments so as to have happy moments together.',
			'critical' => 'Your current mood is in a critical period, you should pay more attention to your feelings because this is the unstable state in your mood.',
			'gray' => 'Your current mood is not good, you are easily annoyed. You should spend more time alone to calm your mood',
			'bad' => 'Your current mood is bad, avoid conflicts as they will occur more. Spend time alone and hope that this time will not last long.'
		),
		'ru' => array(
			'excellent' => 'Ваше текущее настроение отличное, вы встретите больше друзей.',
			'good' => 'Ваше текущее настроение неплохое, вы должны встретиться с друзьями.',
			'critical' => 'Ваше текущее настроение в критический период, вы должны уделять больше внимания на ваши чувства.',
			'gray' => 'Ваше текущее настроение не очень хорошо, вы легко раздражаться.',
			'bad' => 'Ваше текущее настроение плохое, во избежание конфликтов.'
		),
		'es' => array(
			'excellent' => 'Su estado de ánimo actual es excelente, te encuentras con más amigos.',
			'good' => 'Su estado de ánimo actual es bastante buena, usted debe cumplir con algunos amigos.',
			'critical' => 'Su estado de ánimo actual está en el período crítico, se debe prestar más atención a sus sentimientos.',
			'gray' => 'Su estado de ánimo actual no es bueno, ustedes son fácilmente molesto.',
			'bad' => 'Su estado de ánimo actual es mala, evitar conflictos.'
		),
		'zh' => array(
			'excellent' => '你现在的心情非常好，你认识更多的朋友。',
			'good' => '你现在的心情是相当不错的，你应该满足一些朋友。',
			'critical' => '您现在的心情是关键时期，你应该更加注意你的感受。',
			'gray' => '你现在的心情不是很好，你很容易生气。',
			'bad' => '你现在的心情不好，避免冲突。'
		),
		'ja' => array(
			'excellent' => 'あなたの現在の気分が優れている、あなたはより多くの友人に会う。',
			'good' => 'あなたの現在の気分はかなり良いですが、あなたは何人かの友人を満たしている必要があります。',
			'critical' => 'あなたの現在の気分は、臨界期に、あなたはあなたの気持ちにもっと注意を払う必要があります。',
			'gray' => 'あなたの現在の気分が良くない、あなたは簡単にイライラです。',
			'bad' => 'あなたの現在の気分が悪い、競合を避ける。'
		)
	),
	'intellectual' => array(
		'vi' => array(
			'excellent' => 'Trí tuệ hiện tại của bạn rất sáng suốt, bạn có thể đưa ra những quyết định đúng đắn, có những suy nghĩ rất chính xác, hợp lý.',
			'good' => 'Trí tuệ hiện tại của bạn khá sáng suốt, bạn có thể đưa ra quyết định nhưng cần suy tính kỹ, bởi vì suy nghĩ của bạn chưa đạt độ chính xác cao nhất có thể.',
			'critical' => 'Trí tuệ hiện tại của bạn đang ở trong giai đoạn chuyển biến, bạn nên chú ý kỹ hơn đến suy nghĩ của mình, vì nó có thể dẫn đến những quyết định sai lầm.',
			'gray' => 'Trí tuệ hiện tại của bạn hơi thiếu sáng suốt, bạn nên suy nghĩ kỹ trước khi ra quyết định. Nếu cần thiết, hãy hỏi thêm ý kiến của người thân, bạn bè, đồng nghiệp.',
			'bad' => 'Trí tuệ hiện tại của bạn khá thiếu sáng suốt, bạn không nên đưa ra quyết định lớn. Nếu phải ra quyết định, bạn nhất định nên hỏi ý kiến người khác.'
		),
		'en' => array(
			'excellent' => 'Your current intellect is excellent, you can make great decisions, think logically and precisely.',
			'good' => 'Your current intellect is quite good, you can make decisions with little care.',
			'critical' => 'Your current intellect is in a critical period, you should pay extra attention to your thoughts as it may lead to wrong decisions.',
			'gray' => 'Your current intellect is not good, you should think twice before making decisions.',
			'bad' => 'Your current intellect is bad, you should not make big decisions.'
		),
		'ru' => array(
			'excellent' => 'Ваше текущее интеллект отлично, вы можете сделать большие решения.',
			'good' => 'Ваше текущее интеллект является достаточно хорошим, вы можете принимать решения с особого ухода.',
			'critical' => 'Ваше текущее интеллект в критический период, следует обратить особое внимание на ваши мысли, так как это может привести к неправильным решениям.',
			'gray' => 'Ваше текущее интеллект не является хорошим, вы должны подумать дважды, прежде чем принимать решения.',
			'bad' => 'Ваше текущее интеллект плохо, вы не должны делать большие решения.'
		),
		'es' => array(
			'excellent' => 'Su intelecto actual es excelente, puedes tomar grandes decisiones.',
			'good' => 'Su intelecto actual es bastante buena, se puede tomar decisiones con un poco de cuidado.',
			'critical' => 'Su intelecto actual está en período crítico, se debe prestar especial atención a sus pensamientos, ya que puede conducir a decisiones equivocadas.',
			'gray' => 'Su intelecto actual no es buena, usted debe pensar dos veces antes de tomar decisiones.',
			'bad' => 'Su intelecto actual es mala, no debe tomar decisiones importantes.'
		),
		'zh' => array(
			'excellent' => '您当前的智力是优秀的，你可以做出伟大的决定。',
			'good' => '您当前的智力是相当不错的，你可以用一点点小心做出决定。',
			'critical' => '您当前的智力是关键时期，你要格外注意你的想法，因为这可能会导致错误的决策。',
			'gray' => '您当前的智力不好，你做决策前，应三思而后行。',
			'bad' => '您当前的智力是坏的，你不应该做出重大的决定。'
		),
		'ja' => array(
			'excellent' => 'あなたの現在の知性は、あなたは偉大な決定を行うことができ、優れたものである。',
			'good' => 'あなたの現在の知性はかなり良いですが、あなたは少し注意して意思決定を行うことができます。',
			'critical' => 'それは間違った意思決定につながる可能性としてあなたの現在の知性は、臨界期に、あなたは、あなたの考えに特別な注意を払う必要がありますされています。',
			'gray' => 'あなたの現在の知性はあなたが意思決定をする前に二度考える必要があり、良いではありません。',
			'bad' => 'あなたの現在の知性は、あなたは大きな意思決定を行うべきではない、悪いです。'
		)
	)
);