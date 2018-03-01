<?php
    class Testimonials_model extends CMS_Base_Model {
        function __construct() {
            parent::__construct();
        }

        public function Testimonials_get_show() {
            $selectClause = " select * from testimonials where Publish = 1 order by Orders, CreatedDate desc ";

            $result = $this -> db -> query($selectClause);

            if($result -> num_rows() > 0) {
                return $result -> result_array();
            }
            return array();
        }

        public function Testimonials_get_all($limit_start=false,$limit_show=false,$whereClause = ' 1 = 1 ') {
        	$selectClause = " select TestimonialsID,FullName,CAST(Publish AS unsigned int) as Publish,
        						TestimonialContent,CreatedDate,Orders,
        							(select count(TestimonialsID) from testimonials where ".
                                            $whereClause
                                        ." ) as count
        								from testimonials where ".
        								    $whereClause
        								." order by Orders desc, CreatedDate desc limit ?,? ";
        	$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

        	if($result -> num_rows() > 0) {
    			return $result -> result_array();
    		}
    		return array();
        }

        public function getById($id = false) {
        	$selectClause = " select TestimonialsID,FullName,CAST(Publish AS unsigned int) as Publish,
        						TestimonialContent,TestimonialContent_en,CreatedDate,Orders
        								from testimonials where TestimonialsID = ? ";
        	$result = $this -> db -> query($selectClause,array($id));

        	if($result -> num_rows() > 0) {
    			return $result -> row_array();
    		}
    		return false;
        }

        public function updateOrders() {

            $this -> input -> post('Id') ? $Id = $this -> input -> post('Id') : $Id = 0;
            $this -> input -> post('Orders') ? $Orders = $this -> input -> post('Orders') : $Orders = 999;

            if($Orders !== false && $Id !== false) {
                $data = array('Orders' => (int)$Orders);

                return $this -> db -> update('testimonials',$data,array('TestimonialsID' => $Id));
            }

            return false;
        }

        public function updatePublish() {
            $this -> input -> post('Id') ? $Id = $this -> input -> post('Id') : $Id = 0;
            $this -> input -> post('Publish') ? $Publish = 1 : $Publish = 0;

            return $this -> db -> update('testimonials',array('Publish' => $Publish),array('TestimonialsID' => $Id));
        }

        private function Check_input_fields() {
        	$this -> input -> post('FullName') ? $FullName = $this -> input -> post('FullName') : $FullName = "";
            $this -> input -> post('Publish') ? $Publish = 1 : $Publish = 0;
            $this -> input -> post('Orders') ? $Orders = $this -> input -> post('Orders') : $Orders = 999;
            $this -> input -> post('TestimonialContent') ? $TestimonialContent = $this -> input -> post('TestimonialContent') : $TestimonialContent = "";
            $this -> input -> post('TestimonialContent_en') ? $TestimonialContent_en = $this -> input -> post('TestimonialContent_en') : $TestimonialContent_en = "";

            $data = array(
    					'FullName' => $FullName,
    					'Publish' => $Publish,
                        'Orders' => $Orders,
    					'TestimonialContent' => $TestimonialContent,
                        'TestimonialContent_en' => $TestimonialContent_en
    					);

            return $data;
        }

        public function update($id = false) {
        	$receivedata = $this -> Check_input_fields();
        	$data = array(
    					'FullName' => $receivedata['FullName'],
    					'Publish' => (int)$receivedata['Publish'],
                        'Orders' => (int)$receivedata['Orders'],
    					'TestimonialContent' => $receivedata['TestimonialContent'],
                        'TestimonialContent_en' => $receivedata['TestimonialContent_en']
    					);

        	return $this -> db -> update('testimonials',$data,array('TestimonialsID' => $id));
        }

        public function insert() {
        	$receivedata = $this -> Check_input_fields();
        	$data = array(
    					'FullName' => $receivedata['FullName'],
    					'Publish' => (int)$receivedata['Publish'],
                        'Orders' => (int)$receivedata['Orders'],
    					'TestimonialContent' => $receivedata['TestimonialContent'],
                        'TestimonialContent_en' => $receivedata['TestimonialContent_en']
    					);

        	$this -> db -> insert('testimonials',$data);

        	if($this -> db -> affected_rows() > 0)
    			return true;
    		return false;
        }

        public function delete($id = false) {
        	$this -> db -> delete('testimonials',array('TestimonialsID' => $id));

    		if($this -> db -> affected_rows() > 0)
    			return true;
    		return false;
        }

    }
?>
