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
 * ZnetDK 4 Mobile User sessions module PHP class
 *
 * File version: 1.0
 * Last update: 04/24/2025
 */

namespace z4m_usersessions\mod;

/**
 * Retrieves session data from a PHP session file
 */
class UserSessionFile {
    protected $filePath;
    protected $sessionId;
    protected $fileModificationTimestamp;
    protected $sessionData;
    /**
     * Constructor of the UserSessionFile class
     * @param string|NULL $sessionFilePath Absolute file path of the user session
     * file. If is NULL, the session file is the one matching the current user's
     * session.
     * @throws \Exception File is missing or its name does not match a user
     * session file
     */
    public function __construct($sessionFilePath = NULL) {
        if (is_null($sessionFilePath)) {
            $sessionFilePath = session_save_path() . DIRECTORY_SEPARATOR . 'sess_' . session_id();
        }
        if (!file_exists($sessionFilePath)) {
            throw new \Exception("File '{$sessionFilePath}' does not exist.");
        }
        $basename = basename($sessionFilePath);
        $basenameParts = explode('_', $basename);
        if (count($basenameParts) !== 2 || $basenameParts[0] !== 'sess') {
            throw new \Exception("File '{$sessionFilePath}' does not match a session file name.");
        }
        $this->sessionId = $basenameParts[1];
        $this->fileModificationTimestamp = filemtime($sessionFilePath);
        $this->filePath = $sessionFilePath;
        $this->decodeSessionData();
    }

    /**
     * Decodes session data
     * @throws \Exception Unable to read file content or file content is empty.
     */
    protected function decodeSessionData() {
        $sessionData = file_get_contents($this->filePath);
        if (!is_string($sessionData)) {
            throw new \Exception("Unable to read content of the session file '{$this->filePath}'.");
        }
        if(strlen($sessionData) === 0) {
            throw new \Exception("Session file '{$this->filePath}' is empty.");
        }
        $decodedData = [];
        while ($i = strpos($sessionData, '|'))
        {
            $key = substr($sessionData, 0, $i);
            $value = unserialize(substr($sessionData, 1 + $i));
            $sessionData = substr($sessionData, 1 + $i + strlen(serialize($value)));
            $decodedData[$key] = $value;
        }
        $this->sessionData = $decodedData;
    }

    /**
     * Returns the PHP session ID
     * @return string The user PHP session ID.
     */
    public function getSessionId() {
        return $this->sessionId;
    }

    /**
     * Returns the modification time of the user session file
     * @return int Unix timestamp
     */
    public function getFileModificationTimestamp() {
        return $this->fileModificationTimestamp;
    }

    /**
     * Returns the unserialized user session data of the user session file
     * @return array The user session data of the user session file
     */
    public function getSessionData() {
        return $this->sessionData;
    }

    /**
     * Returns the session file path
     * @return string File path
     */
    public function getFilePath() {
        return $this->filePath;
    }

    /**
     * Checks if the session file matches the current user's session.
     * @return boolean Value TRUE if the session file matches the current user's
     * session, FALSE otherwise.
     */
    public function doesMatchCurrentUserSession() {
        return $this->sessionId === session_id();
    }

    /**
     * Removes the session file
     * @throws \Exception The session file can't be removed.
     */
    public function remove() {
        if (!unlink($this->filePath)) {
            throw new \Exception("Unable to remove '{$this->filePath}' session file.");
        }
    }

}
