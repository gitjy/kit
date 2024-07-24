<?php
#redis session
 ini_set('session.save_handler', 'redis');
 ini_set('session.save_path', 'tcp://127.0.0.1:50500?&auth=Np3jftX7808X');
session_start();