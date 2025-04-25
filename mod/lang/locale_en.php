<?php
/**
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website https://mobile.znetdk.fr
 * Copyright (C) 2025 Pascal MARTINEZ (contact@znetdk.fr)
 * License GNU GPL https://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * --------------------------------------------------------------------
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 * --------------------------------------------------------------------
 * ZnetDK 4 Mobile User sessions Module English translations
 *
 * File version: 1.0
 * Last update: 04/24/2025
 */

define('MOD_Z4M_USERSESSIONS_MENU_LABEL', 'User sessions');

define('MOD_Z4M_USERSESSIONS_LIST_MODIFTIME_LABEL', 'Modification time');
define('MOD_Z4M_USERSESSIONS_LIST_USERNAME_LABEL', 'User name');
define('MOD_Z4M_USERSESSIONS_LIST_UNKNOWNUSER_LABEL', 'UNKNOWN');
define('MOD_Z4M_USERSESSIONS_LIST_LOGININFOS_LABEL', 'Login infos');
define('MOD_Z4M_USERSESSIONS_LIST_ENDTIME_LABEL', 'End time');

define('MOD_Z4M_USERSESSIONS_LIST_KILLSESSION_LINK', 'Kill session...');

define('MOD_Z4M_USERSESSIONS_SETTINGS_TITLE', 'User session configuration');

define('MOD_Z4M_USERSESSIONS_SETTINGS_PARAMETER_COLUMN', 'Parameter');
define('MOD_Z4M_USERSESSIONS_SETTINGS_GLOBAL_COLUMN', 'GLOBAL (php.ini)');
define('MOD_Z4M_USERSESSIONS_SETTINGS_LOCAL_COLUMN', 'LOCAL (config.php)');

define('MOD_Z4M_USERSESSIONS_SETTINGS_PHP_ROW', 'PHP configuration');
define('MOD_Z4M_USERSESSIONS_SETTINGS_ZNETDK_ROW', 'ZnetDK configuration');

define('MOD_Z4M_USERSESSIONS_ACTION_CLEANALL_LABEL', 'Clean up user sessions...');
define('MOD_Z4M_USERSESSIONS_ACTION_SETTINGS_LABEL', 'Session configuration...');

define('MOD_Z4M_USERSESSIONS_FORM_CLEANALL_LEGEND', 'Remove session files...');
define('MOD_Z4M_USERSESSIONS_FORM_CLEANALL_ONLY_EXPIRED_LABEL', 'Only for expired user sessions.');
define('MOD_Z4M_USERSESSIONS_FORM_CLEANALL_ALL_SESSIONS_LABEL', 'For all existing sessions of the application.');

define('MOD_Z4M_USERSESSIONS_ACTION_KILLALL_QUESTION', 'Kill all existing sessions of the application?');
define('MOD_Z4M_USERSESSIONS_ACTION_CLEANALL_QUESTION', 'Clean up only expired sessions?');
define('MOD_Z4M_USERSESSIONS_ACTION_KILL_QUESTION', 'Kill %1\'s sessions?');

define('MOD_Z4M_USERSESSIONS_ACTION_KILL_SUCCESS', '%1 session(s) killed.');
define('MOD_Z4M_USERSESSIONS_ACTION_KILL_FAILED', 'Sessions can\'t be killed.');

define('MOD_Z4M_USERSESSIONS_ACTION_CLEAN_SUCCESS', '%1 session(s) cleaned.');

define('MOD_Z4M_USERSESSIONS_ACTION_SAVEPATHNOTREADABLE_WARN', "The PHP session save path '%1' is not readable. Only your session is shown.");