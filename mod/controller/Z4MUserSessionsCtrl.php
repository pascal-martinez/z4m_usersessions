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
 * ZnetDK 4 Mobile User sessions module Controller class
 *
 * File version: 1.1
 * Last update: 06/10/2025
 */

namespace z4m_usersessions\mod\controller;

use \z4m_usersessions\mod\UserSessionManager;

class Z4MUserSessionsCtrl extends \AppController {

    /**
     * Checks whether the controller's action can be executed or not by the user
     * @param string $action Name of the controller's action
     * @return boolean If authentication is required, returns TRUE if:
     * - user has right on the 'z4m_usersessions' view actions whatever the
     *  action to execute,
     * - action is 'clean' or 'killall' and is executed as web service (GET
     * method).
     * Otherwise returns FALSE and so the action is not executed.
     */
    static public function isActionAllowed($action) {
        $status = parent::isActionAllowed($action);
        if ($status === FALSE) {
            return FALSE;
        }
        if ($action === 'clean' && \Request::getMethod() === 'GET') {
            return TRUE; // Session cleaning executed by webservice (GET method) is allowed
        }
        if ($action === 'killall' && \Request::getMethod() === 'GET') {
            return TRUE; // Call by webservice (GET method) is allowed (if authenticated)
        }
        $menuItem = 'z4m_usersessions';
        return CFG_AUTHENT_REQUIRED === TRUE
            ? \controller\Users::hasMenuItem($menuItem) // User has right on menu item
            : \MenuManager::getMenuItem($menuItem) !== NULL; // Menu item declared in 'menu.php'
    }

    /**
     * Returns the list of user sessions to the 'z4m_usersessions' view.
     * @return \Response JSON response containing the found sessions.
     */
    static protected function action_all() {
        $request = new \Request();
        $first = $request->first;
        $rowCount = $request->count;
        $response = new \Response();
        $rows = [];
        $isSessionSavePathReadable = UserSessionManager::getSessionDataFromFiles($rows);
        if (!$isSessionSavePathReadable) {
            $sessionSavePath = session_save_path();
            $rows[0]['summary'] = MOD_Z4M_USERSESSIONS_SETTINGS_PHP_ROW;
            $rows[0]['msg'] = \General::getFilledMessage(MOD_Z4M_USERSESSIONS_ACTION_SAVEPATHNOTREADABLE_WARN, "<b>{$sessionSavePath}</b>");
        }
        $response->total = count($rows);
        $response->rows = array_slice($rows, $first, $rowCount);
        return $response;
    }

    /**
     * Cleans the user sessions of the application.
     * No authentication is required when this action is executed as web service
     * (GET method).
     * @return \Response The number of sessions cleaned. 
     */
    static protected function action_clean() {
        $method = \Request::getMethod();
        $response = new \Response($method !== 'GET');
        $message = UserSessionManager::clean($method === 'GET');
        if ($method === 'GET') {
            $response->setCustomContent($message . PHP_EOL);
        } else {
            $response->setSuccessMessage(NULL, $message);
        }
        return $response;
    }

    /**
     * Kills the PHP sessions for the specified login name and application key.
     * @return \Response The numbter of sessions killed.
     */
    static protected function action_kill() {
        $request = new \Request();
        $response = new \Response();
        if ($request->application_key === NULL) {
            $response->setFailedMessage(NULL, LC_MSG_ERR_FORBIDDEN_ACTION_MESSAGE);
            return $response;
        }
        try {
            $count = UserSessionManager::killUserSessions($request->login_name, $request->application_key, FALSE);
            $response->setSuccessMessage(NULL, \General::getFilledMessage(MOD_Z4M_USERSESSIONS_ACTION_KILL_SUCCESS, $count));
        } catch (\Exception $ex) {
            \General::writeErrorLog(__METHOD__, $ex->getMessage());
            $response->setFailedMessage(NULL, MOD_Z4M_USERSESSIONS_ACTION_KILL_FAILED);
        }
        return $response;
    }

    /**
     * Kill all existing PHP sessions of the application.
     * This action can be called as web service (GET method) but authentication
     * is required.
     * @return \Response The number of sessions killed.
     */
    static protected function action_killall() {
        $request = new \Request();
        $response = new \Response();
        try {
            $message = UserSessionManager::killAll($request->preserve_current_session,
                    $request::getMethod()=== 'GET', $request::getMethod()=== 'GET');
            if ($request::getMethod()=== 'GET') {
                $response->setCustomContent($message . PHP_EOL);
            } else {
                $response->setSuccessMessage(NULL, $message);
            }
        } catch (\Exception $ex) {
            $response->setFailedMessage(NULL, $ex->getMessage());
        }
        return $response;
    }

}