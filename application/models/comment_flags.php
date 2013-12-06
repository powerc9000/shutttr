<?class Comment_flags extends CI_Model {
public function get_all_comment_flags()
	{
		$this->db->order_by("id", "desc");
	    $comment_query = $this->db->get("comment_flags");
	    $comment_result = $comment_query->result();
	    $comment_flags = '';
	    for($i=0; $i < sizeof($comment_result); $i++)
	    {
	    $comment_flags[] = (array) $comment_result[$i];
	    }
	    return $comment_flags;
	}
	public function flag_comment($data)
	{
		$this->db->insert('comment_flags', $data);
	}
	public function has_user_flagged_comment($userid, $commentid)
	{
		$this->db->where('flagger', $userid);
		$this->db->where('comment_id', $commentid);
		$row = $this->db->count_all_results('comment_flags');
		
		if($row > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function delete_comment($commentid)
	{
		$this->db->where('id', $commentid);
		$this->db->delete('photo_comments');
	//	$this->db->where('comment_id', $commentid);
	//	$this->db->delete('comment_flags');
	}

}
    