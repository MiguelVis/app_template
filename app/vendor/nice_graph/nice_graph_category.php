<?php

	class NiceGraphCategory {
		private $p_legend;
		
		/**
		 * Constructor.
		 */
		public function __construct($legend) {
			$this -> p_legend = $legend;
		}
		
		/**
		 * Destructor.
		 */
		public function __destruct() {
		}
		
		//
		public function getLegend() {
			return $this -> p_legend;
		}
		
		//
		public function setLegend($legend) {
			$this -> p_legend = $legend;
		}


	}

?>