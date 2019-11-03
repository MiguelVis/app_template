<?php

	class NiceGraphSerie {
		private $p_legend;
		private $p_color;
		private $p_values;
		
		/**
		 * Constructor.
		 */
		public function __construct($legend, $color, $values) {
			$this -> p_legend = $legend;
			$this -> p_color = $color;
			
			if(is_array($values)) {
				$this -> p_values = $values;
			}
			else {
				$this -> p_values = array($values);
			}
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
		public function getColor() {
			return $this -> p_color;
		}
		
		//
		public function getValues() {
			return $this -> p_values;
		}


	}

?>