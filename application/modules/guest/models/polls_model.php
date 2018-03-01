<?php
	class Polls_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function showPoll() {
			$selectClause = " select Id from polls where Finished = 0 order by ModifiedDate desc,CreatedDate desc limit 1 ";

			$result = $this -> db -> query($selectClause);

			if($result -> num_rows() >0) {
				$result = $result -> row_array();
				$yeah = $result['Id'].'-Poll';

				return isset($_COOKIE[md5($yeah)]) ? $this -> poll(false,$result['Id']) : $this -> poll(true,$result['Id']);
			}
			return '';
		}

		public function poll($show_poll = false,$idPoll) {
		    // $replace = $show_poll ? $this->button : '';
		    // $this->footer = str_replace('%button%', $replace, $this->footer);
			$results = $this -> getData($idPoll);
		    $centerHTML = '';

		    if(!empty($results)) {
		    	$tallyList = $results['tallyList'];
			    $centerHTML .= " <div class='webPoll'><ul>";
			    $centerHTML .= "<h4>".$tallyList[0]['pollTitle']."</h4>";

			    if(!$show_poll) {
			        $totalVotes = $results['totalVotes'];
			    }

			    for( $x=0; $x<count($tallyList); $x++ ) {
			        $centerHTML .= $show_poll ? $this->pollLine($tallyList[$x]) : $this->voteLine($tallyList[$x],$totalVotes);
			    }

			    $centerHTML .= "</ul>";
			    if($show_poll) {
			    	$centerHTML .= '<a class="btn-vote" href="javascript:void(0);" onclick="votePoll(\''.$idPoll.'\');" >Vote</a>';
			    }
			    $centerHTML .= "</div>";
		   	}

		    return $centerHTML;
		    //echo $centerHTML;
		}
		private function pollLine($item) {
		    isset($item) ? $class = 'bordered' : $class = '';
		    $html =  "
				    <li class='$class'>
				            <label class='poll_active'>
				            <input type='radio' name='IdAns' value='".$item['IdAns']."' />
				                {$item['Title']}
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

		public function vote() {
			// global $lang;

			$lang = $this -> session -> userdata('lang-sess-code');

			$idPoll = $this -> input -> post('idPoll');
			$idAns = $this -> input -> post('idAns');

			if( $idPoll === false || $idPoll === false || isset( $_COOKIE[md5($this -> input -> post('idPoll').'-Poll')] ) ) {
			    return $lang == 'vi' ? 'Bạn đã tham gia nhận xet, đánh giá này' : 'You are completed this poll';
			}
            $updateStatement = " update tally set Votes = Votes + 1 where IdPoll = ? and IdAns = ? ";

            $result = $this -> db -> query($updateStatement,array($idPoll,$idAns));
			if($result) {
				// $cookie = array(
				//     'name'   => md5($idPoll.'-Poll'),
				//     'value'  => 1,
				//     'expire' => '10',
				//     'domain' => '.phantichadn.com.vn',
				//     'path'   => '/',
				//     'prefix' => 'gentis',
				//     'secure' => TRUE
				// );
			 //    $this -> input -> set_cookie($cookie);
				//setcookie(md5($idPoll.'-Poll'), 1, time()+60,'phantichadn.com.vn','/');
				setcookie(md5($idPoll.'-Poll'), 1, time()+60*60*24*365,'/');
				// var_dump($_COOKIE[md5($idPoll.'-Poll')]);
    			$_COOKIE[md5($idPoll.'-Poll')] = 1;

    			// var_dump(md5($idPoll.'-Poll'));
			    // $this -> input -> cookie(md5($idPoll.'-Poll')) = 1;
			}

			return $this -> poll(false,$idPoll);
		}

		public function getData($idPoll) {
		    // try {
		        // $dbh = new PDO('sqlite:voting.db');
		        // $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

		        // $STH = $dbh->prepare('SELECT AID, votes FROM tally WHERE QID = ?');
		        // $STH->execute(array($question_id));
			$lang = $this -> session -> userdata('lang-sess-code');

				$selectClause = " select ";

				if($lang == 'vi') {
					$selectClause .= ' an.Title,po.Title as pollTitle, ';
				}else {
					$selectClause .= ' an.Title_en as Title,po.Title_en as pollTitle, ';
				}

		        $selectClause .= " ta.IdAns, ta.Votes
		        					from polls as po left join tally as ta on po.Id = ta.IdPoll left join answers_poll as an on ta.IdAns = an.Id where ta.IdPoll = ? ";

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
