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
<script>
<?php if (CFG_DEV_JS_ENABLED) : ?>
    console.log("'z4m_usersessions.php' ** For debug purpose **");
<?php endif; ?>
$(function(){
    /**
     * Manages display of the 'z4m_usersessions.php' view
     */
    class Z4MUserSessions {
        #viewName = 'z4m_usersessions'
        #dataListSelector = '#z4m-user-sessions-list'
        #dataListHeaderSelector = '#z4m-user-sessions-list-header'
        #settingsModalSelector = '#z4m-user-sessions-settings-modal'
        #cleanAllModalSelector = '#z4m-user-sessions-cleanall-modal'
        #appControllerName = 'Z4MUserSessionsCtrl'
        #dataListObj
        #isFirstWarnMsgDisplay
        /**
         * Instantiates the class
         * @returns {Z4MUserSessions} 
         */
        constructor() {
            this.#isFirstWarnMsgDisplay = true;
            this.#dataListObj = z4m.list.make(this.#dataListSelector, true, false);
            this.#addActionButtons();
            this.#handleEvents();
        }
        /**
         * Customizes data row to display in the DataList
         * @param {Object} rowData row data to display in the DataList
         */
        #beforeInsertRowCall(rowData) {
            const isNegative = rowData.duration_before_expiration.startsWith("-");
            rowData.duration_color = isNegative ? 'w3-red' : 'w3-green';
            if (this.#isFirstWarnMsgDisplay && rowData.hasOwnProperty('summary') && rowData.hasOwnProperty('msg')) {
                z4m.messages.add('warn', rowData.summary, rowData.msg, false);
                this.#isFirstWarnMsgDisplay = false;
            }
            rowData.visibility = '';
            if (!rowData.hasOwnProperty('login_name')) {
                rowData.user_name = '<i>' + rowData.user_name + '</i>';
                rowData.login_name = null;
                rowData.ip_address = null;
                rowData.visibility = 'w3-hide';
            }
        }
        /**
         *  Adds the action buttons : Show settings and Clean sessions
         */
        #addActionButtons() {
            z4m.action.addCustomButton('z4m_usersessions_settings', 'fa-cog', 'w3-yellow', this.#dataListObj.element.data('action-settings'));
            z4m.action.addCustomButton('z4m_usersessions_clean', 'fa-paint-brush', 'w3-deep-orange', this.#dataListObj.element.data('action-cleanall'));
        }
        /**
        * Handle JavaScript events
        */
        #handleEvents() {
            const $this = this;
            // Before insert row in DataList
            this.#dataListObj.beforeInsertRowCallback = function(rowData) {
                $this.#beforeInsertRowCall(rowData);
            }
            // Action buttons
            z4m.action.registerView(this.#viewName, {
                z4m_usersessions_clean: {
                    isVisible: true,
                    callback: function () {
                        $this.#showCleanAllModal();
                    }
                },
                z4m_usersessions_settings: {
                    isVisible: true,
                    callback: function () {
                        $this.#showSettingsModal();
                    }
                }
            });
            // Kill session link
            $(this.#dataListObj.element).on('click.' + this.#viewName, 'a.kill', function(event){
                event.preventDefault();
                const loginName = $(this).data('login-name'),
                    appKey = $(this).data('appkey'),
                    userName = $(this).parent().text().trim();
                z4m.messages.ask($(this).attr('title'),
                    $this.#dataListObj.element.data('question-kill').replace('%1', '<b>' + userName + '</b>'), null, function(isYes){
                    if (isYes) {
                       $this.#killSession(loginName, appKey);
                    }
                });
            });
            // Clean all form submit
            $(this.#cleanAllModalSelector + ' form').on('submit.' + this.#viewName, function(event){
                event.preventDefault();
                const formObj = z4m.form.make($(this)), cleaningMode = formObj.getInputValue('cleaning_mode');
                if (cleaningMode === 'clean_expired') {
                    $this.#cleanExpiredSessions();
                } else if (cleaningMode === 'kill_all') {
                    $this.#killAllSessions();
                } else {
                    formObj.showError('Unknown cleaning mode!');
                }
            });
            // List header sticky position taking in account ZnetDK autoHideOnScrollEnabled property
            onTopSpaceChange();
            $('body').on('topspacechange.' + this.#viewName, onTopSpaceChange);
            function onTopSpaceChange() {
                $($this.#dataListHeaderSelector).css('top', z4m.header.autoHideOnScrollEnabled
                    ? 0 : z4m.header.getHeight());
            }
        }
        /**
         * Displays the settings modal 
         */
        #showSettingsModal() {
            const modal = z4m.modal.make(this.#settingsModalSelector);
            modal.open();
        }
        /**
         * Displays the Clean sessions modal 
         */
        #showCleanAllModal() {
            const modal = z4m.modal.make(this.#cleanAllModalSelector);
            modal.getInnerForm().reset();
            modal.open();
        }
        /**
         * Call PHP controller action in AJAX.
         * @param {string} actionName Controller action to execute
         * @param {Object} data In option, the data to pass to the controller
         * action
         * @param {string} closedModal The selector of the modal dialog to close
         * on success.
         */
        #callAction(actionName, data, closedModal) {
            const $this = this;
            let requestOptions = {
                controller: this.#appControllerName,
                action: actionName,
                callback: function(response) {
                    let modal = null;
                    if (typeof closedModal === 'string') {
                        modal = z4m.modal.make(closedModal);
                    }
                    if (response.success) {
                        if (modal !== null) {modal.close();}
                        $this.#dataListObj.refresh();
                        z4m.messages.showSnackbar(response.msg);
                    } else {
                        if (modal !== null) {
                            modal.getInnerForm().showError(response.msg);
                        } else {
                            z4m.messages.showSnackbar(response.msg, true);
                        }
                    }
                }
            };
            if (data !== null) {
                requestOptions.data = data;
            }
            z4m.ajax.request(requestOptions);
        }
        /**
         * Kills the session matching the specified login name and application key
         * @param {string} loginName The login name
         * @param {string} appKey The application key
         */
        #killSession(loginName, appKey) {
            this.#callAction('kill', {login_name: loginName, application_key: appKey});
        }
        /**
         * Kills all existing sessions
         */
        #killAllSessions() {
            const $this = this, modalTitle = $(this.#cleanAllModalSelector + ' header .title').text();
            z4m.messages.ask(modalTitle, this.#dataListObj.element.data('question-killall'), null, function(isYes){
                if (isYes) {
                   $this.#callAction('killall', {preserve_current_session: true}, $this.#cleanAllModalSelector);
                }
            });
        }
        /**
         * Cleans expired sessions.
         */
        #cleanExpiredSessions() {
            const $this = this, modalTitle = $(this.#cleanAllModalSelector + ' header .title').text();
            z4m.messages.ask(modalTitle, this.#dataListObj.element.data('question-cleanall'), null, function(isYes){
                if (isYes) {
                   $this.#callAction('clean', null, $this.#cleanAllModalSelector);
                }
            });
        }
    }
    new Z4MUserSessions();
});
</script>