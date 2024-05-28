<?php
header("Expires: Mon, 29 Jan 1990 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
class Chart {
	protected $_dob, $_diff, $_date, $_is_secondary, $_dt_change, $_lang_code, $_partner_dob, $_rhythms_count,  $_dates_count, $_today_index, $_title_text, $_explanation_title_text, $_percentage_text, $_average_text, $_physical_text, $_emotional_text, $_intellectual_text, $_full_screen_text, $_download_jpeg_text, $_download_pdf_text, $_download_png_text, $_download_svg_text, $_print_chart_text, $_reset_zoom_text, $_date_text, $_life_path_text, $_age, $_news_h5, $_info_h5, $_statistics_h5, $_compatibility_h5, $_lunar_h5, $_controls_h5, $_dates_json, $_rhythms_json, $_fullname, $_intro_info, $_intro_chart, $_chart_today, $_chart_birthday, $_chart_prev, $_chart_next, $_chart_prev_week, $_chart_next_week, $_dt_change_label;
	protected $_rhythms = array();
	protected $_days = array();
	protected $_dates = array();
	protected $_is_registered = false;

	function __construct(string $dob,int $diff,int $is_secondary,string $dt_change,string $partner_dob,string $lang_code) {
		global $lang_codes;
		$this->_dob = $dob;
		$this->_partner_dob = isset($partner_dob) ? $partner_dob: $dob;
		$this->_diff = $diff;
		$this->_date = date('Y-m-d', time()+86400*$this->_diff);
//		$this->_lang_code = in_array($lang_code, $lang_codes) ? $lang_code: 'vi';
		$this->_lang_code = $lang_code;
		$this->_is_secondary = $is_secondary;
//		$this->_dt_change = isset($dt_change) ? $dt_change: $this->_date;
		$this->_dt_change = isset($dt_change) ? $dt_change: date('Y-m-d');
		$this->_rhythms = array(
			'0' => array(
						'rid' => '1',
						'name_vi' => 'Sức khỏe',
						'name_en' => 'Physical',
						'scale' => '23'
					),
			'1' => array(
						'rid' => '2',
						'name_vi' => 'Tình cảm',
						'name_en' => 'Emotional',
						'scale' => '28'
					),
			'2' => array(
						'rid' => '3',
						'name_vi' => 'Trí tuệ',
						'name_en' => 'Intellectual',
						'scale' => '33'
					)
		);
		sort($this->_rhythms);
		for ($i = -14; $i <= 14; ++$i) {
			$j = $i + 14;
			$day = time()+86400*($i+$diff);
			$this->_days[$j] = date('d',$day);
			$this->_dates[$j] = date('Y-m-d',$day);
		}
		$this->_rhythms_count = count($this->_rhythms);
		$this->_dates_count = count($this->_dates);
		$this->_today_index = array_search(date('Y-m-d'),$this->_dates);
		$this->_dates_json = json_encode($this->_dates);
		$this->_rhythms_json = json_encode($this->_rhythms);
		switch ($this->_lang_code) {
			case 'vi':
				setlocale(LC_TIME, 'vi_VN');
				$this->_chart_today = 'Đi đến ngày hôm nay';
				$this->_chart_birthday = 'Đi đến ngày sinh nhật';
				$this->_chart_prev = 'Đi đến ngày trước đó';
				$this->_chart_next = 'Đi đến ngày kế tiếp';
        $this->_chart_prev_week = 'Đi đến tuần trước đó';
        $this->_chart_next_week = 'Đi đến tuần kế tiếp';
				$this->_title_text = 'Ngày sinh: ';
				$this->_intro_chart = 'Biểu đồ này được tạo ra từ Ngày sinh bạn đã nhập. Khám phá từng ngày bằng cách bấm vào ngày muốn xem.';
				$this->_intro_info = 'Ngày này bạn như thế nào? Tìm hiểu nào';
				$this->_explanation_title_text = 'Biểu đồ nhịp sinh học';
				$this->_percentage_text = 'Phần trăm';
				$this->_average_text = 'Trung bình';
        $this->_physical_text = $this->_rhythms['0']['name_vi'];
        $this->_emotional_text = $this->_rhythms['1']['name_vi'];
        $this->_intellectual_text = $this->_rhythms['2']['name_vi'];
				$this->_full_screen_text = 'Xem toàn màn hình';
				$this->_download_jpeg_text = 'Tải về tập tin JPEG';
				$this->_download_pdf_text = 'Tải về tập tin PDF';
				$this->_download_png_text = 'Tải về tập tin PNG';
				$this->_download_svg_text = 'Tải về tập tin SVG';
				$this->_print_chart_text = 'In biểu đồ';
				$this->_reset_zoom_text = 'Thiết lập lại';
				$this->_date_text = 'Ngày';
				$this->_life_path_text = 'con số cuộc đời '.calculate_life_path($this->_dob);
				$this->_age = 'tuổi';
				$this->_news_h5 = 'Tin tức';
				$this->_info_h5 = 'Lời khuyên cho '.(($this->_diff == 0) ? 'hôm nay': (($this->_diff == 1) ? 'ngày mai': (($this->_diff == -1) ? 'hôm qua': strftime('%A, %e %B, %Y', strtotime($this->_dt_change)))));
				$this->_statistics_h5 = 'Thống kê';
				$this->_compatibility_h5 = 'Độ hòa hợp với đối tác';
				$this->_lunar_h5 = 'Âm lịch';
				$this->_dt_change_label = 'Đổi ngày';
				if (date('m-d',time()+86400*$this->_diff) == date('m-d',strtotime($this->_dob))) {
					$this->_controls_h5 = 'Sinh nhật';
				} else if ($this->_diff == 0) {
					$this->_controls_h5 = 'Hôm nay';
				} else if ($this->_diff == 1) {
					$this->_controls_h5 = 'Ngày mai';
				} else if ($this->_diff == -1) {
					$this->_controls_h5 = 'Hôm qua';
				} else {
					$this->_controls_h5 = 'Ngày: '.$this->_date;
				}
				break;
			case 'en':
				$this->_chart_today = 'Go to today';
				$this->_chart_birthday = 'Go to the next birthday';
				$this->_chart_prev = 'Go to the previous day';
				$this->_chart_next = 'Go to the next day';
        $this->_chart_prev_week = 'Go to the previous week';
        $this->_chart_next_week = 'Go to the next week';
				$this->_title_text = 'Date of birth: ';
				$this->_intro_chart = 'This chart is created based on your Date of Birth. Discover the days by clicking on the day you want to see.';
				$this->_intro_info = 'How are you on this day? Find out here';
				$this->_explanation_title_text = 'Biorhythm chart';
				$this->_percentage_text = 'Percentage';
				$this->_average_text = 'Average';
        $this->_physical_text = $this->_rhythms['0']['name_en'];
        $this->_emotional_text = $this->_rhythms['1']['name_en'];
        $this->_intellectual_text = $this->_rhythms['2']['name_en'];
				$this->_full_screen_text = 'View in full screen';
				$this->_download_jpeg_text = 'Download JPEG file';
				$this->_download_pdf_text = 'Download PDF file';
				$this->_download_png_text = 'Download PNG file';
				$this->_download_svg_text = 'Download SVG file';
				$this->_print_chart_text = 'Print chart';
				$this->_reset_zoom_text = 'Reset zoom';
				$this->_date_text = 'Date';
				$this->_life_path_text = 'life path number '.calculate_life_path($this->_dob);
				$this->_age = pluralize(differ_year($this->_dob, $this->_date),'year').' old';
				$this->_news_h5 = 'News';
				$this->_info_h5 = 'Advice for '.(($this->_diff == 0) ? 'today': (($this->_diff == 1) ? 'tomorrow': (($this->_diff == -1) ? 'yesterday': strftime('%A, %B %e, %Y', strtotime($this->_dt_change)))));
				$this->_statistics_h5 = 'Statistics';
				$this->_compatibility_h5 = 'Compatibility';
				$this->_lunar_h5 = 'Lunar';
				$this->_dt_change_label = 'Change date';
				if (date('m-d',time()+86400*$this->_diff) == date('m-d',strtotime($this->_dob))) {
					$this->_controls_h5 = 'Birthday';
				} else if ($this->_diff == 0) {
					$this->_controls_h5 = 'Today';
				} else if ($this->_diff == 1) {
					$this->_controls_h5 = 'Tomorrow';
				} else if ($this->_diff == -1) {
					$this->_controls_h5 = 'Yesterday';
				} else {
					$this->_controls_h5 = 'Date: '.$this->_date;
				}
				break;
		}
	}
	function get_rhythm_name(array $rhythm): string {
		switch ($this->_lang_code) {
			case 'vi':
				return $rhythm['name_vi'];
				break;
			case 'en':
				return $rhythm['name_en'];
				break;
		}
	}
	function set_fullname(string $fullname): void {
		$this->_fullname = $fullname;
	}
	function set_registered(bool $is_registered): void {
		$this->_is_registered = $is_registered;
	}
	function serialize_chart_data(): string {
		$chart_data = '[{name:"'.$this->_average_text.'",data:[';
		for ($d = 0; $d < $this->_dates_count; ++$d) {
			$chart_data .= average_bio_count($this->_dob,$this->_dates[$d],$this->_rhythms);
			$chart_data .= ($d != ($this->_dates_count-1)) ? ',': "";
		}
		$chart_data .= '],lineWidth: 2},';
		for ($r = 0; $r < $this->_rhythms_count; ++$r) {
			$this->_rhythms[$r]['rhythm_name'] = $this->get_rhythm_name($this->_rhythms[$r]);
			$chart_data .= '{name:"'.$this->_rhythms[$r]['rhythm_name'].'",data:[';
			for ($d = 0; $d < $this->_dates_count; ++$d) {
				$chart_data .= bio_count($this->_dob,$this->_dates[$d],$this->_rhythms[$r]['scale']);
				$chart_data .= ($d != ($this->_dates_count-1)) ? ',': "";
			}
			$chart_data .= ']';
			$chart_data .= ($r != ($this->_rhythms_count-1)) ? '},': '}';
		}
		$chart_data .= ']';
		return $chart_data;
	}
	function get_infor(): string {
		global $information_interfaces;
		$average = (float)average_bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),$this->_rhythms);
		$physical = (float)bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),23);
		$emotional = (float)bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),28);
		$intellectual = (float)bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),33);
		$average_text = "";
		$physical_desc = "";
		$emotional_desc = "";
		$intellectual_desc = "";
		if ($average >= 75 && $average <= 100) {
			$average_text = $information_interfaces['average'][$this->_lang_code]['excellent'];
		} else if ($average >= 50 && $average < 75) {
			$average_text = $information_interfaces['average'][$this->_lang_code]['good'];
		} else if ($average >= 25 && $average < 50) {
			$average_text = $information_interfaces['average'][$this->_lang_code]['gray'];
		} else if ($average >= 0 && $average < 25) {
			$average_text = $information_interfaces['average'][$this->_lang_code]['bad'];
		}
		if ($physical >= 80 && $physical <= 100) {
			$physical_desc = $information_interfaces['physical'][$this->_lang_code]['excellent'];
		} else if ($physical >= 60 && $physical < 80) {
			$physical_desc = $information_interfaces['physical'][$this->_lang_code]['good'];
		} else if ($physical >= 40 && $physical < 60) {
			$physical_desc = $information_interfaces['physical'][$this->_lang_code]['critical'];
		} else if ($physical >= 20 && $physical < 40) {
			$physical_desc = $information_interfaces['physical'][$this->_lang_code]['gray'];
		} else if ($physical >= 0 && $physical < 20) {
			$physical_desc = $information_interfaces['physical'][$this->_lang_code]['bad'];
		}
		if ($emotional >= 80 && $emotional <= 100) {
			$emotional_desc = $information_interfaces['emotional'][$this->_lang_code]['excellent'];
		} else if ($emotional >= 60 && $emotional < 80) {
			$emotional_desc = $information_interfaces['emotional'][$this->_lang_code]['good'];
		} else if ($emotional >= 40 && $emotional < 60) {
			$emotional_desc = $information_interfaces['emotional'][$this->_lang_code]['critical'];
		} else if ($emotional >= 20 && $emotional < 40) {
			$emotional_desc = $information_interfaces['emotional'][$this->_lang_code]['gray'];
		} else if ($emotional >= 0 && $emotional < 20) {
			$emotional_desc = $information_interfaces['emotional'][$this->_lang_code]['bad'];
		}
		if ($intellectual >= 80 && $intellectual <= 100) {
			$intellectual_desc = $information_interfaces['intellectual'][$this->_lang_code]['excellent'];
		} else if ($intellectual >= 60 && $intellectual < 80) {
			$intellectual_desc = $information_interfaces['intellectual'][$this->_lang_code]['good'];
		} else if ($intellectual >= 40 && $intellectual < 60) {
			$intellectual_desc = $information_interfaces['intellectual'][$this->_lang_code]['critical'];
		} else if ($intellectual >= 20 && $intellectual < 40) {
			$intellectual_desc = $information_interfaces['intellectual'][$this->_lang_code]['gray'];
		} else if ($intellectual >= 0 && $intellectual < 20) {
			$intellectual_desc = $information_interfaces['intellectual'][$this->_lang_code]['bad'];
		}
		return '<p>'.$average_text.'</p><p>'.$physical_desc.'</p><p>'.$emotional_desc.'</p><p>'.$intellectual_desc.'</p>';
	}
	function get_birthday_countdown(): string {
		$birthday_countdown = "";
		switch ($this->_lang_code) {
			case 'vi':
				$birthday_countdown = 'Còn '.countdown_birthday($this->_dob, $this->_date).' ngày nữa là tới sinh nhật tiếp theo của bạn.';
				break;
			case 'en':
				$birthday_countdown = countdown_birthday($this->_dob, $this->_date).' '.pluralize(countdown_birthday($this->_dob, $this->_date),'day').' until your next birthday.';
				break;
		}
		return $birthday_countdown;
	}
	function get_infor_details(): string {
		global $information_interfaces;
		$average = (float)average_bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),$this->_rhythms);
		$physical = (float)bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),23);
		$emotional = (float)bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),28);
		$intellectual = (float)bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),33);
		$average_text = "";
		$physical_desc = "";
		$emotional_desc = "";
		$intellectual_desc = "";
		$average_status = "";
		$physical_status = "";
		$emotional_status = "";
		$intellectual_statust = "";
		$plus = '<i class="far fa-smile"></i> ';
		$extreme_plus = '<i class="fas fa-smile"></i> ';
		$minus = '<i class="far fa-frown"></i> ';
		$extreme_minus = '<i class="fas fa-frown"></i> ';
		$mark = '<i class="fas fa-exclamation-circle"></i> ';
		$hand_right = ' <i class="fas fa-arrow-right"></i>  ';
		$average_trend = '<i class="fas fa-level-'.((average_bio_count($this->_dob,date('Y-m-d',time()+86400*($this->_diff-1)),$this->_rhythms) < average_bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),$this->_rhythms)) ? 'up': 'down').'-alt"></i> ';
		$physical_trend = '<i class="fas fa-level-'.((bio_count($this->_dob,date('Y-m-d',time()+86400*($this->_diff-1)),23) < bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),23)) ? 'up': 'down').'-alt"></i> ';
		$emotional_trend = '<i class="fas fa-level-'.((bio_count($this->_dob,date('Y-m-d',time()+86400*($this->_diff-1)),28) < bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),28)) ? 'up': 'down').'-alt"></i> ';
		$intellectual_trend = '<i class="fas fa-level-'.((bio_count($this->_dob,date('Y-m-d',time()+86400*($this->_diff-1)),33) < bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),33)) ? 'up': 'down').'-alt"></i> ';
		if ($average >= 75 && $average <= 100) {
			$average_text = $extreme_plus.$average_trend.$information_interfaces['average'][$this->_lang_code]['excellent'];
			$average_status = ' bg-success';
		} else if ($average >= 50 && $average < 75) {
			$average_text = $plus.$average_trend.$information_interfaces['average'][$this->_lang_code]['good'];
			$average_status = '';
		} else if ($average >= 25 && $average < 50) {
			$average_text = $minus.$average_trend.$information_interfaces['average'][$this->_lang_code]['gray'];
			$average_status = ' bg-warning';
		} else if ($average >= 0 && $average < 25) {
			$average_text = $extreme_minus.$average_trend.$information_interfaces['average'][$this->_lang_code]['bad'];
			$average_status = ' bg-danger';
		}
		if ($physical >= 80 && $physical <= 100) {
			$physical_desc = $extreme_plus.$physical_trend.$information_interfaces['physical'][$this->_lang_code]['excellent'];
			$physical_status = ' bg-success';
		} else if ($physical >= 60 && $physical < 80) {
			$physical_desc = $plus.$physical_trend.$information_interfaces['physical'][$this->_lang_code]['good'];
			$physical_status = '';
		} else if ($physical >= 40 && $physical < 60) {
			$physical_desc = $mark.$physical_trend.$information_interfaces['physical'][$this->_lang_code]['critical'];
			$physical_status = ' bg-info';
		} else if ($physical >= 20 && $physical < 40) {
			$physical_desc = $minus.$physical_trend.$information_interfaces['physical'][$this->_lang_code]['gray'];
			$physical_status = ' bg-warning';
		} else if ($physical >= 0 && $physical < 20) {
			$physical_desc = $extreme_minus.$physical_trend.$information_interfaces['physical'][$this->_lang_code]['bad'];
			$physical_status = ' bg-danger';
		}
		if ($emotional >= 80 && $emotional <= 100) {
			$emotional_desc = $extreme_plus.$emotional_trend.$information_interfaces['emotional'][$this->_lang_code]['excellent'];
			$emotional_status = ' bg-success';
		} else if ($emotional >= 60 && $emotional < 80) {
			$emotional_desc = $plus.$emotional_trend.$information_interfaces['emotional'][$this->_lang_code]['good'];
			$emotional_status = '';
		} else if ($emotional >= 40 && $emotional < 60) {
			$emotional_desc = $mark.$emotional_trend.$information_interfaces['emotional'][$this->_lang_code]['critical'];
			$emotional_status = ' bg-info';
		} else if ($emotional >= 20 && $emotional < 40) {
			$emotional_desc = $minus.$emotional_trend.$information_interfaces['emotional'][$this->_lang_code]['gray'];
			$emotional_status = ' bg-warning';
		} else if ($emotional >= 0 && $emotional < 20) {
			$emotional_desc = $extreme_minus.$emotional_trend.$information_interfaces['emotional'][$this->_lang_code]['bad'];
			$emotional_status = ' bg-danger';
		}
		if ($intellectual >= 80 && $intellectual <= 100) {
			$intellectual_desc = $extreme_plus.$intellectual_trend.$information_interfaces['intellectual'][$this->_lang_code]['excellent'];
			$intellectual_status = ' bg-success';
		} else if ($intellectual >= 60 && $intellectual < 80) {
			$intellectual_desc = $plus.$intellectual_trend.$information_interfaces['intellectual'][$this->_lang_code]['good'];
			$intellectual_status = '';
		} else if ($intellectual >= 40 && $intellectual < 60) {
			$intellectual_desc = $mark.$intellectual_trend.$information_interfaces['intellectual'][$this->_lang_code]['critical'];
			$intellectual_status = ' bg-info';
		} else if ($intellectual >= 20 && $intellectual < 40) {
			$intellectual_desc = $minus.$intellectual_trend.$information_interfaces['intellectual'][$this->_lang_code]['gray'];
			$intellectual_status = ' bg-warning';
		} else if ($intellectual >= 0 && $intellectual < 20) {
			$intellectual_desc = $extreme_minus.$intellectual_trend.$information_interfaces['intellectual'][$this->_lang_code]['bad'];
			$intellectual_status = ' bg-danger';
		}
		//return '<p>'.$average_text.'</p><p>'.$physical_desc.day_of_rhythm($this->_dob,date('Y-m-d',time()+86400*$this->_diff),23).'</p><p>'.$emotional_desc.day_of_rhythm($this->_dob,date('Y-m-d',time()+86400*$this->_diff),28).'</p><p>'.$intellectual_desc.day_of_rhythm($this->_dob,date('Y-m-d',time()+86400*$this->_diff),33).'</p>';
		return '
		<p><strong><u>'.$this->_physical_text.':</u></strong> '.$physical.'%</p>
        <p> '.$physical_desc.'</p>
		<p>
			<div class="progress">
				<div class="progress-bar progress-bar-striped progress-bar-animated'.$physical_status.'" role="progressbar" aria-valuenow="'.$physical.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$physical.'%;">'.$physical.'%</div>
			</div>
		</p>
		<p><strong><u>'.$this->_emotional_text.':</u></strong> '.$emotional.'%</p>
        <p> '.$emotional_desc.'</p>
		<p>
			<div class="progress">
				<div class="progress-bar progress-bar-striped progress-bar-animated'.$emotional_status.'" role="progressbar" aria-valuenow="'.$emotional.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$emotional.'%;">'.$emotional.'%</div>
			</div>
		</p>
		<p><strong><u>'.$this->_intellectual_text.':</u></strong> '.$intellectual.'%</p>
        <p> '.$intellectual_desc.'</p>
		<p>
			<div class="progress">
				<div class="progress-bar progress-bar-striped progress-bar-animated'.$intellectual_status.'" role="progressbar" aria-valuenow="'.$intellectual.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$intellectual.'%;">'.$intellectual.'%</div>
			</div>
		</p>
        <p><strong><u>'.$this->_average_text.':</u></strong> '.$average.'%</p>
        <p> '.$average_text.'</p>
        <p>
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated'.$average_status.'" role="progressbar" aria-valuenow="'.$average.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$average.'%;">'.$average.'%</div>
            </div>
        </p>
		<p><i class="fas fa-birthday-cake"></i> '.$this->get_birthday_countdown().'</p>';
	}
	function get_infor_values(): string {
		global $email_interfaces;
		$infor_values = '<ul>';
		$infor_values .= '<li>'.$this->_average_text.$email_interfaces['colon'][$this->_lang_code].' '.percent_average_bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),$this->_rhythms).' - '.((average_bio_count($this->_dob,date('Y-m-d',time()+86400*($this->_diff-1)),$this->_rhythms) < average_bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),$this->_rhythms)) ? $email_interfaces['going_up'][$this->_lang_code]: $email_interfaces['going_down'][$this->_lang_code]).'</li>';
		foreach ($this->_rhythms as $rhythm) {
			$infor_values .= '<li>'.$this->get_rhythm_name($rhythm).$email_interfaces['colon'][$this->_lang_code].' '.percent_bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),$rhythm['scale']).((bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),$rhythm['scale']) == 0 || bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),$rhythm['scale']) == 100) ? "": ' - '.((bio_count($this->_dob,date('Y-m-d',time()+86400*($this->_diff-1)),$rhythm['scale']) < bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),$rhythm['scale'])) ? $email_interfaces['going_up'][$this->_lang_code]: $email_interfaces['going_down'][$this->_lang_code])).'</li>';
		}
		$infor_values .= '</ul>';
		return $infor_values;
	}
	function render_meta_description(): string {
		$meta_description = differ_year($this->_dob, $this->_date).' '.$this->_age;
		$meta_description .= ' - '.date('Y-m-d',time()+86400*$this->_diff).' -';
		foreach ($this->_rhythms as $rhythm) {
			$meta_description .= ' '.$this->get_rhythm_name($rhythm).' '.percent_bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),$rhythm['scale']);
		}
		return $meta_description;
	}
	// Render info
	function output_info(): string {
		global $help_interfaces;
		$output = "";
		$output .= '
<section id="info" data-disable-interaction="true" data-step="11" data-intro="'.$this->_intro_info.'">
  <h2 class="mb-4">'.$this->_info_h5.'</h2>
  <span class="d-block text-center display-4 controls mb-4"><i onclick="goToPrevMain()" class="fal fa-calendar-minus chart-nav" style="cursor: pointer;" title="'.$this->_chart_prev.'" ></i>   <i onclick="goToTodayMain()" class="fal fa-calendar'.(($this->_diff == 0) ? '-day': '-alt').' chart-nav" style="cursor: pointer;" title="'.$this->_chart_today.'"></i>   <i onclick="goToNextMain()" class="fal fa-calendar-plus chart-nav" style="cursor: pointer;" title="'.$this->_chart_next.'"></i></span>
	'.$this->get_infor_details().'
	<span class="d-block text-center display-4 controls"><i onclick="goToPrevWeekMain()" class="fal fa-backward chart-nav" style="cursor: pointer;" title="'.$this->_chart_prev_week.'" ></i>   <i onclick="goToBirthdayMain()" class="fal fa-birthday-cake chart-nav" style="cursor: pointer;" title="'.$this->_chart_birthday.'"></i>   <i onclick="goToNextWeekMain()" class="fal fa-forward chart-nav" style="cursor: pointer;" title="'.$this->_chart_next_week.'"></i></span>
</section>
		';
		return $output;
	}
	// Render Highcharts
	function output_main_chart(): string {
		global $menu_interfaces;
		global $help_interfaces;
		$output = "";
		$output .= '
<input type="hidden" id="dt_curr" value="'.date('Y-m-d',time()+86400*$this->_diff).'" />
<i onclick="goToPrevMain()" data-disable-interaction="true" data-step="6" data-intro="'.$this->_chart_prev.'" data-original-title="'.$this->_chart_prev.'" data-toggle="tooltip" data-placement="right" class="chart-nav position-absolute fad fa-calendar-minus" style="left: 4px;"></i>
<i id="chart-today" onclick="goToTodayMain()" data-disable-interaction="true" data-step="4" data-intro="'.$this->_chart_today.'" data-original-title="'.$this->_chart_today.'" data-toggle="tooltip" data-placement="bottom" class="chart-nav position-absolute fad fa-calendar'.(($this->_diff == 0) ? '-day': '-alt').'" style="bottom: auto; top: 8px; left: calc(50% - 21px);"></i>
<input onchange="changeDateMain()" data-toggle="tooltip" data-placement="top" data-original-title="'.$this->_dt_change_label.'" data-disable-interaction="true" data-step="5" data-intro="'.$this->_dt_change_label.'" type="text" class="mx-auto form-control" name="dt_change" id="change-date" placeholder="'.$this->_dt_change_label.'" required="required" value="'.(($this->_dt_change == date('Y-m-d')) ? 'YYYY-MM-DD': $this->_dt_change).'" data-date-start-view="decade">
<i onclick="goToNextMain()" data-disable-interaction="true" data-step="7" data-intro="'.$this->_chart_next.'" data-original-title="'.$this->_chart_next.'" data-toggle="tooltip" data-placement="left" class="chart-nav position-absolute fad fa-calendar-plus" style="right: 4px;"></i>
<i id="chart-prev-week" onclick="goToPrevWeekMain()" data-disable-interaction="true" data-step="8" data-intro="'.$this->_chart_prev_week.'" data-original-title="'.$this->_chart_prev_week.'" data-toggle="tooltip" data-placement="top" class="chart-nav position-absolute fad fa-backward" style="bottom: 8px; top: auto; left: calc(50% - 84px);"></i>
<i id="chart-next-week" onclick="goToNextWeekMain()" data-disable-interaction="true" data-step="9" data-intro="'.$this->_chart_next_week.'" data-original-title="'.$this->_chart_next_week.'" data-toggle="tooltip" data-placement="top" class="chart-nav position-absolute fad fa-forward" style="bottom: 8px; top: auto; right: calc(50% - 84px);"></i>
<i id="chart-birthday" onclick="goToBirthdayMain()" data-disable-interaction="true" data-step="10" data-intro="'.$this->_chart_birthday.'" data-original-title="'.$this->_chart_birthday.'" data-toggle="tooltip" data-placement="top" class="chart-nav position-absolute fad fa-birthday-cake" style="bottom: 8px; top: auto; left: calc(50% - 21px);"></i>
<div id="main_chart" class="mx-auto shadow-lg rounded" data-disable-interaction="true" data-step="3" data-intro="'.$this->_intro_chart.'"></div>
<script>
lang = $("html").attr("lang");
dt_curr = $("#dt_curr").val();
dt_change = $("#change-date").val();
function goToTodayMain() {
	loadResults("'.$this->_dob.'","0","'.$this->_is_secondary.'","'.date('Y-m-d').'","'.$this->_partner_dob.'",lang);
	$("[data-toggle=tooltip]").tooltip("hide");
}
function goToPrevMain() {
	loadResults("'.$this->_dob.'","'.($this->_diff-1).'","'.$this->_is_secondary.'","'.date('Y-m-d',time()+86400*($this->_diff-1)).'","'.$this->_partner_dob.'",lang);
	$("[data-toggle=tooltip]").tooltip("hide");
}
function goToNextMain() {
	loadResults("'.$this->_dob.'","'.($this->_diff+1).'","'.$this->_is_secondary.'","'.date('Y-m-d',time()+86400*($this->_diff+1)).'","'.$this->_partner_dob.'",lang);
	$("[data-toggle=tooltip]").tooltip("hide");
}
function goToPrevWeekMain() {
  loadResults("'.$this->_dob.'","'.($this->_diff-7).'","'.$this->_is_secondary.'","'.date('Y-m-d',time()+86400*($this->_diff-7)).'","'.$this->_partner_dob.'",lang);
  $("[data-toggle=tooltip]").tooltip("hide");
}
function goToNextWeekMain() {
  loadResults("'.$this->_dob.'","'.($this->_diff+7).'","'.$this->_is_secondary.'","'.date('Y-m-d',time()+86400*($this->_diff+7)).'","'.$this->_partner_dob.'",lang);
  $("[data-toggle=tooltip]").tooltip("hide");
}
function goToBirthdayMain() {
	loadResults("'.$this->_dob.'","'.($this->_diff+countdown_birthday($this->_dob, $this->_date)).'","'.$this->_is_secondary.'","'.date('Y-m-d',time()+86400*($this->_diff+countdown_birthday($this->_dob, $this->_date))).'","'.$this->_partner_dob.'",lang);
	$("[data-toggle=tooltip]").tooltip("hide");
}
function changeDateMain() {
	loadResults("'.$this->_dob.'",'.$this->_diff.'+dateDiff(dt_curr,$("#change-date").val()),"'.$this->_is_secondary.'",$("#change-date").val(),"'.$this->_partner_dob.'",lang);
	$("[data-toggle=tooltip]").tooltip("hide");
}
$("#change-date").datepicker({
	format: "yyyy-mm-dd",
	defaultViewDate: "'.date('Y-m-d',strtotime($this->_dt_change)).'",
//	endDate: "'.date('Y-m-d').'",
	autoclose: true,
//	immediateUpdates: true,
//	todayHighlight: true,
//	todayBtn: true,
	orientation: "bottom",
	title: "'.$this->_dt_change_label.'"
}).attr("readonly","readonly");
if ($("#change-date").val() != "YYYY-MM-DD") {
	renderChart("#main_chart","'.$this->_title_text.$this->_dob.' | '.date('Y-m-d',time()+86400*$this->_diff).'","'.$this->_percentage_text.'","'.$this->_date_text.'",'.$this->_dates_json.',"'.$this->_today_index.'","'.$this->_dob.'",'.$this->_diff.',"'.$this->_is_secondary.'",$("#change-date").val(),'.$this->serialize_chart_data().',"main");
} else if ($("#change-date").val() == "YYYY-MM-DD") {
	renderChart("#main_chart","'.$this->_title_text.$this->_dob.' | '.date('Y-m-d',time()+86400*$this->_diff).'","'.$this->_percentage_text.'","'.$this->_date_text.'",'.$this->_dates_json.',"'.$this->_today_index.'","'.$this->_dob.'",'.$this->_diff.',"'.$this->_is_secondary.'","'.date('Y-m-d').'",'.$this->serialize_chart_data().',"main");
}
$.ajax({
  success : function() {
    if (!Modernizr.touch) {
      $("[data-toggle=tooltip]").tooltip();
    }
  },
  global: false
});
setChartOptions("'.$this->_full_screen_text.'","'.$this->_download_jpeg_text.'","'.$this->_download_pdf_text.'","'.$this->_download_png_text.'","'.$this->_download_svg_text.'","'.$this->_print_chart_text.'","'.$this->_reset_zoom_text.'");
renderChart("#main_chart","'.$this->_title_text.$this->_dob.' | '.date('Y-m-d',time()+86400*$this->_diff).'","'.$this->_percentage_text.'","'.$this->_date_text.'",'.$this->_dates_json.',"'.$this->_today_index.'","'.$this->_dob.'",'.$this->_diff.',"'.$this->_is_secondary.'","'.date('Y-m-d',time()+86400*$this->_diff).'",'.$this->serialize_chart_data().',"main");
</script>
		';
		return $output;
	}
	function render_results() {
		echo $this->output_stats();
		if ($this->_is_registered == true) {
			echo $this->output_lunar();
		}
		echo $this->output_info();
		echo $this->output_compatibility();
		echo $this->output_controls();
		echo $this->output_main_chart();
	}
	function render_array() {
		echo '<pre>';
		print_r($this->_rhythms);
		echo '</pre>';
	}
}