<?php
//xhprof实例
// start profiling
include 'autoload.php';
if (isset($_GET['xhprofdb'])) {
	XhprofUnit::xhprofdb();
} else {
	XhprofUnit::xhprof();
}


function bar($x) {
  if ($x > 0) {
    bar($x - 1);
  }
}

function foo() {
  for ($idx = 0; $idx < 5; $idx++) {
    bar($idx);
    $x = strlen("abc");
  }
}


// run program
foo();

