<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale (LC_ALL, 'pt_PT');



/** 
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

/**
 * This file contains global configuration variables
 * Things like whether anyone can register.
 * 
 * Whether or not it's a secure (https) connection could
 * also go here...
 */

/**
 * These are the database login details
 */
define("HOST", "localhost"); 			// The host you want to connect to. 
define("USER", "root"); 				// The database username. 
define("PASSWORD", "root"); 			// The database password. 
define("DATABASE", "nelsonferreira");  // The database name.

define("URLBASE", "http://dev.nf.teknisoft.pt:8888"); 
define("DOCROOT", "/Users/nelsonsantos/Sites/NelsonFerreira"); 

$ds = DIRECTORY_SEPARATOR; 
$storeFolder = '/Users/nelsonsantos/Sites/NelsonFerreira/attachments';  
$tempFolder = $storeFolder.'/tmp';  

ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
/**
 * Who can register and what the default role will be
 * Values for who can register under a standard setup can be:
 *      any  == anybody can register (default)
 *      admin == members must be registered by an administrator
 *      root  == only the root user can register members
 *  
 * Values for default role can be any valid role, but it's hard to see why
 * the default 'member' value should be changed under the standard setup.
 * However, additional roles can be added and so there's nothing stopping
 * anyone from defining a different default.
 */
define("CAN_REGISTER", "admin");
define("DEFAULT_ROLE", "member");

/**
 * Is this a secure connection?  The default is FALSE, but the use of an
 * HTTPS connection for logging in is recommended.
 * 
 * If you are using an HTTPS connection, change this to TRUE
 */
define("SECURE", FALSE);    // For development purposes only!!!!

