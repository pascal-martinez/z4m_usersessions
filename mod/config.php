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
 * Parameters of the ZnetDK 4 Mobile User sessions module
 *
 * File version: 1.2
 * Last update: 06/15/2025
 */


/**
 * The application URI used to filter displayed user sessions.
 * @var string|NULL The application URI.
 * If NULL, the application URI is obtained calling the
 * \General::getAbsoluteURI() method.
 * If set to 'ALL', all existing sessions in the session directory (see PHP
 * 'session.save_path' option) are retrieved (no filter is applied).
 */
define('MOD_Z4M_USERSESSIONS_APPLICATION_URI', NULL);

/**
 * Color scheme applied to the User sessions view.
 * @var array|NULL Colors used to display the view. The expected array keys are
 * 'content', 'modal_content', 'list_border_bottom', 'msg_error',
 * 'modal_header', 'btn_hover', 'modal_footer_border_top', 'modal_footer',
 * 'btn_cancel', 'form_title', 'icon', 'tag' and 'btn_action'.
 * If NULL, default color CSS classes are applied.
 */
define('MOD_Z4M_USERSESSIONS_COLOR_SCHEME', NULL);

/**
 * Module version number
 * @return string Version
 */
define('MOD_Z4M_USERSESSIONS_VERSION_NUMBER','1.2');
/**
 * Module version date
 * @return string Date in W3C format
 */
define('MOD_Z4M_USERSESSIONS_VERSION_DATE','2025-06-15');