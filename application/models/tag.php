<?
class Tag extends CI_Model {
	public function new_tags($tags, $post_id, $post_type)
	{
		if($tags != '')
		{
		$tags = trim($tags);
		$tags = explode(',', $tags);
			foreach($tags as $tag)
			{
				if($tag != '')
				{
					$tag = trim($tag);
					$this->db->where('tag', $tag);
					$count = $this->db->count_all_results('tag');
					if($count > 0)
					{
						
						$this->db->select('count');
						$this->db->where('tag', $tag);
						$result = $this->db->get('tag');
						$count = $result->result();
						$add_one = $count[0]->count +1;
						$this->db->where('tag', $tag);
						$this->db->update('tag', array('count' => $add_one));
						
					}
					else
					{	
							$this->db->insert('tag', array('tag' => $tag, 'count' => 1));
						
					}

					$this->db->insert('tag_assoc', array('tag' => $tag, 'post_id' => $post_id, 'post_type' => $post_type));
				}
			}
		}
		else
		{
			return;
		}

	}
	public function get_tags_for_post($postid)
	{
		$this->db->where('post_id', $postid);
		$query = $this->db->get('tag_assoc');
		$result = $query->result();
		$tags = '';
		 for($i=0;$i<sizeof($result);$i++)
		 {
		 	$tags[] = (array) $result[$i];
		 }
		 
		return $tags;

	}
	public function get_posts_by_tag_paginated($tag, $data)
	{
		$tag = implode(' ', explode('-', $tag));
		$this->db->where('tag', $tag);
		$this->db->order_by('posts.id', "DESC");
		$this->db->join('posts', 'posts.id = tag_assoc.post_id');
		$query = $this->db->get('tag_assoc', $data["per_page"], $data["page"]);
		return $query->result();
	}
	public function get_top_tags()
	{
		$this->db->order_by('count', 'desc');
		$this->db->limit(10);
		$query = $this->db->get('tag');
		$result = $query->result();
		$tags = array();
		for($i=0;$i<sizeof($result);$i++)
		{
			$tags[] = (array) $result[$i];
		}
		return $tags;

	}
	public function delete_tags_by_id($postid)
	{
		$this->db->where('post_id', $postid);
		$this->db->delete('tag_assoc');
	}
	public function get_number_of_posts_with_tag($tag)
	{
		$this->db->where('tag',$tag);
		$count = $this->db->count_all_results('tag_assoc');
		return $count;
	}
}
