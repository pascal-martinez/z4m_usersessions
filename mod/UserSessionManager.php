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
 * ZnetDK 4 Mobile User sessions class
 *
 * File version: 1.0
 * Last update: 06/10/2025
 */

namespace z4m_usersessions\mod;

/**
 * Management of user sessions
 */
class UserSessionManager {

    /**
     * Clean expired user sessions by calling the PHP session_gc() function.
     * @param boolean $isCurrentSessionDestroyed When set to TRUE, the current
     * user session is destroyed (PHP session_destroy() function) after session
     * cleaning.
     * @return string Message indicating the number of cleaned sessions. 
     */
    static public function clean($isCurrentSessionDestroyed) {
        $count = session_gc();
        if ($isCurrentSessionDestroyed) {
            session_destroy();
        }
        return \General::getFilledMessage(MOD_Z4M_USERSESSIONS_ACTION_CLEAN_SUCCESS, $count);
    }

    /**
     * Kill all user sessions.
     * @param boolean $preserveCurrentSession When TRUE, current session is not
     * killed.
     * @param boolean $doesWriteAndCloseSession When TRUE, the current session
     * data is stored and closed (session_write_close() PHP function) before
     * killing the sessions.
     * @param boolean $silent When TRUE, no Exception is thrown and the error
     * message is returned by the function.
     * @return string Message indicating the number of killed sessions.
     * @throws \Exception Session killing failed
     */
    static public function killAll($preserveCurrentSession, $doesWriteAndCloseSession, $silent) {
        if ($doesWriteAndCloseSession === TRUE) {
            session_write_close();
        }
        try {
            $count = self::killUserSessions(NULL, NULL, $preserveCurrentSession);
            return \General::getFilledMessage(MOD_Z4M_USERSESSIONS_ACTION_KILL_SUCCESS, $count);
        } catch (\Exception $ex) {
            \General::writeErrorLog(__METHOD__, $ex->getMessage());
            if ($silent === TRUE) {
                return MOD_Z4M_USERSESSIONS_ACTION_KILL_FAILED;
            }
            throw new \Exception(MOD_Z4M_USERSESSIONS_ACTION_KILL_FAILED);
        }
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
    static public function getSessionDataFromFiles(array &$allSessionsData, $loginName = NULL, $applicationKey = NULL, $withFilePath = FALSE) {
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
    static public function killUserSessions($loginName = NULL, $applicationKey = NULL, $preserveCurrentSession = TRUE) {
        $rows = [];
        self::getSessionDataFromFiles($rows, $loginName, $applicationKey, TRUE);
        if (count($rows) === 0 && !is_null($loginName) && !is_null($applicationKey)) {
            throw new \Exception("No session to kill for user 'login_name={$loginName}' and 'application_key={$applicationKey}'.");
        }
        $count = 0;
        foreach ($rows as $row) {
            $sessionFile = new Z4MUserSessionFile($row['file_path']);
            if ($preserveCurrentSession === TRUE && $sessionFile->doesMatchCurrentUserSession()) {
                continue;
            }
            $sessionFile->remove();
            $count++;
        }
        return $count;
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
     * Sorts the specified rows by session file modification time in reverse
     * order.
     * @param array $rows The rows to sort.
     */
    static protected function sortByModificationTime(&$rows) {
        usort($rows, function ($a, $b){
            return $b['session_timestamp'] - $a['session_timestamp'];
        });
    }

}
