<?php
session_start();
require_once '../logic/user_actions.php';
UserActions::signOut();
redirect($_SERVER['HTTP_REFERER']);
