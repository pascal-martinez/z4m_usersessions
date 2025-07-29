# CHANGE LOG: User sessions (z4m_usersessions)

## Version 1.3, 2025-06-27
- BUG FIXING: E_WARNING - unserialize(): Extra data starting at offset 406 of 1042 bytes - ./engine/modules/z4m_usersessions/mod/UserSessionFile.php(78)

## Version 1.2, 2025-06-15
- CHANGE: the module's PHP constant `MOD_Z4M_USERSESSIONS_APPLICATION_URI` now accepts the 'ALL' value to display all existing user sessions in the session directory (see PHP 'session.save_path' configuration).
- CHANGE: the value set for the module's PHP constant `MOD_Z4M_USERSESSIONS_APPLICATION_URI` is now displayed in the session configuration modal dialog.
- CHANGE: the application key is now displayed in the `z4m_usersessions` view (under the user name) when `MOD_Z4M_USERSESSIONS_APPLICATION_URI` is 'ALL'.

## Version 1.1, 2025-06-10
- CHANGE: code refactoring, new `UserSessionManager` class with `clean()` and `killAll()` public methods.

## Version 1.0, 2025-04-21
First version.