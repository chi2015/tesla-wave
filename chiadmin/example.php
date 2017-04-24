<?php
	function Make_Array_Values($from, $to, $values,  $step = 1, $repeat = TRUE)
	{

        $values = is_array($values) ? array_values($values) : array($values);

		$a = array();
		for($currentArrayIndex = $from, $valuesArrayIndex = 0; $currentArrayIndex <= $to; ++$valuesArrayIndex, $currentArrayIndex += $step) {

			$a[$currentArrayIndex] = is_array($values) ? $values[$valuesArrayIndex] : $values;

			if ($valuesArrayIndex+1 >= count($values)) {
				if ($repeat) {
					$valuesArrayIndex = -1;
				} else {
					throw new Exception('ֽו ץגאעטכמ ‎כולוםעמג הכÿ חאןמכםוםטÿ');
				}
			}
		}
		return $a;
	}

 	$v = array("a"=>1, "b"=>2, "c" => 3, "d" => 4);
     //  $v = 'a';
 	$r = Make_Array_Values(5,15,$v);
 	print_r($r);


	function sqlQuery($conf) {
		$sql = $conf['sql'];
		$binds = isset($conf['binds']) && is_array($conf['binds']) ? $conf['binds'] : array();

		foreach ($binds as $bind) {
			if (is_array($bind)) {
				$bind = '\'' . implode('\',\'', $bind) . '\'';
			}
			if (!is_array($bind)) {
				if ($_SESSION['flag, which means that it is needed to convert special chars']) {
					$sql = preg_replace('/(?<![\\])\?/', "'" . $bind . "'", 1);
				} else {
					$sql = preg_replace('/(?<![\\])\?/', "'" . htmlentitied($bind) . "'", 1);
				}
			}
		}
		return $sql;
	}

         echo sqlQuery(array('sql' => "delete \\", 'binds' => array('dep', 'dep2')));
 function checkStringIfUtf($string) {
		return preg_match('//u', $string);
	}

	echo checkStringIfUtf('א1ûנמ2אנûכהמגאנהפûמגכאנהפûגמכאנהפגמאנפגûהאמנהפûגכמאנפגûהאמנגûפהאמנפגûהאמנפהûגאמנûפגהכמאנהפמגכנמכה');
	//echo mb_detect_encoding('אןûנמאנûכהמגאנהפûמגכאנהפûגמכאנהפגמאנפגûהאמנהפûגכמאנפגûהאמנגûפהאמנפגûהאמנפהûגאמנûפגהכמאנהפמגכנמכה');


	class Container {		public function method1($a, $b)
		{
			echo __METHOD__." executed with $a and $b";		}

		public function method2()
		{
			echo __METHOD__." executed";		}

	}



	function execute_method($method)
	{		   $Container1 = new Container;
		   if (method_exists($Container1,$method['method']))
		   {
		   	$m = $method['method'];
		   	$Container1->$m(1,2);		   	}	}

	execute_method(array('method'=>"method1"));


?>