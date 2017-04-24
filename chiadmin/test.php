<?php

	class StatObj {

	    protected static $_instance;
          public static $_state = 1;
        private function __construct() {
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    private function __clone() {
    }
	}

	class ObjDesc {
		public $_desc_obj;
		public $_desc_obj2;
	}

	$od = new ObjDesc;
	$od->_desc_obj = StatObj::getInstance();

	$od->_desc_obj->_state = 2;


            print_r(StatObj::getInstance());

            print_r($od);
            echo_br(StatObj::$_state);


   	class Foo {

   		public function get()
   		{
   			return __CLASS__;
   		}
   	}

   	class Bar extends Foo {

   		public function get()
   		{
   			return __CLASS__;
   		}

   		public function parentGet()
   		{
   			return parent::get();
   		}

   	}
$b = new Bar;
   	echo_br($b->get());
   	echo_br($b->parentGet());

	$a = 5;
	$b = 4;

	function test_gs()
	{
		global $a;
		static $b = array();
		$a++;
		$b[] = $a;
		echo_br('a = '.$a);
		print_r($b);
	}

	test_gs();
	test_gs();



	class myIClass
   	{
   		public $working = 999;

   		public function doSomething($str)
   		{
   			echo_br($str.' something');

   			$self = $this;

   			$f = function() use ($str, $self)
   			{
   				return $self->$str;
   			};

   			echo $f();
   		}
   	}



	//$myInstance = null;

	$broken = function() use ($myInstance)
	{
	    if(!empty($myInstance)) $myInstance->doSomething('broken');
	};

	$working = function() use (&$myInstance)
	{
	    if(!empty($myInstance)) $myInstance->doSomething('working');
	};

	$myInstance = new myIClass();



	$broken();    // will never do anything: $myInstance will ALWAYS be null inside this closure.
	$working();    // will call doSomething




	function multipleValue($value)
   {
   		$result = function($mult, $value1) use ($value)
   		{
   			echo $value1;
   			return $mult*$value;
   		};

   		return $result(2, 3);


   }

	echo multipleValue(5);


	class SObject {
    	protected function S()
    	{
    		echo_br("S");
    	}

    	public function callS()
    	{
    		$this->S();
    	}

    }

    class SChildObject extends SObject {

     /*	protected function S()
     	{
     		echo_br( "S-child");
     	}  */

     	public function callBothS()
     	{
     		$this->S();
     		parent::S();
     		}
    }

    $Obj = new SChildObject;
    $Obj->callS();
    $Obj->callBothS();


	function echo_br($str)
	{
		echo $str."</br></br>";
	}


	echo_br("Hello tests!");

	echo_br(php_uname());

	echo_br(phpversion());

	class a1 {

		private static $some_prop = 'some prop value';

		public function stat_func()
		{
			echo_br('AAAA');
		}

		public $b = 1;
		public $f = 9;

		public function showClassName()
		{
			echo_br(get_class());
			echo_br(self::$some_prop);

		}

		public function setSomeProp($value)
		{
			self::$some_prop = $value;
		}

	  public function __set($name, $value)
	  {
	   	echo_br("Non-existing property $name");
	  }

	 public function __get($name)
	 {
	   	echo_br("Hmmmmm....");
	 }

	 public function __call($method, $args)
	 {
	 	print_r($args);
	 }

	 public function __unset($name)
	 {
	 	$name = 10;
	 }

	}

	$a = new a1;

	a1::showClassName();

	$a->setSomeProp(5);

	a1::showClassName();

	//$a->v = 1;

	echo $a->m;

	$n_func = function($b) { echo_br($b*2); };

	echo_br($a->f);
	$a->f = $n_func;
	//$a->f(7);
	print_r($a->f);

	$eee = $a->f;
	$eee(7);

	unset($a->f);
	echo_br($a->f);
	$a->f=10;
	echo_br($a->f);

	var_dump($a);

	class SClass {

		public static function getSettings()
		{
			echo_br('Settings!!!');
			self::ss();
		}

         private static function ss()
         {
         	}

		private function __construct()
		{
		}
	}

	class SChild extends SClass {
		private function __construct()
		{
		}

		private static function ss()
         {
         	}
	}

    SChild::getSettings();
echo 'dddddd';
print_r(debug_backtrace());
debug_print_backtrace();

?>