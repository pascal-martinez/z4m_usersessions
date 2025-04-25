<?php

/*
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website https://www.znetdk.fr
 * Copyright (C) 2025 Pascal MARTINEZ (contact@znetdk.fr)
 * License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * --------------------------------------------------------------------
 * ZnetDK 4 Mobile User sessions module view
 *
 * File version: 1.0
 * Last update: 04/24/2025
 */
$color = defined('CFG_MOBILE_W3CSS_THEME_COLOR_SCHEME')
        ? CFG_MOBILE_W3CSS_THEME_COLOR_SCHEME
        : ['content' => 'w3-theme-light', 'modal_content' => 'w3-theme-light',
            'list_border_bottom' => 'w3-border-theme', 'msg_error' => 'w3-red',
            'modal_header' => 'w3-theme-dark', 'btn_hover' => 'w3-hover-theme',
            'modal_footer_border_top' => 'w3-border-theme',
            'modal_footer' => 'w3-theme-l4', 'btn_cancel' => 'w3-red',
            'form_title' => 'w3-text-theme', 'icon' => 'w3-text-theme',
            'tag' => 'w3-theme', 'btn_action' => 'w3-theme-action'
        ];
?>
<style>
    #z4m-user-sessions-list-header {
        position: sticky;
    }
    #z4m-user-sessions-list-header li {
        padding-top: 0;
        padding-bottom: 0;
    }
    .zdk-mobile-action.z4m_usersessions_clean {
        padding: 8px 14px;
    }
    #z4m-user-sessions-settings-modal td.param {
        white-space: nowrap;
    }
</style>
<!-- Header -->
<div id="z4m-user-sessions-list-header" class="w3-row <?php echo $color['content']; ?> w3-hide-small w3-hide-medium w3-border-bottom <?php echo $color['list_border_bottom']; ?>">
    <div class="w3-col l3 w3-padding-small"><b><?php echo MOD_Z4M_USERSESSIONS_LIST_MODIFTIME_LABEL; ?></b></div>
    <div class="w3-col l3 w3-padding-small"><b><?php echo MOD_Z4M_USERSESSIONS_LIST_USERNAME_LABEL; ?></b></div>
    <div class="w3-col l3 w3-padding-small"><b><?php echo MOD_Z4M_USERSESSIONS_LIST_LOGININFOS_LABEL; ?></b></div>
    <div class="w3-col l3 w3-padding-small"><b><?php echo MOD_Z4M_USERSESSIONS_LIST_ENDTIME_LABEL; ?></b></div>
</div>
<!-- Data List -->
<ul id="z4m-user-sessions-list" class="w3-ul w3-hide w3-margin-bottom" data-zdk-load="Z4MUserSessionsCtrl:all"
    data-action-cleanall="<?php echo MOD_Z4M_USERSESSIONS_ACTION_CLEANALL_LABEL; ?>"
    data-action-settings="<?php echo MOD_Z4M_USERSESSIONS_ACTION_SETTINGS_LABEL; ?>"
    data-question-cleanall="<?php echo MOD_Z4M_USERSESSIONS_ACTION_CLEANALL_QUESTION; ?>"
    data-question-killall="<?php echo MOD_Z4M_USERSESSIONS_ACTION_KILLALL_QUESTION; ?>"
    data-question-kill="<?php echo MOD_Z4M_USERSESSIONS_ACTION_KILL_QUESTION; ?>">
    <li class="<?php echo $color['list_border_bottom']; ?> w3-hover-light-grey">
        <div class="w3-row w3-stretch">
            <div class="w3-col s12 l3 m3 w3-padding-small w3-monospace"><b>{{start_date_time}}</b></div>
            <div class="w3-col s12 l3 m3 w3-padding-small">
                {{user_name}}
                <a class="kill" href="#" data-login-name="{{login_name}}" data-appkey="{{application_key}}" title="<?php echo MOD_Z4M_USERSESSIONS_LIST_KILLSESSION_LINK; ?>">
                    <i class="fa fa-times fa-fw w3-text-red"></i>
                </a>
            </div>
            <div class="w3-col s12 l3 m3 w3-padding-small">
                <div class="{{visibility}}">
                    <span class="w3-tag <?php echo $color['tag']; ?>">{{login_name}}</span>
                    <i class="fa fa-globe fa-lg <?php echo $color['icon']; ?>"></i> {{ip_address}}
                    <div class="w3-small">
                        <i class="fa fa-key <?php echo $color['icon']; ?>"></i> {{access_mode}}
                    </div>
                </div>
            </div>
            <div class="w3-col s12 l3 m3 w3-padding-small w3-monospace">
                {{end_date_time}}
                <div class="w3-small">
                    <span class="w3-tag {{duration_color}}">
                        <i class="fa fa-clock-o"></i> ({{duration_before_expiration}})
                    </span>
                </div>
            </div>
        </div>
    </li>
    <li><h3 class="<?php echo $color['msg_error']; ?> w3-center w3-stretch"><i class="fa fa-frown-o"></i>&nbsp;<?php echo LC_MSG_INF_NO_RESULT_FOUND; ?></h3></li>
</ul>
<?php
// Modal dialog for cleaning all sessions
require 'fragment/cleanall_modal.php';
// Modal dialog showing session settings
require 'fragment/settings_modal.php';
// Javascript tag
require 'fragment/jsscript.php';