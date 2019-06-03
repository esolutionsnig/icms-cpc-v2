<?php
/**
 * Database.php
 * 
 * The Database class is meant to simplify the task of accessing
 * information from the website's database.
 *
 */

// Include the page header file
//$errMsg = "";
include 'constants.php';

      
class MySQLDB
{
   var $connection;         //The MySQL database connection
   var $num_active_users;   //Number of active users viewing site
   var $num_active_guests;  //Number of active guests viewing site
   var $num_members;        //Number of signed-up users
   // var $banned_members;     //Number of banned users
   /* Note: call getNumMembers() to access $num_members! */

   /* Class constructor */
   function MySQLDB(){
   
	  $this->connection = mysqli_connect(DB_SERVERe, DB_USERe, DB_PASSe, DB_NAMEe) or die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());

    /* Make connection to database */
  
    /**
     * Only query database to find out number of members
     * when getNumMembers() is called for the first time,
     * until then, default value set.
     */
    $this->num_members = -1;
	  $this->banned_members = -1;
	  $this->talent_users = -1;

      if(TRACK_VISITORS){
         /* Calculate number of users at site */
         $this->calcNumActiveUsers();
      
         /* Calculate number of guests at site */
         $this->calcNumActiveGuests();
      }
   }

   /**
    * confirmUserPass - Checks whether or not the given
    * username is in the database, if so it checks if the
    * given password is the same password in the database
    * for that user. If the user doesn't exist or if the
    * passwords don't match up, it returns an error code
    * (1 or 2). On success it returns 0.
    */
   function confirmUserPass($username, $password){
      /* Add slashes if necessary (for query) */
      if(!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }

      /* Verify that user is in database */
      $q = "SELECT password FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);
      if(!$result || (mysqli_num_rows($result) < 1)){
         return 1; //Indicates username failure
      }

      /* Retrieve password from result, strip slashes */
      $dbarray = mysqli_fetch_array($result);
      $dbarray['password'] = stripslashes($dbarray['password']);
      $password = stripslashes($password);

      /* Validate that password is correct */
      if($password == $dbarray['password']){
         return 0; //Success! Username and password confirmed
      }
      else{
         return 2; //Indicates password failure
      }
   }
   
   /**
    * confirmUserID - Checks whether or not the given
    * username is in the database, if so it checks if the
    * given userid is the same userid in the database
    * for that user. If the user doesn't exist or if the
    * userids don't match up, it returns an error code
    * (1 or 2). On success it returns 0.
    */
   function confirmUserID($username, $userid){
      /* Add slashes if necessary (for query) */
      if(!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }

      /* Verify that user is in database */
      $q = "SELECT userid FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);
      if(!$result || (mysqli_num_rows($result) < 1)){
         return 1; //Indicates username failure
      }

      /* Retrieve userid from result, strip slashes */
      $dbarray = mysqli_fetch_array($result);
      $dbarray['userid'] = stripslashes($dbarray['userid']);
      $userid = stripslashes($userid);

      /* Validate that userid is correct */
      if($userid == $dbarray['userid']){
         return 0; //Success! Username and userid confirmed
      }
      else{
         return 2; //Indicates userid invalid
      }
   }

   /**
    * confirmUserAccountApproval - Checks whether or not the given
    * username has been approved
    * (1 or 2). On success it returns 0.
    */
    function confirmUserAccountApproval($username){
      /* Add slashes if necessary (for query) */
      if(!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }

      /* Verify that user is in database */
      $q = "SELECT userid FROM ".TBL_USERS." WHERE username = '$username' AND registration_status = 'Approved' ";
      $result = mysqli_query($this->connection, $q);
      if(!$result || (mysqli_num_rows($result) < 1)){
         return 1; //Indicates username failure
      } else {
         return 0;
      }
   }
   
   /**
    * usernameTaken - Returns true if the username has
    * been taken by another user, false otherwise.
    */
   function usernameTaken($username){
      if(!get_magic_quotes_gpc()){
         $username = addslashes($username);
      }
      $q = "SELECT username FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);
      return (mysqli_num_rows($result) > 0);
   }
   
   /**
    * phonenoTaken - Returns true if the phone number has
    * been taken by another user, false otherwise.
    */
   function phonenoTaken($phoneno){
      if(!get_magic_quotes_gpc()){
         $phoneno = addslashes($phoneno);
      }
      $q = "SELECT phoneno FROM ".TBL_USERS." WHERE phoneno = '$phoneno'";
      $result = mysqli_query($this->connection, $q);
      return (mysqli_num_rows($result) > 0);
   }
   
   /**
    * emailTaken - Returns true if the email has
    * been taken by another user, false otherwise.
    */
   function emailTaken($email){
      if(!get_magic_quotes_gpc()){
         $email = addslashes($email);
      }
      $q = "SELECT email FROM ".TBL_USERS." WHERE email = '$email'";
      $result = mysqli_query($this->connection, $q);
      return (mysqli_num_rows($result) > 0);
   }
   
   /**
    * usernameBanned - Returns true if the username has
    * been banned by the administrator.
    */
   function usernameBanned($username){
      if(!get_magic_quotes_gpc()){
         $username = addslashes($username);
      }
      $q = "SELECT username FROM ".TBL_BANNED_USERS." WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);
      return (mysqli_num_rows($result) > 0);
   }
   
   /**
    * addNewUser - Inserts the given (username, password, email)
    * info into the database. Appropriate user level is set.
    * Returns true on success, false otherwise.
    */
   function addNewUser($username, $phoneno, $password, $email){
      $time = time();
      /* If admin sign up, give admin user level */
      if(strcasecmp($username, ADMIN_NAME) == 0){
         $ulevel = ADMIN_LEVEL;
      }else{
         $ulevel = C_LEVEL;
      }
      $q = "INSERT INTO ".TBL_USERS." VALUES ('$username', '$phoneno', '$password', '0', $ulevel, '$email', $time)";
      return mysqli_query($this->connection, $q);
   }
   
   /**
    * updateUserField - Updates a field, specified by the field
    * parameter, in the user's row of the database.
    */
   function updateUserField($username, $field, $value){
      $q = "UPDATE ".TBL_USERS." SET ".$field." = '$value' WHERE username = '$username'";
      return mysqli_query($this->connection, $q);
   }
   
   /**
    * getUserInfo - Returns the result array from a mysql
    * query asking for all information stored regarding
    * the given username. If query fails, NULL is returned.
    */
   function getUserInfo($username){
      $q = "SELECT * FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);
      /* Error occurred, return given name by default */
      if(!$result || (mysqli_num_rows($result) < 1)){
         return NULL;
      }
      /* Return result array */
      $dbarray = mysqli_fetch_array($result);
      return $dbarray;
   }
   
   
   /**
    * getUserProfile - Returns the result array from a mysql
    * query asking for all information stored regarding
    * the given username. If query fails, NULL is returned.
    */
   function getUserProfile($username){
      $q = "SELECT * FROM ".TBL_PROFILE." WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);
      /* Error occurred, return given name by default */
      if(!$result || (mysqli_num_rows($result) < 1)){
         return NULL;
      }
      /* Return result array */
      $dbarray = mysqli_fetch_array($result);
      return $dbarray;
   }
   
   function getUserOnly($username){
      $q = "SELECT username FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);
      /* Error occurred, return given name by default */
      if(!$result || (mysqli_num_rows($result) < 1)){
         return NULL;
      }
      /* Return result array */
      $dbarray = mysqli_fetch_array($result);
      return $dbarray;
   }
   
   
   /**
    * getNumMembers - Returns the number of signed-up users
    * of the website, banned members not included. The first
    * time the function is called on page load, the database
    * is queried, on subsequent calls, the stored result
    * is returned. This is to improve efficiency, effectively
    * not querying the database when no call is made.
    */
   function getNumMembers(){
      if($this->num_members < 0){
         $q = "SELECT * FROM ".TBL_USERS;
         $result = mysqli_query($this->connection, $q);
         $this->num_members = mysqli_num_rows($result);
      }
      return $this->num_members;
   }
   
   /**
    * newsEmailTaken - Returns true if the email has
    * been taken by another user, false otherwise.
    */
   function newsEmailTaken($email){
      if(!get_magic_quotes_gpc()){
         $email = addslashes($email);
      }
      $q = "SELECT nemail FROM ".TBL_NEWSLETTER." WHERE nemail = '$email'";
      $result = mysqli_query($this->connection, $q);
      return (mysqli_num_rows($result) > 0);
   }
   
   /**
    * getNumBannedMembers - Returns the number of banned users
    * of the website, banned members not included. The first
    * time the function is called on page load, the database
    * is queried, on subsequent calls, the stored result
    * is returned. This is to improve efficiency, effectively
    * not querying the database when no call is made.
    */
   function getNumBannedMembers(){
      if($this->banned_members < 0){
         $q = "SELECT * FROM ".TBL_BANNED_USERS;
         $result = mysqli_query($this->connection, $q);
         $this->banned_members = mysqli_num_rows($result);
      }
      return $this->banned_members;
   }

   
   /**
    * calcNumActiveUsers - Finds out how many active users
    * are viewing site and sets class variable accordingly.
    */
   function calcNumActiveUsers(){
      /* Calculate number of users at site */
      $q = "SELECT * FROM ".TBL_ACTIVE_USERS;
      $result = mysqli_query($this->connection, $q);
      $this->num_active_users = mysqli_num_rows($result);
   }
   
   /**
    * calcNumActiveGuests - Finds out how many active guests
    * are viewing site and sets class variable accordingly.
    */
   function calcNumActiveGuests(){
      /* Calculate number of guests at site */
      $q = "SELECT * FROM ".TBL_ACTIVE_GUESTS;
      $result = mysqli_query($this->connection, $q);
      $this->num_active_guests = mysqli_num_rows($result);
   }
   
   /**
    * addActiveUser - Updates username's last active timestamp
    * in the database, and also adds him to the table of
    * active users, or updates timestamp if already there.
    */
   function addActiveUser($username, $time){
      $q = "UPDATE ".TBL_USERS." SET timestamp = '$time' WHERE username = '$username'";
      mysqli_query($this->connection, $q);
      
      if(!TRACK_VISITORS) return;
      $q = "REPLACE INTO ".TBL_ACTIVE_USERS." VALUES ('$username', '$time')";
      mysqli_query($this->connection, $q);
      $this->calcNumActiveUsers();
   }
   
   /* addActiveGuest - Adds guest to active guests table */
   function addActiveGuest($ip, $time){
      if(!TRACK_VISITORS) return;
      $q = "REPLACE INTO ".TBL_ACTIVE_GUESTS." VALUES ('$ip', '$time')";
      mysqli_query($this->connection, $q);
      $this->calcNumActiveGuests();
   }
   
   /* These functions are self explanatory, no need for comments */
   
   /* removeActiveUser */
   function removeActiveUser($username){
      if(!TRACK_VISITORS) return;
      $q = "DELETE FROM ".TBL_ACTIVE_USERS." WHERE username = '$username'";
      mysqli_query($this->connection, $q);
      $this->calcNumActiveUsers();
   }
   
   /* removeActiveGuest */
   function removeActiveGuest($ip){
      if(!TRACK_VISITORS) return;
      $q = "DELETE FROM ".TBL_ACTIVE_GUESTS." WHERE ip = '$ip'";
      mysqli_query($this->connection, $q);
      $this->calcNumActiveGuests();
   }
   
   /* removeInactiveUsers */
   function removeInactiveUsers(){
      if(!TRACK_VISITORS) return;
      $timeout = time()-USER_TIMEOUT*60;
      $q = "DELETE FROM ".TBL_ACTIVE_USERS." WHERE timestamp < $timeout";
      mysqli_query($this->connection, $q);
      $this->calcNumActiveUsers();
   }

   /* removeInactiveGuests */
   function removeInactiveGuests(){
      if(!TRACK_VISITORS) return;
      $timeout = time()-GUEST_TIMEOUT*60;
      $q = "DELETE FROM ".TBL_ACTIVE_GUESTS." WHERE timestamp < $timeout";
      mysqli_query($this->connection, $q);
      $this->calcNumActiveGuests();
   }
   
   
   /**
    * getAllUsers - Returns the result array from a mysql
    * query asking for all information stored in users table. 
	* If query fails, NULL is returned.
    */
   function getAllUsers(){
      $q = "SELECT * FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);
      /* Error occurred, return given name by default */
      if(!$result || (mysqli_num_rows($result) < 1)){
         return NULL;
      }
      /* Return result array */
      $dbarray = mysqli_fetch_array($result);
      return $dbarray;
   }
   
 
   
   
   /**
    * userAlreadyUploaded - Returns true if the username exist 
    */
   function userAlreadyUploaded($username){
      $q = "SELECT username FROM ".TBL_PHOTOMODART." WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);
      return (mysqli_num_rows($result) > 0);
   }
   
   
   /*
    * getFileExtension - Returns the file extension
	*/
	function getFileExtension($path){
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		return $ext;
	} 
   
   
   /**
    * query - Performs the given query on the database and
    * returns the result, which may be false, true or a
    * resource identifier.
    */
   function query($query){
      return mysqli_query($this->connection, $query);
   }
   	
};

/* Create database connection */
$database = new MySQLDB;

?>
