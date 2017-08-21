<?php

/* jiny92@kisti.re.kr */

class cnTrans {
    private $ini;
    private $mid;
    private $end;
    private $sn_2word;
    private $sn_overlap;
    private $en_vowel;
    private $en_consonant;
    private $en_heuristic;
    
    function __construct() {
	$this->ini = array("ㄱ","ㄲ","ㄴ","ㄷ","ㄸ","ㄹ","ㅁ","ㅂ","ㅃ","ㅅ","ㅆ","ㅇ","ㅈ","ㅉ","ㅊ","ㅋ","ㅌ","ㅍ","ㅎ");
	$this->mid = array("ㅏ","ㅐ","ㅑ","ㅒ","ㅓ","ㅔ","ㅕ","ㅖ","ㅗ","ㅘ","ㅙ","ㅚ","ㅛ","ㅜ","ㅝ","ㅞ","ㅟ","ㅠ","ㅡ","ㅢ","ㅣ");
	$this->end = array("","ㄱ","ㄲ","ㄳ","ㄴ","ㄵ","ㄶ","ㄷ","ㄹ","ㄺ","ㄻ","ㄼ","ㄽ","ㄾ","ㄿ","ㅀ","ㅁ","ㅂ","ㅄ","ㅅ","ㅆ","ㅇ","ㅈ","ㅊ","ㅋ"," ㅌ","ㅍ","ㅎ");
	$this->sn_2word = array("황목", "황보", "남궁", "제갈", "선우", "사공", "서문", "독고");
	$this->sn_overlap = array("황목", "황보", "남궁", "선우", "서문");
        $this->en_vowel = array(
	    'ㅏ' => 'a', 'ㅓ' => 'eo', 'ㅗ' => 'o', 'ㅜ' => 'u', 'ㅡ' => 'eu', 'ㅣ' => 'i', 'ㅐ' => 'ae', 'ㅔ' => 'e', 'ㅚ' => 'oe', 'ㅟ' => 'wi',
	    'ㅑ' => 'ya', 'ㅕ' => 'yeo', 'ㅛ' => 'yo', 'ㅠ' => 'yu', 'ㅐ' => 'yae', 'ㅖ' => 'ye', 'ㅘ' => 'wa', 'ㅙ' => 'wae', 'ㅝ' => 'wo', 'ㅞ' => 'we', 'ㅢ' => 'ui',
	);

	// 1. http://www.korean.go.kr/front/page/pageView.do?page_id=P000149&mn_id=99 참조
        // 2. https://namu.wiki/w/%ED%95%9C%EA%B5%AD%EC%9D%B8%20%EC%9D%B4%EB%A6%84%EC%9D%98%20%EB%A1%9C%EB%A7%88%EC%9E%90%20%ED%91%9C%EA%B8%B0 나무 위키도 참조 할 것

	$this->en_consonant = array(
	    'ㄱ' => array('g', 'k'), 'ㄲ' => array('kk'), 'ㅋ' => array('k'), 'ㄷ' => array('d', 'k'), 'ㄸ' => array('tt'), 'ㅌ' => array('t'), 'ㅂ' => array('b', 'p'),
	    'ㅃ' => array('pp'), 'ㅍ' => array('p'), 'ㅈ' => array('j'), 'ㅉ' => array('jj'), 'ㅊ' => array('ch'), 'ㅅ' => array('s'), 'ㅆ' => array('ss'),
	    'ㅎ' => array('h'), 'ㄴ' => array('n'), 'ㅁ' => array('m'), 'ㅇ' => array('ng'), 'ㄹ' => array('r', 'l'),
	);
        // sn usually violating the rule 1.
	$this->en_heuristic = array(
	    '가' => 'Ka', '간' => 'Kan', '갈' => 'Kal', '감' => 'Kam', '강' => 'Kang', "강전" => "Kangjun", '개' => 'Kae', '견' => 'Kyun', '경' => 'Kyung', '계' => 'Kye', 
	    '고' => 'Ko', '공' => 'Kong', '곽' => 'Kwak', '관' => 'Kwan', '교' => 'Gyo', '구' => 'Koo', '국' => 'Kook', '군' => 'Kun', '궁' => 'Koong', 
	    '궉' => 'Kwok', '권' => 'Kwon', '근' => 'Keon', '금' => 'Keum', '기' => 'Ki', '길' => 'Kil', '김' => 'Kim',  
	    '내' => 'Nae', '노' => 'Noh', '뇌' => 'Noe', '다' => 'Ta', '대' => 'Dae', '독' => 'Tok', '두' => 'Doo', '라' => 'Ra', '란' => 'Lan', 
	    '뢰' => 'Loi', '루' => 'Lu', '망절' => 'Mangjul', '매' => 'Mae', '맹' => 'Maeng', '명' => 'Myung',  
	    '문' => 'Moon', '박' => 'Park', '배' => 'Bae', '백' => 'Baek', '변' => 'Byun', '부' => 'Boo', '선' => 'Sun', '선우' => 'Sunwoo', '성' => 'Sung',
	    '순' => 'Soon', '신' => 'Shin', '심' => 'Shim', '아' => 'Ah', '애' => 'Ae', '오' => 'Oh', '우' => 'Woo', '운' => 'Woon', '유' => 'Yoo', '윤' => 'Yoon', '이' => 'Lee',
	    '임' => 'Lim', '정' => 'Jung', '주' => 'Joo', '주' => 'Joo', '채' =>'Chae', '최' => 'Choi', '태' => 'Tae', '팽' => 'Paeng', '편' => 'Pyun', '평' => 'Pyung', 
	    '해' => 'Hae', '현' => 'Hyun', '형' => 'Hyung', 
	); 
    }

    function utf8_strlen($str = '') { 
	return mb_strlen($str, 'UTF-8'); 
    }

    function utf8_charAt($str = '', $num) { 
	return mb_substr($str, $num, 1, 'UTF-8'); 
    }

    function utf8_ord($ch) {
  	$len = strlen($ch);
	if($len <= 0) return false;
  	$h = ord($ch{0});
  	if ($h <= 0x7F) return $h;
  	if ($h < 0xC2) return false;
  	if ($h <= 0xDF && $len>1) return ($h & 0x1F) <<  6 | (ord($ch{1}) & 0x3F);
  	if ($h <= 0xEF && $len>2) return ($h & 0x0F) << 12 | (ord($ch{1}) & 0x3F) << 6 | (ord($ch{2}) & 0x3F);          
  	if ($h <= 0xF4 && $len>3) return ($h & 0x0F) << 18 | (ord($ch{1}) & 0x3F) << 12 | (ord($ch{2}) & 0x3F) << 6 | (ord($ch{3}) & 0x3F);
  	return false;
    }

    private function is_korean($str = '') {
	if(strlen($str) == mb_strlen($str, 'utf-8')) return false;
	else return true;
    }

    public function separate($name = '') {
        $KR_BT = 3;
	$KR_2_CN = 2*$KR_BT;
	$KR_3_CN = 3*$KR_BT;
	$KR_4_CN = 4*$KR_BT;

	$suggestion = array();

	if($this->is_korean($name)) { 
            $name_chars = strlen($name);

            if($name_chars == $KR_2_CN) {
		/* Korean CN is two syllable: first is sn and the second is gn */
		$suggestion = array(
		   array(
		   	'sn' => mb_strcut($name, 0, $KR_BT),
		   	'gn' => mb_strcut($name, $KR_BT, strlen($name) - $KR_BT),
		   ),
		);
            }else{ 
		/* Korean CN is three or more syllable */
                if($name_chars >= $KR_3_CN) {
                    $snt = mb_strcut($name, 0, 2*$KR_BT); // get first two syllable

                    if(in_array($snt, $this->sn_2word)){  // perhaps sn would be two syllable
			$suggestion = array(
			    array(
			    	'sn' => mb_strcut($snt, 0, 2*$KR_BT),
			    	'gn' => mb_strcut($name, 2*$KR_BT, strlen($name) - 2*$KR_BT),
			    ),
			    array(
			      	'sn' => mb_strcut($snt, 0, $KR_BT),
				'gn' => mb_strcut($name, $KR_BT, strlen($name) - $KR_BT),
			    ),
			);
                    }else{ // sn is one syllable
			$suggestion = array(
			    array(
			    	'sn' => mb_strcut($snt, 0, $KR_BT),
			    	'gn' => mb_strcut($name, $KR_BT, strlen($name) - $KR_BT),
			    ),
			);
                    }
                }
            }
      	}else{ //perhaps English
            $enm = explode(" ", $name);
            if( count($enm) > 1) {
            	$gn = $enm[0];
                $sn = $enm[count($enm) - 1 ];
            }else{
                $sn = $name;
                $gn = $name;
            }

	    $suggestion = array(
                array(
                    'sn' => $sn,
                    'gn' => $gn,
            	),
            );
        }
	
	return $suggestion;
    }

    public function fragment($str = '') {
	// has to handle just one syllable; need exception handling
        $tokenized = array();
	for($digit = 0; $digit < $this->utf8_strlen($str); $digit++ ) {
            $code = $this->utf8_ord($this->utf8_charAt($str, $digit)) - 44032;
       	    if ($code > -1 && $code < 11172) {        
	    	 $i_idx = $code / 588;      
      	    	 $m_idx = $code % 588 / 28;  
      	         $e_idx = $code % 28;
      	         //$tokenized .= $this->ini[$i_idx].$this->mid[$m_idx].$this->end[$e_idx];
		 $tokenized = array(
		    'b' => $this->ini[$i_idx],
		    'm' => $this->mid[$m_idx],
		    'e' => $this->end[$e_idx],
		 );
    	    } else {
       	         //$tokenized .= $this->utf8_charAt($str, $digit);
		 $tokenized = array('n' => $this->utf8_charAt($str, $digit));
            }
	}
        return $tokenized;
    }
  
    public function convert_nonstd($str = '') {
	$syllable = '';
	if( array_key_exists($str, $this->en_heuristic) ) {
	    return $this->en_heuristic[$str];
	}else {
	    return $this->convert($str);
	}
    }  

    public function convert($str = '') {
        $syllable = '';

	// partition a word into mutliple syllables
	$bunch = str_split($str, 3);

	for($i = 0; $i < count($bunch); $i++) {
	    $fraction = $this->fragment($bunch[$i]);
	    // to forsee the initial consonant of next syllable
	    if($i + 1 != count($bunch)) $adv_fraction = $this->fragment($bunch[$i+1]);
 
	    if( array_key_exists('n', $fraction) ) return '';
	    if( array_key_exists($fraction['b'], $this->en_consonant) ){
            	if( $fraction['b'] != 'ㅇ' ) {
                    // en_consonant <- array
		    // if inital consonant, use g, b, d, r 
                    $syllable .= $this->en_consonant[$fraction['b']][0];
            	}
            }
            if( array_key_exists($fraction['m'], $this->en_vowel) ){
            	$syllable .= $this->en_vowel[$fraction['m']];
            }
            if( array_key_exists($fraction['e'], $this->en_consonant) ) {

		// if final consonant, use k, p, t instead of g, b, d
	        if( $fraction['e'] == 'ㄱ' || $fraction['e'] == 'ㄷ' || $fraction['e'] == 'ㅂ' || $fraction['e'] == 'ㄹ'){
		    if( $i + 1 != count($bunch) ) {
			
			if($adv_fraction['b'] != 'ㅇ')
            	    	    $syllable .= $this->en_consonant[$fraction['e']][1];
			else
			    $syllable .= $this->en_consonant[$fraction['e']][0];
		
		    } else {
			 $syllable .= $this->en_consonant[$fraction['e']][1];	
		    }
		}else{
		    $syllable .= $this->en_consonant[$fraction['e']][0];
		}
            }

	}

	return ucfirst($syllable);
    }
}

function read_stdin()
{
   $fr = fopen("php://stdin", "r");
   echo "name: " . PHP_EOL;
   $input = fgets($fr, 128);
   $input = rtrim($input);
   fclose($fr);
   return $input;
}


$ct = new cnTrans();

while(1){
echo "\n";
$in_name = read_stdin();


$name = $ct->separate($in_name);

foreach ($name as $value) {
    echo "SN/GN: ". $value['sn'] . "/" . $value['gn'] . "\n"; 
    echo "Standard naming: " . $ct->convert($value['sn']) . ", " . $ct->convert($value['gn']) . "\n";
    echo "NonStandard naming: " . $ct->convert_nonstd($value['sn']) . ", " . $ct->convert($value['gn']);
}

}
?>
