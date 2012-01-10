<?php
class GeneralUtils {

	public static function LasTimeHere($time) {

		if(time() < $time)	return "invalid time";
		$seconds = time()-$time;
		if($seconds < 60)	return "$seconds secs back";
		$minutes = floor( $seconds / ( int )60 );
		if($minutes < 60)	return "$minutes min back";
		$hours = floor( $minutes / ( int )60 );
		if($hours < 24)	return "$hours hrs back";
		$days = floor( $hours / ( int )24 );
		if($days < 7)	return "$days days ago";
		$weeks = floor( $days / ( int )7 );
		if($weeks < 5)	return "$weeks weeks ago";
		$months = floor( $days / ( int )30 );
		if($months < 12)	return "$months months ago";
		$years = floor( $days / ( int )365 );
		return "$years years ago";
	}

	//	Check string in associative array
	public static function Search_in_Array($Array, $key, $Str) {

		foreach($Array as $value) {
			if($value[$key]== $Str) {
				return true;
			}
		}
		return false;
	}

	public static function handle_input($input) {

		if(empty($input)) return "";
		$value = ereg_replace("\[\]$","",$input);
		$value = preg_replace("/&#124;/", "|", $value);
		$value = stripslashes( html_entity_decode( $value ) );
		return trim($value);
	}
	
	public static function timeDiff($t, $sT = 0, $sel = 'Y') {

		$sY = 31536000;
		$sMt = 2628000;
		$sW = 604800;
		$sD = 86400;
		$sH = 3600;
		$sM = 60;

		if($sT) {
			$t = ($sT - $t);
		}

		if($t <= 0) {
			$t = 0;
		}

		$bs[1] = ('1'^'9'); /* Backspace */

		switch(strtolower($sel)) {

			case 'y':
			$y = ((int)($t / $sY));
			$t = ($t - ($y * $sY));
			@$r['string'] .= "{$y} years{$bs[$y]} ";
			$r['years'] = $y;
			case 'mt':
			$mt = ((int)($t / $sMt));
			$t = ($t - ($mt * $sMt));
			@$r['string'] .= "{$mt} months{$bs[$mt]} ";
			$r['months'] = $mt;
			case 'w':
			$w = ((int)($t / $sW));
			$t = ($t - ($w * $sW));
			@$r['string'] .= "{$w} weeks{$bs[$w]} ";
			$r['weeks'] = $w;
			case 'd':
			$d = ((int)($t / $sD));
			$t = ($t - ($d * $sD));
			@$r['string'] .= "{$d} days{$bs[$d]} ";
			$r['days'] = $d;
			case 'h':
			$h = ((int)($t / $sH));
			$t = ($t - ($h * $sH));
			@$r['string'] .= "{$h} hours{$bs[$h]} ";
			$r['hours'] = $h;
			case 'm':
			$m = ((int)($t / $sM));
			$t = ($t - ($m * $sM));
			@$r['string'] .= "{$m} minutes{$bs[$m]} ";
			$r['minutes'] = $m;
			case 's':
			$s = $t;
			@$r['string'] .= "{$s} seconds{$bs[$s]} ";
			$r['seconds'] = $s;
			break;
			default:
			return self::timeDiff($t);
			break;
		}

		return $r;
	}
}
?>