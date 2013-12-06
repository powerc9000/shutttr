<? 
class Metric extends CI_Model {
	
	public function top_ten_commenters()
	  {
	     $this->db->select('user_id, count(user_id) as usercount');
	     $this->db->group_by('user_id');
	     $this->db->order_by('usercount', 'desc');
	     $this->db->limit('10');
	     $query = $this->db->get('comments');
	     $result = $query->result();
	     return $result;
	  }
	  public function daily_likes()
	  {
	  	$last_day_time = mktime(0, 0, 0, date("m"), date("d")-1,   date("Y"));
   		$start_day = date('Y-m-d 0:0:0', $last_day_time);
   		$end_day = date('Y-m-d 23:59:59', $last_day_time);
   		$this->db->where("timestamp >= '$start_day' AND timestamp <= '$end_day'");
   		$count = $this->db->count_all_results('likes');
   		return $count;
	  }
	  public function daily_comments()
	  {
	  	$last_month_time = mktime(0, 0, 0, date("m"), date("d")-1,   date("Y"));
   		$start_month = date('Y-m-d 0:0:0', $last_month_time);
   		$end_month = date('Y-m-d 23:59:59', $last_month_time);
   		$this->db->where("timestamp >= '$start_month' AND timestamp <= '$end_month'");
   		$count = $this->db->count_all_results('comments');
   		return $count;
	  }
	  public function daily_posts()
	  {
	  	$last_month_time = mktime(0, 0, 0, date("m"), date("d")-1,   date("Y"));
   		$start_month = date('Y-m-d 0:0:0', $last_month_time);
   		$end_month = date('Y-m-d 23:59:59', $last_month_time);
   		$this->db->where("timestamp >= '$start_month' AND timestamp <= '$end_month'");
   		$count = $this->db->count_all_results('posts');
   		return $count;
	  }
	  public function monthly_likes()
	  {
	  	$last_month_time = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
   		$start_month = date('Y-m-1 H:i:s', $last_month_time);
   		$end_month = date('Y-m-t H:i:s', $last_month_time);
   		$this->db->where("timestamp >= '$start_month' AND timestamp <= '$end_month'");
   		$count = $this->db->count_all_results('likes');
   		return $count;
	  }
	  public function monthly_comments()
	  {
	  	$last_month_time = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
   		$start_month = date('Y-m-1 H:i:s', $last_month_time);
   		$end_month = date('Y-m-t H:i:s', $last_month_time);
   		$this->db->where("timestamp >= '$start_month' AND timestamp <= '$end_month'");
   		$count = $this->db->count_all_results('comments');
   		return $count;
	  }
	  public function monthly_posts()
	  {
	  	$last_month_time = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
   		$start_month = date('Y-m-1 H:i:s', $last_month_time);
   		$end_month = date('Y-m-t H:i:s', $last_month_time);
   		$this->db->where("post_date >= '$start_month' AND post_date <= '$end_month'");
   		$count = $this->db->count_all_results('posts');
   		return $count;
	  }
}
