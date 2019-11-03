<?php

	class NiceGraph {
		
		private $p_categories;
		private $p_series;
		private $p_showValues = true;
		private $p_fontFamily;
		private $p_fontSize;
		private $p_barWidth = 35;
		private $p_barLeftRadius = 0;
		private $p_barRightRadius = 0;
		private $p_categoryLeftRadius = 0;
		private $p_categoryRightRadius = 0;
		
		/**
		 * Constructor.
		 */
		public function __construct() {
		}
		
		/**
		 * Destructor.
		 */
		public function __destruct() {
		}
		
		//
		public function getCategories() {
			return $this -> p_categories;
		}
		
		//
		public function getSeries() {
			return $this -> p_series;
		}
		
		//
		public function getShowValues() {
			return $this -> p_showValues;
		}
		
		//
		public function getFontFamily() {
			return $this -> p_fontFamily;
		}
		
		//
		public function getFontSize() {
			return $this -> p_fontSize;
		}
		
		//
		public function getBarWidth() {
			return $this -> p_barWidth;
		}
		
		//
		public function getBarLeftRadius() {
			return $this -> p_barLeftRadius;
		}
		
		//
		public function getBarRightRadius() {
			return $this -> p_barRightRadius;
		}
		
		//
		public function getCategoryLeftRadius() {
			return $this -> p_categoryLeftRadius;
		}
		
		//
		public function getCategoryRightRadius() {
			return $this -> p_categoryRightRadius;
		}
		
		//
		public function setCategories($categories) {
			$this -> p_categories = $categories;
		}
		
		//
		public function setSeries($series) {
			$this -> p_series = $series;
		}
		
		//
		public function setShowValues($yesNo) {
			$this -> p_showValues = $yesNo;
		}
		
		//
		public function setFontFamily($ff) {
			$this -> p_fontFamily = $ff;
		}
		
		//
		public function setFontSize($fs) {
			$this -> p_fontSize = $fs;
		}
		
		//
		public function setBarWidth($width) {
			$this -> p_barWidth = $width;
		}
		
		//
		public function setBarLeftRadius($radius) {
			$this -> p_barLeftRadius = $radius;
		}
		
		//
		public function setBarRightRadius($radius) {
			$this -> p_barRightRadius = $radius;
		}
		
		//
		public function setBarRadius($radius) {
			$this -> p_barLeftRadius = $radius;
			$this -> p_barRightRadius = $radius;
		}
		
		//
		public function setCategoryLeftRadius($radius) {
			$this -> p_categoryLeftRadius = $radius;
		}
		
		//
		public function setCategoryRightRadius($radius) {
			$this -> p_categoryRightRadius = $radius;
		}
		
		//
		public function setCategoryRadius($radius) {
			$this -> p_categoryLeftRadius = $radius;
			$this -> p_categoryRightRadius = $radius;
		}
		
		
		
		//
		private function getMaxValue() {
			
			$maxValue = 0;
			
			foreach($this -> p_series as $serie) {
				foreach($serie -> getValues() as $value) {
					if($value > $maxValue) {
						$maxValue = $value;
					}
				}
			}
			
			return $maxValue;
		}
		
		
		
		//
		private static function drawBar($color, $width, $leftRadius, $rightRadius, $catLeftRadius, $catRightRadius, $leftLegend = null, $rightLegend = null, $value = null) {
			
			$view = '';
			
			$view .= '<tr>';
			
			$view .= '<td style="padding:2px;text-align:right;font-weight:bold;">';

			if($leftLegend !== null) {
				$view .= $leftLegend;
			}
			
			$view .= '</td>';
			
			$view .= '<td>';
			
			$style = 'font-family:Monospace;margin:2px;box-shadow: 4px 4px 2px grey;background-color:' . $color . ';';
			
			// Four values: first value applies to top-left, second value applies to top-right, third value applies to bottom-right, and fourth value applies to bottom-left corner
			if($leftRadius > 0 || $rightRadius > 0) {
				$style .= 'border-radius:' . $leftRadius . 'px ' .$rightRadius . 'px ' . $rightRadius . 'px ' . $leftRadius . 'px;';
			}

			$view .= '<span style="' . $style . '">';
			
			for($i = 0; $i < $width; ++$i) {
				$view .= '&nbsp;';
			}
			
			$view .= '</span>';
			
			//
			if($value !== null) {
				$view .= '&nbsp;' . $value;
			}
			
			$view .= '</td>';
			
			if($rightLegend !== null) {
				$view .= '<td>';
				
				$style = 'font-family:Monospace;margin:2px;box-shadow: 4px 4px 2px grey;background-color:' . $color . ';';
				
				if($catLeftRadius > 0 || $catRightRadius > 0) {
					$style .= 'border-radius:' . $catLeftRadius . 'px ' .$catRightRadius . 'px ' . $catRightRadius . 'px ' . $catLeftRadius . 'px;';
				}
				
				$view .= '<span style="' . $style . '">';
				$view .= '&nbsp;&nbsp;';
				$view .= '</span>';
				$view .= '&nbsp;' . $rightLegend;
				$view .= '</td>';
			}
			
			$view .= '</tr>';
			
			//
			return $view;
		}

		//
		public function drawHorizontal() {
			//
			$maxValue = $this -> getMaxValue();
			
			//
			$view = '';
			
			$view .= '<table style ="';
			
			if($this -> p_fontFamily !== null) {
				$view .= 'font-family:' . $this -> p_fontFamily . ';';
			}
			
			if($this -> p_fontSize !== null) {
				$view .= 'font-size:' . $this -> p_fontSize . ';';
			}
			
			$view .= '">';
			$view .= '<tbody>';
			
			if($this -> p_categories !== null) {
				for($i = 0; $i < count($this -> p_categories); ++$i) {
					//foreach($this -> p_series as $serie) {
					for($k = 0; $k < count($this -> p_series); ++$k) {
						$serie = $this -> p_series[$k];
						//$view .= self :: drawBar($serie -> getLegend(), $serie -> getColor(), $serie -> getValues()[$i], false, $this -> p_showValues, $i == 0);
						
						$view .= self :: drawBar(
							$serie -> getColor(),
							round($serie -> getValues()[$i] * $this -> p_barWidth / $maxValue),
							$this -> p_barLeftRadius,
							$this -> p_barRightRadius,
							$this -> p_categoryLeftRadius,
							$this -> p_categoryRightRadius,
							($k == 0 ? $this -> p_categories[$i] -> getLegend() : null),
							($i == 0 ? $serie -> getLegend() : null),
							($this -> p_showValues ? $serie -> getValues()[$i] : null)
						);
					}
					
					if($i < count($this -> p_categories) - 1) {
						$view .= '<tr><td>&nbsp;</td></tr>';
					}
				}
			}
			else {
				foreach($this -> p_series as $serie) {
					//$view .= self :: drawBar($serie -> getLegend(), $serie -> getColor(), $serie -> getValues()[0], true, $this -> p_showValues, true);

					$view .= self :: drawBar(
						$serie -> getColor(),
						round($serie -> getValues()[0] * $this -> p_barWidth / $maxValue),
						$this -> p_barLeftRadius,
						$this -> p_barRightRadius,
						$this -> p_categoryLeftRadius,
						$this -> p_categoryRightRadius,
						$serie -> getLegend(),
						null,
						($this -> p_showValues ? $serie -> getValues()[0] : null)
					);
				}
			}
			
			$view .= '</tbody>';
			$view .= '</table>';
			
			//
			return $view;
		}


	}

?>