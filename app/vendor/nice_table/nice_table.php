<?php

	// -----------------
	// NiceTable Library
	// -----------------
	
	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	// Revisions:
	// 16 May 2017 : mgl : Start.
	// 04 Jun 2017 : mgl : Added setGetParams().
	// 15 Jun 2017 : mgl : Added filter and sort icons. Added post parameters.
	// 03 Dec 2017 : mgl : Added NODES icon.
	// 04 Dec 2017 : mgl : Added USERS icon.
	
	/**
	 * NiceTable class.
	 */
	class NiceTable {
		
		// Constantes
		const ICON_INFO      = '!info';
		const ICON_EDIT      = '!edit';
		const ICON_PRINT     = '!print';
		const ICON_DELETE    = '!delete';
		const ICON_FILTER    = '!filter';
		const ICON_NODES     = '!nodes';
		const ICON_USERS     = '!users';
		const ICON_SORT      = '!sort';
		const ICON_SORT_ASC  = '!sortAsc';
		const ICON_SORT_DESC = '!sortDesc';
		
		// Global data for table object
		private $id      = '';
		private $columns = array();
		private $rows    = array();
		private $page    = 0;
		private $pages   = 0;
		
		private $pageLength = 10;
		
		private $sortBy    = '';
		private $sortOrder = '';
		
		private $getParams  = array();
		private $postParams = array();
		
		/**
		 * Table constructor.
		 *
		 */
		public function __construct($table){
			
			// Table ID
			$this->id = 'NiceTable_'.$table['id'];
			
			//
			$this->setColumns($table['columns']);
			$this->setRows($table['rows']);
			
			/*
			if(array_key_exists('pagination', $table)) {
				$this->setPages($table['pagination']['pages']);
				
				if(array_key_exists('page', $table['pagination'])) {
					$this->setPage($table['pagination']['page']);
				}
			}
			*/
			
			// Read parameters from previous form submit
			if(isset($_POST[$this->id.'_page'])) {
				// NiceTable_countries_page
				$this->setPage($_POST[$this->id.'_page']);
			}
			
			if(isset($_POST[$this->id.'_page_length'])) {
				// NiceTable_countries_page_length
				$this->setPageLength($_POST[$this->id.'_page_length']);
			}			
			
			if(isset($_POST[$this->id.'_sort_by'])) {
				// NiceTable_countries_sort_by
				$this->setSortBy($_POST[$this->id.'_sort_by']);
			}
			
			if(isset($_POST[$this->id.'_sort_order'])) {
				// NiceTable_countries_sort_order
				$this->setSortOrder($_POST[$this->id.'_sort_order']);
			}
			
		}
		
		/**
		 * Set columns.
		 *
		 * @param
		 */
		public function setColumns($table_columns) {
			$this->columns = $table_columns;
		}
		
		/**
		 * Set rows.
		 *
		 * @param
		 */
		public function setRows($table_rows) {
			$this->rows = $table_rows;
		}
		
		/**
		 * Set page number.
		 *
		 */
		 public function setPage($num) {
			 $this->page = $num;
		 }
		 
		 public function getPage() {
			 return $this->page;
		 }
		 
		 public function setPageLength($num) {
			 if($num != 10 && $num != 25 && $num != 50 && $num != 100) {
				 $num = 10;
			 }
			 
			 $this->pageLength = $num;
		 }
		 
		 public function getPageLength() {
			 return $this->pageLength;
		 }
		 
		 /**
		 * Set total pages.
		 *
		 */
		 public function setPages($num) {
			 $this->pages = $num;
		 }
		 
		 public function getPages() {
			 return $this->pages;
		 }
		 
		 public function setGetParams($pars) {
			 $this->getParams = (is_array($pars) ? $pars : array());
		 }
		 
		 public function setPostParams($pars) {
			 $this->postParams = (is_array($pars) ? $pars : array());
		 }
		 
		 public function setSortBy($field) {
			 $this->sortBy = $field;
		 }
		 
		 public function getSortBy() {
			 return $this->sortBy;
		 }
		 
		 public function setSortOrder($order) {
			 $this->sortOrder = $order;
		 }
		 
		 public function getSortOrder() {
			 return $this->sortOrder;
		 }
		
		/**
		 */
		public function draw() {
			// Pagination
			if($this->pages > 0) {
?>
	<div class="w3-bar" style="margin-bottom:8px">
		<div class="w3-cell-row">
			<div class="w3-cell">
				<?php say('NiceTableShow'); ?>
				<select class="w3-border"
					onchange="NiceTableSetPageLength('<?php echo($this->id); ?>', document.getElementById('<?php echo($this->id).'_page_length_selector'; ?>').value)"
					id="<?php echo($this->id.'_page_length_selector'); ?>">
					<option value="10"<?php if($this->pageLength == 10) echo(' selected'); ?>>10</option>
					<option value="25"<?php if($this->pageLength == 25) echo(' selected'); ?>>25</option>
					<option value="50"<?php if($this->pageLength == 50) echo(' selected'); ?>>50</option>
					<option value="100"<?php if($this->pageLength == 100) echo(' selected'); ?>>100</option>
				</select>
				<?php say('NiceTableEntries'); ?>
			</div>
		</div>
	</div>
<?php
			}
?>

    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white w3-card-4">
		<thead>
			<tr class="w3-blue">
<?php
			for($c = 0; $c < count($this->columns); ++$c) {
				$align = self::getAlign(isset($this->columns[$c]['titleAlign']) ? $this->columns[$c]['titleAlign'] : '');
?>
				<th<?php echo($align); ?>><?php
						echo($this->columns[$c]['title']);
						if(isset($this->columns[$c]['sortBy'])) {
							if($this->sortBy == $this->columns[$c]['sortBy']) {
								$sort_icon  = ($this->sortOrder == 'asc' ? self::ICON_SORT_ASC : self::ICON_SORT_DESC);
								$sort_color = 'black';
							}
							else {
								$sort_icon  = self::ICON_SORT;
								$sort_color = 'gray';
							}
							
							echo(
								self::drawIcon(
									$sort_icon,
									'NiceTableSort("'.$this->id.'","'.$this->columns[$c]['sortBy'].'","'.($sort_icon == self::ICON_SORT_ASC ? 'desc' : 'asc').'")',
									$sort_color
								)
							);
						}
					?></th>
<?php
			}
?>
			</tr>
		</thead>
<?php
			for($r = 0; $r < count($this->rows); ++$r) {
?>
		<tr>
<?php
				for($c = 0; $c < count($this->rows[$r]); ++$c) {
					$align = self::getAlign(isset($this->columns[$c]['align']) ? $this->columns[$c]['align'] : '');
?>
			<td<?php echo($align); ?>><?php echo($this->rows[$r][$c]); ?></td>
<?php
				}
?>
		</tr>
<?php
			}
?>
    </table>
<?php
			// Destination page
			$target = $_SERVER['PHP_SELF'];
			
			// Set GET params if any
			if(count($this->getParams) > 0) {
				$target .= '?';
				$i = 0;
				foreach($this->getParams as $key => $value) {
					if($i > 0) {
						$target .= '&';
					}
					$target .= $key . '=' . $value;
					
					++$i;
				}
			}
?>
	<form id="<?php echo($this->id.'_form'); ?>" method="post" action="<?php echo($target); ?>" style="margin-top:8px">
		<input type="hidden" name="<?php echo($this->id.'_page'); ?>" id="<?php echo($this->id.'_page'); ?>" value="<?php echo($this->page); ?>">
		<input type="hidden" name="<?php echo($this->id.'_page_length'); ?>" id="<?php echo($this->id.'_page_length'); ?>" value="<?php echo($this->pageLength); ?>">
		<input type="hidden" name="<?php echo($this->id.'_sort_by'); ?>" id="<?php echo($this->id.'_sort_by'); ?>" value="<?php echo($this->sortBy); ?>">
		<input type="hidden" name="<?php echo($this->id.'_sort_order'); ?>" id="<?php echo($this->id.'_sort_order'); ?>" value="<?php echo($this->sortOrder); ?>">
<?php
			// Set POST params if any
			if(count($this->postParams) > 0) {
				foreach($this->postParams as $key => $value) {
?>
		<input type="hidden" name="<?php echo($key); ?>" value="<?php echo($value); ?>">
<?php
				}
			}
?>
	</form>
<?php
			// Pagination
			if($this->pages > 0) {
?>
	<div class="w3-bar">
		<div class="w3-cell-row">
			<div class="w3-cell">
				<?php say('NiceTablePage'); ?> <?php echo($this->page + 1); ?> <?php say('NiceTableOf'); ?> <?php echo($this->pages); ?>.
			</div>
			<div class="w3-cell">
				<div class="w3-right-align">
<?php
				// |<<
				if($this->page > 0) {
					echo('<i class="fa fa-fast-backward fa-fw" onclick="NiceTableSetPage(\''.$this->id.'\', 0)" style="cursor: pointer"></i>');
				}
				else {
					echo('<i class="fa fa-fast-backward fa-fw w3-text-gray" onclick=""></i>');
				}
				
				// <<
				if($this->page > 0) {
					echo('<i class="fa fa-backward fa-fw" onclick="NiceTableSetPage(\''.$this->id.'\', '.($this->page - 1).')" style="cursor: pointer"></i>');
				}
				else {
					echo('<i class="fa fa-backward fa-fw w3-text-gray" onclick=""></i>');
				}
				
				// >>
				if($this->pages > 1 && $this->page < $this->pages - 1) {
					echo('<i class="fa fa-forward fa-fw" onclick="NiceTableSetPage(\''.$this->id.'\', '.($this->page + 1).')" style="cursor: pointer"></i>');
				}
				else {
					echo('<i class="fa fa-forward fa-fw w3-text-gray" onclick=""></i>');
				}
				
				// >>|
				if($this->pages > 1 && $this->page < $this->pages - 1) {
					echo('<i class="fa fa-fast-forward fa-fw" onclick="NiceTableSetPage(\''.$this->id.'\', '.($this->pages - 1).')" style="cursor: pointer"></i>');
				}
				else {
					echo('<i class="fa fa-fast-forward fa-fw w3-text-gray" onclick=""></i>');
				}
?>
				</div>
			</div>
		</div>
	</div>
<?php
			}
		}
		
		public static function drawIcon($icon, $onclick, $color = 'black') {
			switch($icon) {
				case self::ICON_INFO      : $fa = 'info';      $hoverColor = 'blue';  break;  // see question, eye
				case self::ICON_EDIT      : $fa = 'pencil';    $hoverColor = 'green'; break;  // see edit
				case self::ICON_PRINT     : $fa = 'print';     $hoverColor = 'brown'; break;
				case self::ICON_DELETE    : $fa = 'trash';     $hoverColor = 'red';   break;  // see remove
				case self::ICON_FILTER    : $fa = 'filter';    $hoverColor = 'green'; break;
				case self::ICON_NODES     : $fa = 'cubes';     $hoverColor = 'green'; break;  // see chain
				case self::ICON_USERS     : $fa = 'users';     $hoverColor = 'green'; break;
				case self::ICON_SORT      : $fa = 'sort';      $hoverColor = 'green'; break;
				case self::ICON_SORT_ASC  : $fa = 'sort-asc';  $hoverColor = 'green'; break;
				case self::ICON_SORT_DESC : $fa = 'sort-desc'; $hoverColor = 'green'; break;
				default                   : $fa = 'question';  $hoverColor = 'gray';  break;
			}
	
			return '<i class="w3-hover-none w3-hover-text-'.$hoverColor.' w3-show-inline-block w3-text-'.$color.' fa fa-'.$fa.' fa-fw th-fa-clickable"'.
			       ' onclick="'.str_replace('"', '\'', $onclick).';"></i>';
		}
		
		private static function getAlign($align) {
			switch($align) {
				case 'right'  : $align = ' class="w3-right-align"'; break;
				case 'center' : $align = ' class="w3-center"'; break;
				case 'left'   : // P'abajo
				default       : $align = ''; break;
			}
			
			return $align;
		}
	}
?>
