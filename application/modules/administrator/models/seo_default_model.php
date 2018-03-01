<?php 
	class Seo_default_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Get_SEO_information() {
			$result = $this -> db -> get("seodefault");
			$arr = $result -> result_array();
			return $arr[0];
		}

		private function Check_input_field() {
			
			$this -> input -> post('seoPageTitle') ? $SEOTitle = $this -> input -> post('seoPageTitle') : $SEOTitle = "";
            $this -> input -> post('seoMetaKeywords') ? $SEOKeyword = $this -> input -> post('seoMetaKeywords') : $SEOKeyword = "";
            $this -> input -> post('seoMetaDesc') ? $SEODescription = $this -> input -> post('seoMetaDesc') : $SEODescription = "";

			$data = array(
					'SEOTitle' => $SEOTitle,
					'SEOKeyword' => $SEOKeyword,
					'SEODescription' => $SEODescription
				);

			return $data;
		}

		public function Update_SEO_information() {
			$receivedata = $this -> Check_input_field();
			
			$data = array(
				'SEOTitle' => $receivedata['SEOTitle'],
				'SEOKeyword' => $receivedata['SEOKeyword'],
				'SEODescription' => $receivedata['SEODescription']
			);
			
			$this -> db -> update("seodefault",$data,array("SeoDefaultID" => 1));

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}
	}
?>