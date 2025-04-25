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
 * Retrieves ZnetDK 4 Mobile user session data from a PHP session file
 */
class Z4MUserSessionFile extends UserSessionFile {

    protected $loginName;
    protected $applicationKey;

    /**
     * Constructor of the Z4MUserSessionFile class
     * @param string|NULL $sessionFilePath Absolute file path of the user session
     * file. If is NULL, the session file is the one matching the current user's
     * session.
     * @param string|NULL $loginName Login name of the user to retrieve from the
     * user session file.
     * @param string|NULL $applicationKey Application key to read from the user
     * session file.
     * @throws \Exception File is missing or its name does not match a user
     * session file.
     */
    public function __construct($sessionFilePath = NULL, $loginName = NULL, $applicationKey = NULL) {
        parent::__construct($sessionFilePath);
        $this->loginName = $loginName;
        $this->applicationKey = $applicationKey;
    }

    /**
     * Convert the session data to a format suitable for display in a UI
     * Datatable.
     * @param boolean $withFilePath When TRUE, the session file path is returned
     * for each row.
     * @return array The rows extracted from the session data
     */
    public function convertSessionDataToDatalistRows($withFilePath = FALSE) {
        $decodedSessionData = $this->getSessionData();
        $returnedRows = [];
        if (!is_array($decodedSessionData)) {
            return $returnedRows;
        }
        $thisAppURI = MOD_Z4M_USERSESSIONS_APPLICATION_URI === NULL
                ? \General::getAbsoluteURI() : MOD_Z4M_USERSESSIONS_APPLICATION_URI;
        foreach ($decodedSessionData as $appKey => $sessionData) {
            if (!is_array($sessionData) || strpos($appKey, $thisAppURI) !== 0) {
                // This is not session data for this App
                continue;
            }
            $row = $this->extractInfosFromSessionData($sessionData, $appKey);
            if ($this->matchUser($row)) {
                if ($withFilePath) {
                    $row['file_path'] = $this->getFilePath();
                }
                $returnedRows[] = $row;
            }
        }
        return $returnedRows;
    }

    /**
     * Check if the session row matches a specific user.
     * @param array $row The session data as row
     * @return bool Returns FALSE if an application key and a login name are
     * specified in class constructor and don't match the values of the session
     * row.
     */
    protected function matchUser($row) {
        if (is_null($this->applicationKey)) {
            return TRUE;
        }
        if ($row['application_key'] === $this->applicationKey && (
                (key_exists('login_name', $row) && $row['login_name'] === $this->loginName))
                || (!key_exists('login_name', $row) && is_null($this->loginName))) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Formats session data
     * @param array $sessionData Session data of an application key
     * @param string $applicationKey Application key of the session data
     * @return array The session data formated as row for display
     */
    protected function extractInfosFromSessionData($sessionData, $applicationKey) {
        $sessionTimestamp = $this->getFileModificationTimestamp();
        $startDateTime = new \DateTime();
        $startDateTime->setTimestamp($sessionTimestamp);
        $lastTimeAccess = key_exists('last_time_access', $sessionData) ? $sessionData['last_time_access'] : FALSE;
        $endDateTime = self::calculateSessionEndDateTime($startDateTime, $lastTimeAccess);
        $returnedRow = array_intersect_key($sessionData, array_flip(['login_name', 'ip_address', 'user_name']));
        if (!key_exists('user_name', $returnedRow)) {
            $returnedRow['user_name'] = MOD_Z4M_USERSESSIONS_LIST_UNKNOWNUSER_LABEL;
        }
        $returnedRow['application_key'] = $applicationKey;
        $returnedRow['start_date_time'] = self::convertToLocaleDateTime($startDateTime);
        $returnedRow['session_timestamp'] = $sessionTimestamp;
        $returnedRow['access_mode'] = $lastTimeAccess === FALSE ? LC_FORM_LBL_PRIV_ACC : LC_FORM_LBL_PUBL_ACC;
        $returnedRow['end_date_time'] = self::convertToLocaleDateTime($endDateTime);
        $returnedRow['duration_before_expiration'] = self::calculateDurationBeforeExpiration($endDateTime);
        return $returnedRow;
    }

    /**
     * Calculates session end time from the session start time and the 
     * session.gc_maxlifetime. If session is opened in public mode, the last 
     * access time is used instead of session.gc_maxlifetime.
     * @param \DateTime $startDateTime Last session modification time
     * @param \DateTime|FALSE $lastTimeAccess Last time access 
     * @return \DateTime Calculated end time.
     */
    static protected function calculateSessionEndDateTime(\DateTime $startDateTime, $lastTimeAccess) {
        if ($lastTimeAccess === FALSE) { // Private access
            $endDateTime = clone $startDateTime;
            $maxLifeTime = ini_get('session.gc_maxlifetime'); // In seconds
            $endDateTime->add(new \DateInterval("PT{$maxLifeTime}S"));
        } else {
            $endDateTime = clone $lastTimeAccess;
            $sessionTimeout = CFG_SESSION_TIMEOUT; // In minutes
            $endDateTime->add(new \DateInterval("PT{$sessionTimeout}M"));
        }
        return $endDateTime;
    }

    /**
     * Calculates duration before expiration from now
     * @param \DateTime $endDateTime End date time
     * @return string Duration
     */
    static protected function calculateDurationBeforeExpiration($endDateTime) {
        $startDateTime = new \DateTime('now');
        $interval = $startDateTime->diff($endDateTime);
        return $interval->format('%r%H:%I:%S');
    }

    /**
     * Convert date time object to locale date and time for display
     * @param \DateTime $dateTimeObj Date time object to convert
     * @return string formated date
     */
    static protected function convertToLocaleDateTime($dateTimeObj) {
        return \Convert::toLocaleDate($dateTimeObj) . $dateTimeObj->format(' H:i:s');
    }

}
