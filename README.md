# Noindex Manager

Displays a small Dashboard widget to remind logged-in Admin users of their server SFTP login information for easy reference (uses defined constants).

* [Plugin Homepage (LittleBizzy.com)](https://www.littlebizzy.com/plugins/noindex-manager)

### Defined Constants

    /** Plugin Meta */
    define('DISABLE_NAG_NOTICES', true);
    
    /** Noindex Manager Functions */
    define('NOINDEX_MANAGER', true); // default = true
    define('NOINDEX_TAGS', true); // default = true
    define('NOINDEX_CATEGORIES', false); // default = false
    define('NOINDEX_AUTHORS', true); // default = true
    define('NOINDEX_PAGES', '1,2,3'); // default = NULL
    define('NOINDEX_POSTS', '1,2,3'); // default = NULL

### Compatibility

This plugin has been designed for use on [SlickStack](https://slickstack.io) web servers with PHP 7.2 and MySQL 5.7 to achieve best performance. All of our plugins are meant for single site WordPress installations only — for both performance and usability reasons, we strongly recommend avoiding WordPress Multisite for the vast majority of your projects.

Any of our WordPress plugins may also be loaded as "Must-Use" plugins (meaning that they load first, and cannot be deactivated) by using our free [Autoloader](https://github.com/littlebizzy/autoloader) script in the `mu-plugins` directory.

### Support Issues

Please do not submit Pull Requests. Instead, kindly create a new Issue with relevant information if you are an experienced developer, otherwise you may become a [**LittleBizzy.com Member**](https://www.littlebizzy.com/members) if your company requires official support.
