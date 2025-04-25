# ZnetDK 4 Mobile module: User sessions (z4m_usersessions)
![Screenshot of the User sessions view provided by the ZnetDK 4 Mobile 'z4m_usersessions' module](https://mobile.znetdk.fr/applications/default/public/images/modules/z4m_usersessions/screenshot1.jpg?v1.0)
The **z4m_usersessions** module adds the ability to display PHP user sessions to the [ZnetDK 4 Mobile](/../../../znetdk4mobile) Starter application.

## LICENCE
This module is published under the [version 3 of GPL General Public Licence](LICENSE.TXT).

## FEATURES
![Screenshot of the User sessions configuration modal dialog of the 'z4m_usersessions' module](https://mobile.znetdk.fr/applications/default/public/images/modules/z4m_usersessions/screenshot2.jpg?v1.0)
- Shows the existing user sessions of the application,
- Displays the PHP and ZnetDK session configuration,
- Kills sessions of a specific user,
- Cleans expired sessions (via UI and a web service call),
- Kills all existing sessions (via UI and a web service call).

## REQUIREMENTS
- [ZnetDK 4 Mobile](/../../../znetdk4mobile) version 2.9 or higher,
- A **MySQL** database [is configured](https://mobile.znetdk.fr/getting-started#z4m-gs-connect-config) to store the application data,
- **PHP version 7.4** or higher,
- Authentication is enabled
([`CFG_AUTHENT_REQUIRED`](https://mobile.znetdk.fr/settings#z4m-settings-auth-required)
is `TRUE` in the App's
[`config.php`](/../../../znetdk4mobile/blob/master/applications/default/app/config.php)).

## INSTALLATION
1. Add a new subdirectory named `z4m_usersessions` within the
[`./engine/modules/`](/../../../znetdk4mobile/tree/master/engine/modules/) subdirectory of your
ZnetDK 4 Mobile starter App,
2. Copy module's code in the new `./engine/modules/z4m_usersessions/` subdirectory,
or from your IDE, pull the code from this module's GitHub repository,
3. Edit the App's [`menu.php`](/../../../znetdk4mobile/blob/master/applications/default/app/menu.php)
located in the [`./applications/default/app/`](/../../../znetdk4mobile/tree/master/applications/default/app/)
subfolder and add a new menu item definition for the view `z4m_usersessions`.
For example:  
```php
\MenuManager::addMenuItem(NULL, 'z4m_usersessions', MOD_Z4M_USERSESSIONS_MENU_LABEL, 'fa-ticket');
```
4. Go to the **User sessions** menu to display the users sessions. 

## USERS GRANTED TO MODULE FEATURES
Once the **User sessions** menu item is added to the application, you can restrict 
its access via a [user profile](https://mobile.znetdk.fr/settings#z4m-settings-user-rights).  
For example:
1. Create a user profile named `Admin` from the **Authorizations | Profiles** menu,
2. Select for this new profile, the **User sessions** menu item,
3. Finally for each allowed user, add them the `Admin` profile from the
**Authorizations | Users** menu. 

## RECOMMANDED USER SESSION CONFIGURATION
### PHP configuration
- [session.name](https://www.php.net/manual/en/session.configuration.php#ini.session.name): change `PHPSESSID` to a more common name. For example `id`.
- [session.save_path](https://www.php.net/manual/en/session.configuration.php#ini.session.save-path): a dedicated directory must be created to store the PHP session files of the application.
- [session.gc_maxlifetime](https://www.php.net/manual/en/session.configuration.php#ini.session.gc-maxlifetime): don't exceed if possible a value of `14400` seconds (4 hours).
- [session.use_strict_mode](https://www.php.net/manual/en/session.configuration.php#ini.session.use-strict-mode): recommended value is `1` for security purpose.
### ZnetDK configuration
- [CFG_SESSION_ONLY_ONE_PER_USER](https://mobile.znetdk.fr/settings#z4m-settings-auth-session-only-one-per-user): value `true` to avoid the same user to log in on multiple devices with the same login name.

## CLEANING OLD SESSIONS AUTOMATICALLY
It is recommended to clean expired PHP sessions every hour and to remove all PHP session files every day.
To do this, you can call the appropriate module web services from your crontab as shown below.

```
# Clean expired PHP sessions every hour 
47 * * * * nice curl "https://mydomain/myapp/?control=Z4MUserSessionsCtrl&action=clean" > /home/log/session_clean.log ?>&1
# Remove all PHP session files every day
09 23 * * * nice curl "https://webserviceusr:password@mydomain/myapp/?control=Z4MUserSessionsCtrl&action=killall" > /home/log/session_kill.log ?>&1
```
No authentication is necessary to call the `Z4MUserSessionCtrl:clean` controller action.

On the other hand, authentication is required to call the `Z4MUserSessionCtrl:killall` controller action as it is more sensitive.
For example, to authorize the user `webserviceusr` (you can name your web service user as you like) to run this web service, apply the procedure below:
1. Declare a new user named `webserviceusr` in the App. This user does not need any rights so be sure the option "Full menu access" is unchecked and no User profile is selected.
2. Define [`CFG_HTTP_BASIC_AUTHENTICATION_ENABLED`](https://mobile.znetdk.fr/settings#z4m-settings-webservices-basic-auth) constant to `TRUE` in the [`config.php`](/../../../znetdk4mobile/blob/master/applications/default/app/config.php) of your App.
```php
define('CFG_HTTP_BASIC_AUTHENTICATION_ENABLED', TRUE);
```
3. Configure access to the `Z4MUserSessionCtrl:killall` controller action through the [`CFG_ACTIONS_ALLOWED_FOR_WEBSERVICE_USERS`](https://mobile.znetdk.fr/settings#z4m-settings-webservices-actions-allowed) constant also defined in the [`config.php`](/../../../znetdk4mobile/blob/master/applications/default/app/config.php) of your App.
```php
define('CFG_ACTIONS_ALLOWED_FOR_WEBSERVICE_USERS', serialize([
    'webserviceusr|Z4MUserSessionCtrl:killall'
]));
```

## TRANSLATIONS
This module is translated in **French**, **English** and **Spanish** languages.  
To translate this module in another language or change the standard
translations:
1. Copy in the clipboard the PHP constants declared within the 
[`locale_en.php`](mod/lang/locale_en.php) script of the module,
2. Paste them from the clipboard within the
[`locale.php`](/../../../znetdk4mobile/blob/master/applications/default/app/lang/locale.php) script of your application,   
3. Finally, translate each text associated with these PHP constants into your own language.

## CHANGE LOG
See [CHANGELOG.md](CHANGELOG.md) file.

## CONTRIBUTING
Your contribution to the **ZnetDK 4 Mobile** project is welcome. Please refer to the [CONTRIBUTING.md](https://github.com/pascal-martinez/znetdk4mobile/blob/master/CONTRIBUTING.md) file.
