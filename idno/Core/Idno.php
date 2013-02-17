<?php

    /**
     * Base Idno class
     * 
     * @package idno
     * @subpackage core
     */

	namespace Idno\Core {
	    
	    class Idno extends \Idno\Common\Component {
		
		public $db;
		public $config;
		public $session;
		public $template;
		public static $site;
		
		function init() {
		    self::$site = $this;
		    $this->config = new Config();
		    $this->db = new DataConcierge();
		    $this->session = new Session();
		    $this->template = new Template();
		}
		
		/**
		 * Return the database layer loaded as part of this site
		 * @return \Idno\Core\DataConcierge
		 */

		    function &db() { return $this->db; }

		/**
		 * Helper function that returns the current configuration object
		 * for this site (or a configuration setting value)
		 * 
		 * @param The configuration setting value to retrieve (optional)
		 * 
		 * @return \Idno\Core\Config
		 */
		    function &config($setting = false) { 
			if ($setting === false)
			    return $this->config; 
			else
			    return $this->config->$setting;
		    }

		/**
		 * Return the session handler associated with this site
		 * @return \Idno\Core\Session
		 */

		    function &session() { return $this->session; }
		    
		/** 
		 * Return the template handler associated with this site
		 * @return \Idno\Core\Template
		 */
		    
		    function &template() { return $this->template; }
		
	    }
		
	    /**
	     * Helper function that returns the current site object
	     * @return Idno\Core\Idno
	     */
		function &site() {
		    return \Idno\Core\Idno::$site;
		}

	}