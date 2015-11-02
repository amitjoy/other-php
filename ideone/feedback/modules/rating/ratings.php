<?php
//------------------------------------------------------------
// instantiate sessions
//------------------------------------------------------------ 
if(!isset($_SESSION)){
  session_start();
}

//------------------------------------------------------------
// GET OR SET VOTES
//------------------------------------------------------------
$rating = new ratings($_POST['widget_id']);
$counter = 0;
$max_votes = 2;
if(isset($_POST['fetch']))
{ 
	$rating->get_ratings();
}
elseif(!isset($_SESSION['voted']))
{
	$rating->vote();
	$_SESSION['voted'] = $counter + 1;
}
elseif(isset($_SESSION['voted']) && $_SESSION['voted'] <= $max_votes - 1)
{
	$rating->vote();
	$_SESSION['voted'] += 1;
}

//------------------------------------------------------------
// RATING CLASS
//------------------------------------------------------------
class ratings 
{
    var $data_file = 'ratings.data.php';
    private $widget_id;
    private $data = array();

	function __construct($wid) 
	{
		$this->widget_id = $wid;
		$all = file_get_contents($this->data_file);
		
		if($all)
		{
			$this->data = unserialize($all);
		}
	}

	public function get_ratings() 
	{
		if($this->data[$this->widget_id]) 
		{
			echo json_encode($this->data[$this->widget_id]);
		}
		else 
		{
			$data['widget_id'] = $this->widget_id;
			$data['number_votes'] = 0;
			$data['total_points'] = 0;
			$data['dec_avg'] = 0;
			$data['whole_avg'] = 0;
			echo json_encode($data);
		} 
	}

	public function vote() 
	{
		// Get the value of the vote
		preg_match('/star_([1-5]{1})/', $_POST['clicked_on'], $match);
		$vote = $match[1];
		
		$ID = $this->widget_id;
		
		// Update the record if it exists
		if($this->data[$ID]) 
		{
			$this->data[$ID]['number_votes'] += 1;
			$this->data[$ID]['total_points'] += $vote;
		}
		// Create a new one if it doesn't
		else 
		{
			$this->data[$ID]['number_votes'] = 1;
			$this->data[$ID]['total_points'] = $vote;
		}
		
		$this->data[$ID]['dec_avg'] = round( $this->data[$ID]['total_points'] / $this->data[$ID]['number_votes'], 1 );
		$this->data[$ID]['whole_avg'] = round( $this->data[$ID]['dec_avg'] );

		file_put_contents($this->data_file, serialize($this->data));
		$this->get_ratings();
	}
}
?>