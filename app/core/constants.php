<?php
/**
 * Constants.php
 *
 * This file is intended to group all constants to
 * make it easier for the site administrator to tweak
 * the login script.
 */
 
/**
 * Database Constants - these constants are required
 * in order for there to be a successful connection
 * to the MySQL database. Make sure the information is
 * correct.
 */
define("DB_SERVERe", "localhost");
define("DB_USERe", "root");
define("DB_PASSe", "");
// define("DB_USERe", "printfac_admin");
// define("DB_PASSe", "*?G0DHELPME?*");
define("DB_NAMEe", "icms_cpc");
define("PROJECT_NAME", "iCMS - Cash Processing Center");
define("PROJECT_SHORT_NAME", "CPC");
define("PROJECT_COPYRIGHT", '<a class="red-text text-lighten-2" href="http://icms.ng" target="_blank">Integrated Cash Management Services</a> All rights reserved.</span>');
define("PROJECT_VERSION", '<span class="right hide-on-small-only"> Version: 1.01</span>');
define("PROJECT_SUBTITLE", "Cash Processing Center");
define("APP_VERSION", "App Version: iCMS-CPC 1.01");

/**
 * Database Table Constants - these constants
 * hold the names of all the database tables used
 * in the script.
 */
define("TBL_USERS", "users");
define("TBL_ACTIVE_USERS", "active_users");
define("TBL_ACTIVE_GUESTS", "active_guests");
define("TBL_BANNED_USERS", "banned_users");
define("TBL_PROFILE", "general");
define("TBL_COUNTRIES", "countries");
define("TBL_STATES", "states");
define("TBL_FEEDBACKS", "feedback");
define("TBL_NEWSLETTER", "newsletter");

/**
 * Application Skey - Used to generate secret key
 */
define("SKEYS", "icms-cpc");
define("SKEYZ", "ernest");


/**
 * Special Names and Level Constants - the admin
 * page will only be accessible to the user with
 * the admin name and also to those users at the
 * admin user level. Feel free to change the names
 * and level constants as you see fit, you may
 * also add additional level specifications.
 * Levels must be digits between 0-9.
 */


define("ADMIN", "Admin Officer");
define("S_ADMIN", "Super Admin");
define("EXECUTIVE", "Executive");
define("MANAGERS", "Manager");
define("ACCOUNTANTS", "Accountant");
define("HOU", "Head Of Units");
define("TREASURY_OFFICER", "Treasury Officer");
define("TREASURY_SUPERVISOR", "Treasury Supervisor");
define("CP_OFFICER", "Cash Processing Officer");
define("CP_ADMIN", "Cash Processing Admin");
define("CP_SUPERVISOR", "Cash Processing Supervisor");
define("V_OFFICER", "Vault Officer");
define("V_SUPERVISOR", "Vault Supervisor");
define("BR_OFFICER", "Box Room Officer");
define("BR_SUPERVISOR", "Box Room Supervisor");
define("CMO", "Cash Movement Officer");
define("BANKER_CMU", "Client Representative Supervisor (CMU)");
define("BANKER", "Client Representative");
define("GUEST_NAME", "Guest");
define("SA_LEVEL", 20);
define("A_LEVEL", 19);
define("ACC_LEVEL", 18);
define("BANKER_CMU_LEVEL", 15);
define("BANKER_LEVEL", 14);
define("CMO_LEVEL", 13);
define("BRS_LEVEL", 12);
define("E_LEVEL", 11);
define("M_LEVEL", 10);
define("HOU_LEVEL", 9);
define("TS_LEVEL", 8);
define("TO_LEVEL", 7);
define("CPA_LEVEL", 6);
define("CPS_LEVEL", 5);
define("CPO_LEVEL", 4);
define("VS_LEVEL", 3);
define("VO_LEVEL", 2);
define("BRO_LEVEL", 1);
define("GUEST_LEVEL", 0);

/**
 * This boolean constant controls whether or
 * not the script keeps track of active users
 * and active guests who are visiting the site.
 */
define("TRACK_VISITORS", true);

/**
 * Timeout Constants - these constants refer to
 * the maximum amount of time (in minutes) after
 * their last page fresh that a user and guest
 * are still considered active visitors.
 */
define("USER_TIMEOUT", 60);
define("GUEST_TIMEOUT", 5);

/**
 * Cookie Constants - these are the parameters
 * to the setcookie function call, change them
 * if necessary to fit your website. If you need
 * help, visit www.php.net for more info.
 * <http://www.php.net/manual/en/function.setcookie.php>
 */
// define("COOKIE_EXPIRE", 60*60*24*30);  //30 days lang
define("COOKIE_EXPIRE", 60*60*24*100);  //100 days by default
define("COOKIE_PATH", "/");  //Avaible in whole domain

/**
 * Email Constants - these specify what goes in
 * the from field in the emails that the script
 * sends to users, and whether to send a
 * welcome email to newly registered users.
 */
define("EMAIL_FROM_NAME", "Integrated Cash Management Services Limited");
define("EMAIL_FROM_ADDR", "no-reply@icms.ng");
define("EMAIL_WELCOME", false);

/**
 * This constant forces all users to have
 * lowercase usernames, capital letters are
 * converted automatically.
 */
define("ALL_LOWERCASE", false);
