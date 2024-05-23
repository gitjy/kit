<?php
include "XhprofUnit.php";

if (($_REQUEST['debug'] ?? '') == 'x') {
    XhprofUnit::xhprof();
}
