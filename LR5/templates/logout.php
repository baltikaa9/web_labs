<?php
session_start();
require_once '../logic/user_actions.php';
UserActions::sign_out();
redirect($_SERVER['HTTP_REFERER']);
