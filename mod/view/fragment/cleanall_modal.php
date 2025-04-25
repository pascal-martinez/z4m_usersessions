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
<div id="z4m-user-sessions-cleanall-modal" class="w3-modal">
    <div class="w3-modal-content w3-card-4">
        <header class="w3-container <?php echo $color['modal_header']; ?>">
            <a class="close w3-button w3-xlarge <?php echo $color['btn_hover']; ?> w3-display-topright" href="javascript:void(0)" aria-label="<?php echo LC_BTN_CLOSE; ?>"><i class="fa fa-times-circle fa-lg" aria-hidden="true" title="<?php echo LC_BTN_CLOSE; ?>"></i></a>
            <h4>
                <i class="fa fa-paint-brush fa-lg"></i>
                <span class="title"><?php echo MOD_Z4M_USERSESSIONS_ACTION_CLEANALL_LABEL; ?></span>
            </h4>
        </header>
        <form class="w3-container <?php echo $color['modal_content']; ?>">
            <input type="hidden" name="id">
            <div class="w3-section">
                <fieldset>
                    <legend>
                        <b>&nbsp;<?php echo MOD_Z4M_USERSESSIONS_FORM_CLEANALL_LEGEND; ?>&nbsp;</b>
                    </legend>
                    <label class="w3-show-block w3-section">
                        <input class="w3-radio" type="radio" name="cleaning_mode" value="clean_expired" checked>
                        <?php echo MOD_Z4M_USERSESSIONS_FORM_CLEANALL_ONLY_EXPIRED_LABEL; ?>
                    </label>
                    <label class="w3-show-block w3-section">
                        <input class="w3-radio" type="radio" name="cleaning_mode" value="kill_all">
                        <?php echo MOD_Z4M_USERSESSIONS_FORM_CLEANALL_ALL_SESSIONS_LABEL; ?>
                    </label>
                </fieldset>
            </div>
            <!-- Submit button -->
            <p class="w3-padding"></p>
            <button class="w3-button w3-block <?php echo $color['btn_submit']; ?> w3-section w3-padding" type="submit">
                <i class="fa fa-check fa-lg"></i>&nbsp;
                <?php echo LC_BTN_VALIDATE; ?>
            </button>
        </form>
        <footer class="w3-container w3-border-top w3-padding-16 <?php echo $color['modal_footer_border_top']; ?> <?php echo $color['modal_footer']; ?>">
            <button type="button" class="cancel w3-button <?php echo $color['btn_cancel']; ?>">
                <i class="fa fa-close fa-lg"></i>&nbsp;
                <?php echo LC_BTN_CLOSE; ?>
            </button>
        </footer>
    </div>
</div>
