<?php
    class Faqs_model extends CMS_Base_Model {
        function __construct() {
            parent::__construct();
        }

        public function Faq_get_show() {
            $selectClause = " select Id,Question,Publish,Orders,DATE_FORMAT(CreatedDate,'%T %m-%d-%Y') as CreatedDate from faqs order by Orders, CreatedDate desc ";

            $result = $this -> db -> query($selectClause);

            if($result !== false) {
                return $result -> result_array();
            }
            return false;
        }

        public function getAll($limit_start=false,$limit_show=false,$whereClause = ' 1 = 1 ') {
        	$selectClause = " select Id,Question,Orders,Publish,DATE_FORMAT(CreatedDate,'%T %m-%d-%Y') as CreatedDate
    							from faqs where".
    								$whereClause
        						." order by CreatedDate desc limit ?,?";

    		$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

    		if($result -> num_rows() > 0) {
    			$returnData['faqs_list'] = $result -> result_array();
                $returnData['count'] = $this -> getCountOfAll();

                return $returnData;
    		}
    		return array();
        }

        public function getCountOfAll($whereClause = " 1 = 1 ") {
            $selectClause = " select count(Id) as count from faqs where ".$whereClause;

            $result = $this -> db -> query($selectClause);

            if($result -> num_rows() > 0) {
                $result = $result -> row_array();
                return $result['count'];
            }
            return 0;
        }

        public function getById($id = false) {
        	$selectClause = " select Id,Question,Question_en,Answer,Answer_en,Publish,Orders,IsShowFooter,
                                DATE_FORMAT(CreatedDate,'%T %m-%d-%Y') as CreatedDate,
                                DATE_FORMAT(ModifiedDate,'%T %m-%d-%Y') as ModifiedDate,
                                    (select Username from admin where UsersID = faqs.CreatedBy) as CreatedBy,
                                    (select Username from admin where UsersID = faqs.ModifiedBy) as ModifiedBy
                                        from faqs where Id = ? ";

        	$result = $this -> db -> query($selectClause,array($id));

        	if($result -> num_rows() > 0) {
    			return $result -> row_array();
    		}
    		return false;

        }

        public function updateOrder($id = false, $orders = false) {
            // $id = $this -> input -> post('id');
            // $orders = $this -> input -> post('orders');

            if($orders !== false && $id !== false) {
                $data = array('Orders' => (int)$orders);

                return $this -> db -> update('faqs',$data,array('Id' => $id));
            }

            return false;
        }

        private function check_input_fields() {
        	$this -> input -> post('Question') ? $Question = $this -> input -> post('Question') : $Question = "";
            $this -> input -> post('Answer') ? $Answer = $this -> input -> post('Answer') : $Answer = "";

            $this -> input -> post('Question_en') ? $Question_en = $this -> input -> post('Question_en') : $Question_en = "";
            $this -> input -> post('Answer_en') ? $Answer_en = $this -> input -> post('Answer_en') : $Answer_en = "";
            $this -> input -> post('Publish') ? $Publish = 1 : $Publish = 0;
            $this -> input -> post('IsShowFooter') ? $IsShowFooter = 1 : $IsShowFooter = 0;
            $this -> input -> post('Orders') ? $Orders = $this -> input -> post('Orders') : $Orders = 999;

            $data = array(
						'Question' => $Question,
						'Answer' => $Answer,
                        'Question_en' => $Question_en,
                        'Answer_en' => $Answer_en,
                        'Publish' => (int)$Publish,
                        'IsShowFooter' => (int)$IsShowFooter,
                        'Orders' => $Orders
					);

            return $data;
        }

        public function update($id = false) {
            if($id === false) {
                show_404();
            }else {
            	$receivedata = $this -> check_input_fields();
            	$data = array(
    						'Question' => $receivedata['Question'],
    						'Answer' => $receivedata['Answer'],
                            'Question_en' => $receivedata['Question_en'],
                            'Answer_en' => $receivedata['Answer_en'],
                            'Slug' => $this -> gen_slug($receivedata['Question'].' faq'.$id),
                            'Publish' => $receivedata['Publish'],
                            'IsShowFooter' => $receivedata['IsShowFooter'],
                            'Orders' => $receivedata['Orders']
						);

            	return $this -> db -> update('faqs',$data,array('Id' => $id));
            }
        }

        public function updatePublish($id = false,$Publish = false) {
            if($Publish !== false && $id !== false) {
                $data = array('Publish' => (int)$Publish,
                                'ModifiedBy' => $this -> session -> userdata('userid'),
                                'ModifiedDate' => date('Y-m-d H:i:s', time())
                            );

                return $this -> db -> update('faqs',$data,array('Id' => $id));
            }
            return false;
        }

        public function updateOrders($id = false,$Orders = false) {
            if($Orders !== false && $id !== false) {
                $data = array('Orders' => $Orders,
                                'ModifiedBy' => $this -> session -> userdata('userid'),
                                'ModifiedDate' => date('Y-m-d H:i:s', time())
                            );

                return $this -> db -> update('faqs',$data,array('Id' => $id));
            }
            return false;
        }

        public function insert() {
        	$receivedata = $this -> check_input_fields();
        	$data = array(
						'Question' => $receivedata['Question'],
						'Answer' => $receivedata['Answer'],
                        'Question_en' => $receivedata['Question_en'],
                        'Answer_en' => $receivedata['Answer_en'],
                        'Publish' => $receivedata['Publish'],
                        'IsShowFooter' => $receivedata['IsShowFooter'],
                        'Orders' => $receivedata['Orders']
					);

        	$this -> db -> insert('faqs',$data);

        	if($this -> db -> affected_rows() > 0) {
                $newestId = $this -> db -> insert_id();
                $this -> db -> update('faqs',array('Slug' => $this -> gen_slug($receivedata['Question'].' faq'.$newestId)),array('Id' =>$newestId) );
				return true;
            }
			return false;
        }

        public function delete($id = false) {
        	$this -> db -> delete('faqs',array('Id' => $id));

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
        }
    }
?>