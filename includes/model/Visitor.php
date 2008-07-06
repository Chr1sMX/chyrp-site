<?php
	/**
	 * Class: Visitor
	 * The model for the currently browsing <User>. Group falls back to whatever group is set as the "Guest Group".
	 * See Also:
	 *     <User>
	 */
	class Visitor extends User {
		public $id = 0;

		/**
		 * Function: __construct
		 * Checks if a valid user is logged in.
		 */
		public function __construct() {
			if (isset($_SESSION['chyrp_login']) and isset($_SESSION['chyrp_password']))
				parent::__construct(null, array("where"  => array("`login` = :login",
				                                                  "`password` = :password"),
				                                "params" => array(":login"    => $_SESSION['chyrp_login'],
				                                                  ":password" => $_SESSION['chyrp_password'])));
		}

		/**
		 * Function: group
		 * Returns the user's <Group> or the "Guest Group".
		 */
		public function group() {
			if (!$this->id)
				return new Group(Config::current()->guest_group);
			else
				return new Group($this->group_id);
		}

		/**
		 * Function: current
		 * Returns a singleton reference to the current visitor.
		 */
		public static function & current() {
			static $instance = null;
			return $instance = (empty($instance)) ? new self() : $instance ;
		}
	}
