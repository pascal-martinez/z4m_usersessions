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
 * ZnetDK 4 Mobile User sessions Module French translations
 *
 * File version: 1.0
 * Last update: 04/24/2025
 */

define('MOD_Z4M_USERSESSIONS_MENU_LABEL', 'Sessions utilisateurs');

define('MOD_Z4M_USERSESSIONS_LIST_MODIFTIME_LABEL', 'Heure de modif.');
define('MOD_Z4M_USERSESSIONS_LIST_USERNAME_LABEL', 'Utilisateur');
define('MOD_Z4M_USERSESSIONS_LIST_UNKNOWNUSER_LABEL', 'INCONNU');
define('MOD_Z4M_USERSESSIONS_LIST_LOGININFOS_LABEL', 'Infos connexion');
define('MOD_Z4M_USERSESSIONS_LIST_ENDTIME_LABEL', 'Heure de fin');

define('MOD_Z4M_USERSESSIONS_LIST_KILLSESSION_LINK', 'Terminer la session...');

define('MOD_Z4M_USERSESSIONS_SETTINGS_TITLE', 'Configuration des sessions utilisateurs');

define('MOD_Z4M_USERSESSIONS_SETTINGS_PARAMETER_COLUMN', 'Paramètre');
define('MOD_Z4M_USERSESSIONS_SETTINGS_GLOBAL_COLUMN', 'GLOBAL (php.ini)');
define('MOD_Z4M_USERSESSIONS_SETTINGS_LOCAL_COLUMN', 'LOCAL (config.php)');

define('MOD_Z4M_USERSESSIONS_SETTINGS_PHP_ROW', 'Configuration PHP');
define('MOD_Z4M_USERSESSIONS_SETTINGS_ZNETDK_ROW', 'Configuration ZnetDK');

define('MOD_Z4M_USERSESSIONS_ACTION_CLEANALL_LABEL', 'Nettoyer les sessions...');
define('MOD_Z4M_USERSESSIONS_ACTION_SETTINGS_LABEL', 'Configuration des sessions...');

define('MOD_Z4M_USERSESSIONS_FORM_CLEANALL_LEGEND', 'Supprimer les fichiers de sessions...');
define('MOD_Z4M_USERSESSIONS_FORM_CLEANALL_ONLY_EXPIRED_LABEL', 'Uniquement pour les sessions qui ont expirés.');
define('MOD_Z4M_USERSESSIONS_FORM_CLEANALL_ALL_SESSIONS_LABEL', 'Pour toutes les sessions de l\'application.');

define('MOD_Z4M_USERSESSIONS_ACTION_KILLALL_QUESTION', 'Supprimer toutes les sessions de l`\'application ?');
define('MOD_Z4M_USERSESSIONS_ACTION_CLEANALL_QUESTION', 'Nettoyer uniquement les sessions expirées ?');
define('MOD_Z4M_USERSESSIONS_ACTION_KILL_QUESTION', 'Terminer les sessions de %1 ?');

define('MOD_Z4M_USERSESSIONS_ACTION_KILL_SUCCESS', '%1 session(s) terminée(s).');
define('MOD_Z4M_USERSESSIONS_ACTION_KILL_FAILED', 'Les sessions ne peuvent pas être terminées.');

define('MOD_Z4M_USERSESSIONS_ACTION_CLEAN_SUCCESS', '%1 session(s) nettoyée(s).');

define('MOD_Z4M_USERSESSIONS_ACTION_SAVEPATHNOTREADABLE_WARN', "Le chemin d'enregistrement des sessions PHP '%1' ne peut être lu. Votre seule session est affichée.");