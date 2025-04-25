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
 * File version: 1.0
 * Last update: 04/25/2025
 */

namespace z4m_usersessions\mod\controller;

use \z4m_usersessions\mod\Z4MUserSessionFile;

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
        $isSessionSavePathReadable = self::getSessionDataFromFiles($rows);
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
        $count = session_gc();
        $message = \General::getFilledMessage(MOD_Z4M_USERSESSIONS_ACTION_CLEAN_SUCCESS, $count);
        if ($method === 'GET') {
            session_destroy();
            $response->setCustomContent($message);
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
            $count = self::killUserSessions($request->login_name, $request->application_key, FALSE);
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
        if ($request::getMethod()=== 'GET') {
            // Call by web service: session data are saved before killing sessions
            session_write_close();
        }
        try {
            $count = self::killUserSessions(NULL, NULL, $request->preserve_current_session);
            $message = \General::getFilledMessage(MOD_Z4M_USERSESSIONS_ACTION_KILL_SUCCESS, $count);
            if ($request::getMethod()=== 'GET') {
                $response->setCustomContent($message);
            } else {
                $response->setSuccessMessage(NULL, $message);
            }
        } catch (\Exception $ex) {
            \General::writeErrorLog(__METHOD__, $ex->getMessage());
            if ($request::getMethod()=== 'GET') {
                $response->setCustomContent(MOD_Z4M_USERSESSIONS_ACTION_KILL_FAILED);
            } else {
                $response->setFailedMessage(NULL, MOD_Z4M_USERSESSIONS_ACTION_KILL_FAILED);
            }
        }
        return $response;
    }

    /**
     * Returns the PHP session files.
     * @return array The absolute file path of the session files found in the
     * the directory set to the PHP session.save_path parameter.
     */
    static protected function getSessionFiles() {
        $sessionSavePath = session_save_path();
        return glob($sessionSavePath . DIRECTORY_SEPARATOR . 'sess_*');
    }

    /**
     * Returns the file path of the current user's session
     * @return string Session file path
     */
    static protected function getCurrentSessionFile() {
        $currentSessionFile = new Z4MUserSessionFile();
        return $currentSessionFile->getFilePath();
    }

    /**
     * Extracts session data from session files and convert them to datatable
     * rows for display.
     * @param array $allSessionsData the datatable rows matching the session
     * data found.
     * @param string|NULL $loginName Optionally, the login name that the session
     * files should match.
     * @param string|NULL $applicationKey Optionally, the application key that
     * the session files should match.
     * @param boolean $withFilePath If TRUE, the session file path is added to
     * the returned rows.
     * @return bool Value TRUE if session files can be read within the directory
     * where session files are stored. FALSE otherwise.
     */
    static protected function getSessionDataFromFiles(array &$allSessionsData, $loginName = NULL, $applicationKey = NULL, $withFilePath = FALSE) {
        $sessionFiles = self::getSessionFiles();
        $isSessionSavePathReadable = TRUE;
        if (count($sessionFiles) === 0) {
            $sessionFiles = [self::getCurrentSessionFile()];
            $isSessionSavePathReadable = FALSE;
        }
        foreach ($sessionFiles as $filepath) {
            $sessionFile = new Z4MUserSessionFile($filepath, $loginName, $applicationKey);
            $rows = $sessionFile->convertSessionDataToDatalistRows($withFilePath);
            if (count($rows) > 0) {
                $allSessionsData = array_merge($allSessionsData, $rows);
            }
        }
        self::sortByModificationTime($allSessionsData);
        return $isSessionSavePathReadable;
    }

    /**
     * Sorts the specified rows by session file modification time in reverse
     * order.
     * @param array $rows The rows to sort.
     */
    static protected function sortByModificationTime(&$rows) {
        usort($rows, function ($a, $b){
            return $b['session_timestamp'] - $a['session_timestamp'];
        });
    }

    /**
     * Kills user sessions.
     * @param string $loginName Optional, the login name that session file
     * should match to be removed.
     * @param string $applicationKey Optional, the application key that session
     * file should match to be removed.
     * @param boolean $preserveCurrentSession When TRUE, the current user
     * session is preserved and not killed.
     * @return int Number of session files removed.
     * @throws \Exception No session file to remove for the specified login name
     * and application key.
     */
    static protected function killUserSessions($loginName = NULL, $applicationKey = NULL, $preserveCurrentSession = TRUE) {
        $rows = [];
        self::getSessionDataFromFiles($rows, $loginName, $applicationKey, TRUE);
        if (count($rows) === 0 && !is_null($loginName) && !is_null($applicationKey)) {
            throw new \Exception("No session to kill for user 'login_name={$loginName}' and 'application_key={$applicationKey}'.");
        }
        $count = 0;
        foreach ($rows as $row) {
            $sessionFile = new Z4MUserSessionFile($row['file_path']);
            if ($preserveCurrentSession && $sessionFile->doesMatchCurrentUserSession()) {
                continue;
            }
            $sessionFile->remove();
            $count++;
        }
        return $count;
    }

}