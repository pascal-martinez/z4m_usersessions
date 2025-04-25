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
 * ZnetDK 4 Mobile User sessions module view fragment
 * 
 * File version: 1.0
 * Last update: 04/24/2025
 */
?>
<div id="z4m-user-sessions-settings-modal" class="w3-modal">
    <div class="w3-modal-content w3-card-4">
        <header class="w3-container <?php echo $color['modal_header']; ?>">
            <a class="close w3-button w3-xlarge <?php echo $color['btn_hover']; ?> w3-display-topright" href="javascript:void(0)" aria-label="<?php echo LC_BTN_CLOSE; ?>"><i class="fa fa-times-circle fa-lg" aria-hidden="true" title="<?php echo LC_BTN_CLOSE; ?>"></i></a>
            <h4>
                <i class="fa fa-cog fa-lg"></i>
                <span class="title"><?php echo MOD_Z4M_USERSESSIONS_SETTINGS_TITLE; ?></span>
            </h4>
        </header>
        <div class="w3-container <?php echo $color['modal_content']; ?>">
            <div class="w3-responsive w3-section">
                <table class="w3-table w3-bordered">
                    <thead>
                        <tr>
                            <th><?php echo MOD_Z4M_USERSESSIONS_SETTINGS_PARAMETER_COLUMN; ?></th>
                            <th><?php echo MOD_Z4M_USERSESSIONS_SETTINGS_GLOBAL_COLUMN; ?></th>
                            <th><?php echo MOD_Z4M_USERSESSIONS_SETTINGS_LOCAL_COLUMN; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="<?php echo $color['modal_footer']; ?>">
                            <th colspan="3"><?php echo MOD_Z4M_USERSESSIONS_SETTINGS_PHP_ROW; ?></th>
                        </tr>
<?php $sessionSettings = ['session.name', 'session.save_path', 'session.gc_maxlifetime', 'session.gc_probability',
    'session.gc_divisor', 'session.use_strict_mode'];
$sessionConfig = ini_get_all('session', TRUE);
foreach ($sessionSettings as $name) :
    $global = $sessionConfig[$name]['global_value'];
    $local = $sessionConfig[$name]['local_value']; ?>
                        <tr>
                            <td class="param"><a class="<?php echo $color['form_title']; ?>" href="https://www.php.net/manual/en/session.configuration.php#ini.<?php echo str_replace('_', '-', $name); ?>" target="_blank" title="Show documentation..."><?php echo $name; ?></a></td>
                            <th class="w3-monospace"><?php echo $global; ?></th>
                            <th class="w3-monospace"><?php echo $global === $local ? '-' : $local; ?></th>
                        </tr>
<?php endforeach; ?>
                        <tr class="<?php echo $color['modal_footer']; ?>">
                            <th colspan="3"><?php echo MOD_Z4M_USERSESSIONS_SETTINGS_ZNETDK_ROW; ?></th>
                        </tr>
<?php $znetdkSettings = ['CFG_SESSION_TIMEOUT' => 'z4m-settings-auth-session-timeout'];
if (defined('CFG_SESSION_ONLY_ONE_PER_USER')) {
    $znetdkSettings['CFG_SESSION_ONLY_ONE_PER_USER'] = 'z4m-settings-auth-session-only-one-per-user';
}
if (defined('CFG_IS_IN_MAINTENANCE')) {
    $znetdkSettings['CFG_IS_IN_MAINTENANCE'] = 'z4m-settings-is-in-maintenance';
}
foreach ($znetdkSettings as $zdkParamName => $anchor) : ?>
                        <tr>
                            <td class="param"><a class="<?php echo $color['form_title']; ?>" href="https://mobile.znetdk.fr/settings#<?php echo $anchor; ?>" target="_blank" title="Show documentation..."><?php echo $zdkParamName; ?></a></td>
                            <td class="w3-monospace">-</td>
                            <th class="w3-monospace"><?php echo is_bool(constant($zdkParamName)) ? (constant($zdkParamName) ? 'true' : 'false') : constant($zdkParamName); ?></th>
                        </tr>
<?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <footer class="w3-container w3-border-top w3-padding-16 <?php echo $color['modal_footer_border_top']; ?> <?php echo $color['modal_footer']; ?>">
            <button type="button" class="cancel w3-button <?php echo $color['btn_cancel']; ?>">
                <i class="fa fa-close fa-lg"></i>&nbsp;
                <?php echo LC_BTN_CLOSE; ?>
            </button>
        </footer>
    </div>
</div>