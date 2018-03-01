<?php
    class Testimonials_model extends CMS_Base_Model {
        function __construct() {
            parent::__construct();
        }

        public function getAll() {

        	global $lang;

			$selectClause = " select ";

			if($lang == 'vi') {
				$selectClause .= ' TestimonialContent, ';
			}else {
				$selectClause .= ' TestimonialContent_en as TestimonialContent, ';
			}

            $selectClause .= " FullName from testimonials where Publish = 1 order by Orders desc, CreatedDate desc ";

            $result = $this -> db -> query($selectClause);

            if($result -> num_rows() > 0) {
                return $result -> result_array();
            }
            return array();
        }
    }
?>