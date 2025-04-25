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
 * ZnetDK 4 Mobile User sessions Module Spanish translations
 *
 * File version: 1.0
 * Last update: 04/24/2025
 */

define('MOD_Z4M_USERSESSIONS_MENU_LABEL', 'sesiones de usuario');

define('MOD_Z4M_USERSESSIONS_LIST_MODIFTIME_LABEL', 'Hora de modificación');
define('MOD_Z4M_USERSESSIONS_LIST_USERNAME_LABEL', 'Usuario');
define('MOD_Z4M_USERSESSIONS_LIST_UNKNOWNUSER_LABEL', 'DESCONOCIDO');
define('MOD_Z4M_USERSESSIONS_LIST_LOGININFOS_LABEL', 'Información de inicio de sesión');
define('MOD_Z4M_USERSESSIONS_LIST_ENDTIME_LABEL', 'Fin del tiempo');

define('MOD_Z4M_USERSESSIONS_LIST_KILLSESSION_LINK', 'Finalizar sesión...');

define('MOD_Z4M_USERSESSIONS_SETTINGS_TITLE', 'Configuración de la sesión de usuario');

define('MOD_Z4M_USERSESSIONS_SETTINGS_PARAMETER_COLUMN', 'Parámetro');
define('MOD_Z4M_USERSESSIONS_SETTINGS_GLOBAL_COLUMN', 'GLOBAL (php.ini)');
define('MOD_Z4M_USERSESSIONS_SETTINGS_LOCAL_COLUMN', 'LOCAL (config.php)');

define('MOD_Z4M_USERSESSIONS_SETTINGS_PHP_ROW', 'Configuración de PHP');
define('MOD_Z4M_USERSESSIONS_SETTINGS_ZNETDK_ROW', 'Configuración de ZnetDK');

define('MOD_Z4M_USERSESSIONS_ACTION_CLEANALL_LABEL', 'Limpiar sesiones de usuario...');
define('MOD_Z4M_USERSESSIONS_ACTION_SETTINGS_LABEL', 'Configuración de sesión...');

define('MOD_Z4M_USERSESSIONS_FORM_CLEANALL_LEGEND', 'Eliminar archivos de sesión...');
define('MOD_Z4M_USERSESSIONS_FORM_CLEANALL_ONLY_EXPIRED_LABEL', 'Sólo para sesiones de usuario caducadas.');
define('MOD_Z4M_USERSESSIONS_FORM_CLEANALL_ALL_SESSIONS_LABEL', 'Para todas las sesiones existentes de la aplicación.');

define('MOD_Z4M_USERSESSIONS_ACTION_KILLALL_QUESTION', '¿Finalizar todas las sesiones existentes de la aplicación?');
define('MOD_Z4M_USERSESSIONS_ACTION_CLEANALL_QUESTION', '¿Limpiar sesiones caducadas?');
define('MOD_Z4M_USERSESSIONS_ACTION_KILL_QUESTION', '¿Finalizar las sesiones de %1?');

define('MOD_Z4M_USERSESSIONS_ACTION_KILL_SUCCESS', '%1 sesiones finalizadas.');
define('MOD_Z4M_USERSESSIONS_ACTION_KILL_FAILED', 'No se puede finalizar las sesiones.');

define('MOD_Z4M_USERSESSIONS_ACTION_CLEAN_SUCCESS', '%1 sesion(es) limpiada(s).');

define('MOD_Z4M_USERSESSIONS_ACTION_SAVEPATHNOTREADABLE_WARN', "La ruta de guardado de la sesión PHP '%1' no es legible. Solo se muestra su sesión.");