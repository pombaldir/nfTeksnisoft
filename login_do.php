<?php
/*
 * Copyright (C) 2013 peredur.net
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
 
include_once 'include/db_connect.php';
include_once 'include/functions.php';


sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['username'], $_POST['p'])) {
    $email = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['p']; // The hashed password.
    if (login($email, $password, $mysqli) == true) {
        // Login success 
        $user_pass_ok="yes";
		$redir="index.php";
		$htmlmsg="Sessão iniciada";
        
    } else {
        // Login failed 
        $user_pass_ok="no";
		$redir=0;
		$htmlmsg="O login falhou!";
		
    }
} else {
    // The correct POST variables were not sent to this page. 
   		$user_pass_ok="no";
		$redir=0;
		$htmlmsg="Não foi possivel processar os dados";
}

$response = array("mensagem" => "$user_pass_ok", "redir" => "$redir", "htmlmsg" => "$htmlmsg");
echo json_encode($response);
?>