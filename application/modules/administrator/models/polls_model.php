<?php
	class Polls_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function getAllPolls($limit_start=false,$limit_show=false,$whereClause = ' 1 = 1 ') {
			$selectClause = " select Id,Title,Finished,DATE_FORMAT(CreatedDate,'%T %m-%d-%Y') as CreatedDate
								from polls where ".$whereClause." order by CreatedDate desc limit ?,?";

			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			if($result -> num_rows() > 0 ) {
				return $result -> result_array();
			}

			return array();
		}

		public function getCountOfPolls($whereClause = ' 1 = 1 ') {
			$selectClause = " select count(Id) as count from polls where ".$whereClause;

			$result = $this -> db -> query($selectClause);

			$result = $result -> row_array();

			return $result['count'];
		}

		public function getPollById($id = false) {
			$selectClause = " select Id,Title,Title_en,Finished,DATE_FORMAT(CreatedDate,'%T %m-%d-%Y') as CreatedDate,
								 DATE_FORMAT(ModifiedDate,'%T %m-%d-%Y') as ModifiedDate,
								 (select Username from admin where UsersID = polls.CreatedBy) as CreatedBy,
						            (select Username from admin where UsersID = polls.ModifiedBy) as ModifiedBy
						            	from polls where Id = ? ";
			$result = $this -> db -> query($selectClause,array($id));

			if($result -> num_rows() >0) {
				$result = $result -> row_array();
				$result['answersList'] = $this -> getAllAnswerByPollId($id);
				return  $result;
			}
			return false;
		}

		public function getAllAnswer($limit_start=false,$limit_show=false,$whereClause = ' 1 = 1 ') {
			$selectClause = " select * from answers_poll where ".$whereClause." order by CreatedDate desc limit ?,? ";

			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			if($result -> num_rows() >0) {
				return $result -> result_array();
			}
			return array();

		}

		public function getCountOfAnswer($whereClause = ' 1 = 1 ') {
			$selectClause = " selct count(Id) as count from answers_poll where ".$whereClause;

			$result = $this -> db -> query($selectClause);

			$result = $result -> row_array();

			return $result['count'];
		}

		public function getAllAnswerByPollId($id = false) {
			$selectClause = " select ta.IdPoll,ta.IdAns,ta.Votes,an.Title,an.Title_en,DATE_FORMAT(an.CreatedDate,'%T %m-%d-%Y') as CreatedDate
								  from tally as ta left join answers_poll as an on ta.IdAns = an.Id where ta.IdPoll = ? ";
			$result = $this -> db -> query($selectClause,array($id));

			if($result -> num_rows() >0) {
				return $result -> result_array();
			}
			return array();
		}

		public function getAnswerById($id = false) {
			$selectClause = " select ta.IdPoll,ta.IdAns,ta.Votes,an.Title,an.Title_en,DATE_FORMAT(an.CreatedDate,'%T %m-%d-%Y') as CreatedDate
								  from tally as ta left join answers_poll as an on ta.IdAns = an.Id where ta.IdAns = ?";

			$result = $this -> db -> query($selectClause,array($id));

			if($result -> num_rows() >0) {
				return $result -> row_array();
			}
			return false;
		}

		private function check_poll_input_fields() {
			$this -> input -> post('Title') ? $Title = $this -> input -> post('Title') : $Title = "";
			$this -> input -> post('Title_en') ? $Title_en = $this -> input -> post('Title_en') : $Title_en = "";
			$this -> input -> post('Finished') ? $Finished = 1 : $Finished = 0;

			$data = array(
					'Title' => $Title,
					'Title_en' => $Title_en,
					'Finished' => $Finished
				);
			return $data;
		}

		private function check_answer_input_fields() {
			$this -> input -> post('Title') ? $Title = $this -> input -> post('Title') : $Title = "";
			$this -> input -> post('Title_en') ? $Title_en = $this -> input -> post('Title_en') : $Title_en = "";

			$data = array(
					'Title' => $Title,
					'Title_en' => $Title_en
				);
			return $data;
		}

		public function insertPoll() {
			$receivedata = $this -> check_poll_input_fields();
			$data = array(
					'Title' => htmlspecialchars($receivedata['Title']),
					'Title_en' => htmlspecialchars($receivedata['Title_en']),
					'Finished' => $receivedata['Finished'],
					'CreatedBy' => $this -> session -> userdata('userid') // get from session
			);

			$this -> db -> insert('polls',$data);

			if($this -> db -> affected_rows() > 0) {
				return true;
			}else {
				return false;
			}
		}

		public function updatePoll($id = false) {
			$receivedata = $this -> check_poll_input_fields();
			$data = array(
					'Title' => htmlspecialchars($receivedata['Title']),
					'Title_en' => htmlspecialchars($receivedata['Title_en']),
					'Finished' => $receivedata['Finished'],
					'ModifiedBy' => $this -> session -> userdata('userid'), // get from session
					'ModifiedDate' => date('Y-m-d H:i:s', time())
			);

			return $this -> db -> update("polls",$data,array("Id" => $id));
		}

		public function updateFinished() {

			$id = $this -> input -> post('id');
			$Finished = $this -> input -> post('Finished');
			if($Finished !== false && $id !== false) {
				$data = array('Finished' => (int)$Finished,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				return $this -> db -> update('polls',$data,array('Id' => $id));
			}
			return false;
		}

		public function insertAnswer($idPoll = false) {
			$receivedata = $this -> check_answer_input_fields();
			$data = array(
					'Title' => htmlspecialchars($receivedata['Title']),
					'Title_en' => htmlspecialchars($receivedata['Title_en']),
					'CreatedBy' => $this -> session -> userdata('userid') // get from session
			);

			$this -> db -> insert('answers_poll',$data);

			if($this -> db -> affected_rows() > 0) {
				$idInserted = $this -> db -> insert_id();
				$this -> db -> insert('tally',array('IdPoll' => $idPoll,'IdAns' => $idInserted));

				$objectReturn['answerObj'] = $this -> getAnswerById($idInserted);
				$objectReturn['pollChart'] = $this -> poll(false,$idPoll);


				return $objectReturn;
			}else {
				return false;
			}

		}

		public function updateAnswer($id = false,$idPoll = false) {
			$receivedata = $this -> check_answer_input_fields();
			$data = array(
					'Title' => htmlspecialchars($receivedata['Title']),
					'Title_en' => htmlspecialchars($receivedata['Title_en']),
					'ModifiedBy' => $this -> session -> userdata('userid'), // get from session
					'ModifiedDate' => date('Y-m-d H:i:s', time())
			);

			$yeah = $this -> db -> update('answers_poll',$data,array('Id' => $id));

			if($yeah) {
				$objectReturn['pollChart'] = $this -> poll(false,$idPoll);

				return $objectReturn;
			}else {
				return false;
			}

		}

		public function deletePoll($id = false) {

			$this -> db -> delete('polls',array('Id' => $id));

			if($this -> db -> affected_rows() > 0) {
				$this -> db -> where_in('Id',$this -> getAllAnswerForDelete($id));
				$this -> db -> delete('answers_poll');
				if($this -> db -> affected_rows() > 0) {
					$this -> db -> delete('tally',array('IdPoll' => $id));
				}
				return true;
			}else {
				return false;
			}
		}

		private function getAllAnswerForDelete($idPoll = false) {
			$selectClause = " select ta.IdAns from answers_poll as an inner join tally as ta on an.Id = ta.IdAns where ta.IdPoll = ? ";

			$result = $this -> db -> query($selectClause,array($idPoll));

			if($result -> num_rows() >0) {
				$result = $result -> result_array();
				$strId = '';
				if(!empty($result)) {

					$i = 0;
					foreach ($result as $item) {
						if($i > 0) {
							$result .= ", '".$item['IdAns']."' ";
						}else {
							$result .= " '".$item['IdAns']."' ";
						}
						$i++;
					}
				}

				return $strId;
			}
			return '';
		}

		public function deleteAnswer($id = false) {
			$this -> db -> delete('answers_poll',array('Id' => $id));

			if($this -> db -> affected_rows() > 0) {
				$this -> db -> delete('tally',array('IdAns' => $id));
				return true;
			}else {
				return false;
			}
		}


		public function poll($show_poll = false,$idPoll) {
		    // $replace = $show_poll ? $this->button : '';
		    // $this->footer = str_replace('%button%', $replace, $this->footer);

		    $centerHTML = '';
		    $centerHTML .= " <div class='webPoll'><ul>";
		    $results = $this -> getData($idPoll);
		    if(!empty($results)) {
			    if(!$show_poll) {
			        $totalVotes = $results['totalVotes'];
			        $results = $results['tallyList'];
			    }

			    for( $x=0; $x<count($results); $x++ ) {
			        $centerHTML .= $show_poll ? $this->pollLine($results,$x) : $this->voteLine($results[$x],$totalVotes);
			    }
			}

		    $centerHTML .= "</ul></div>";

		    return $centerHTML;
		    //echo $centerHTML;
		}
		private function pollLine($arrAnswer = array(),$x) {
		    isset($arrAnswer[$x]) ? $class = 'bordered' : $class = '';
		    $html =  "
				    <li class='$class'>
				            <label class='poll_active'>
				            <input type='radio' name='IdAns' value='".$arrAnswer[$x]."' />
				                {$this->answers[$x]}
				            </label>
				    </li>
				";
			return $html;
		}
		private function voteLine($result,$totalVotes) {
		    $votes = isset($result) ? $result['Votes'] : 0;
		    if($totalVotes == 0) {
		    	$percent = 0;
		    }else {
		    	$percent = round(($votes/$totalVotes)*100);
		    }
		    $width = $percent * 4;// * 2 de tang do dai div cho de nhin
		    $html = "
				    <li>
				            <div class='result' style='width:{$width}px;'>&nbsp;</div>{$percent}% ({$votes} votes)
				            <label class='poll_results'>
				                ".$result['Title']."
				            </label>
				    </li>
				";
			return $html;
		}

		private function getData($idPoll) {
		    // try {
		        // $dbh = new PDO('sqlite:voting.db');
		        // $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

		        // $STH = $dbh->prepare('SELECT AID, votes FROM tally WHERE QID = ?');
		        // $STH->execute(array($question_id));

		        $selectClause = " select ta.IdAns,Title, ta.Votes
		        					from tally as ta left join answers_poll as an on ta.IdAns = an.Id where ta.IdPoll = ? ";

		        $result = $this -> db -> query($selectClause,array($idPoll));

		        if($result -> num_rows() > 0) {
		        	$result_['tallyList'] = $result -> result_array();
		        	$totalVotes = 0;
		        	foreach ($result_['tallyList'] as $key) {
		        		$totalVotes += $key['Votes'];
		        	}
		        	$result_['totalVotes'] = $totalVotes;
		        	return $result_;
		        }else {
		        	return array();
		        }
		    // }
		    // catch(PDOException $e) {
		    //     # Error getting data, just send empty data set
		    //     return array(0);
		    // }

		    // foreach ($result as $key) {
		    // 	$results[$key['IdAns']] = $key['Votes'];
		    // }

		    // while($row = $STH->fetch()) {
		    //     $results[$row['AID']] = $row['votes'];
		    // }

		    // return $results;
		}
	}
?>
