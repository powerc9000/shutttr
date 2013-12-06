<?
class Ratings extends CI_Controller {
	public function top_photos()
	{
		$this->load->model('post');
		$this->load->model('comment');
		$data = $this->post->get_all_month_photos();
		//all photos and their number of comments like average rating and flags
		//((R*r)+(C*c)+(L*l))(F)

		
					  //convert it into an array to make it easier
					  for($i=0;$i<sizeof($data);$i++)
					  {
					  	$data2[] = (array) $data[$i];
					  }
					  foreach($data2 as $photo)
					  {
					  	$R= 1;
					  	$r = $this->post->get_photo_rating($photo['id']);
					  	$r = ($r != "unknown")? $r : 0;
					  	$r2 = $this->post->get_number_of_ratings($photo['id'])+1;
						$C = 3;
					  	$c = count($this->comment->get_photo_comments($photo['id']));
					  	$L = 1;
					  	$l = $this->post->count_likes_post($photo['id'], 1);
					  	$F = $this->post->get_number_of_flags($photo['id']);
					  	$F = ($F > 3)? 0 : 1;
					  	$c = ($c > 2)? $c : 0;
					  	$R_final = $R*$r*$r2;
					  	$C_final = $C*$c;
					  	$L_final = $L*$l;
					  	$Rank_before_flags = $C_final + $L_final;
					  	$rank = $Rank_before_flags * $F;
					  	$this->post->update_photo_rank($photo['id'], $rank);
					  	
					  }
					  
					  
	}
	public function top_people($password=""){
    if (!$this->user->is_admin() && $password != "this-is-being-called-by-a-cron-job-like-a-octopus") return;
		/*$this->load->model('post');
		$this->load->model('comment');
		$users = $this->user->get_all_users();
		//Go through all the posts
		foreach($users as $user){
		//comments and their points
		$comments = $this->comment->get_all_user_comments($user->id);
		$C = count($comments);
		$total_c = 0;
		if($C > 0)
		{
			
			foreach($comments as $comment)
			{
				$time = strtotime($comment->timestamp);
				if($time >= time()-2629743)
				{
					$c = 3;
				}
				elseif($time >= time()-5259487)
				{
					$c = 2;
				}
				elseif($time >= time()-7889231)
				{
					$c = 1;
				}
				else
				{
					$c = 0;
				}
				$total_c += $c;
			}
			
		}
		//Posts and their points
		 $posts = $this->post->get_all_posts($user->id);
		 $P = count($posts);
		 
		 $total_p = 0;
		 if($P > 0)
		{
			foreach($posts as $post)
			{
				$time = strtotime($post->timestamp);
				if($time >= time()-2629743)
				{
					$p = 3;
				}
				elseif($time >= time()-5259487)
				{
					$p = 2;
				}
				elseif($time >= time()-7889231)
				{
					$p = 1;
				}
				else
				{
					$p = 0;
				}
				$total_p += $p;
				
			}
		}
		$followers = count($this->user->get_all_followers($user->id));
		$following = count($this->user->get_all_following($user->id));
		
		if($following > 0 and $followers > 0)
		{
			$FR = $followers /$following;
			

		}
		else
		{
			$FR = 1;
		}
		$F = ($FR > 1) ? $FR / 2 : $FR * 2;
		$score = ($C+$total_c+$P+$total_p);
		$this->user->update_user_rank($user->id, $score);
		
	}*/
	$this->db->query(<<<SQL
UPDATE users AS user
INNER JOIN ( SELECT user.id AS user_id,
                    COALESCE(ROUND( COALESCE(likes.count, 0)
                                  + COALESCE(10 * comments.rank, 0)
                                  + COALESCE(20 * posts.rank, 0)
                                  + COALESCE(10 * followers.count, 0)
                                  ), 0) AS val
             FROM ( SELECT *
                    FROM users
                    WHERE type != 0
                  ) AS user
             LEFT JOIN ( SELECT user_id, SUM(3 * COALESCE(POW(0.5, (NOW() - timestamp) / 2678400), 1)) AS rank
                         FROM comments
                         GROUP BY user_id
                       ) AS comments
             ON user.id = comments.user_id
             LEFT JOIN ( SELECT user_id, SUM(3 * COALESCE(POW(0.5, (NOW() - timestamp) / 2678400), 1)) AS rank
                         FROM posts
                         GROUP BY user_id
                       ) AS posts
             ON user.id = posts.user_id
             LEFT JOIN ( SELECT followee_id AS user_id, COALESCE(COUNT(*), 0) AS count
                         FROM following
                         GROUP BY followee_id) AS followers
             ON user.id = followers.user_id
             LEFT JOIN ( SELECT post.user_id AS user_id, COALESCE(COUNT(*), 0) AS count
                         FROM likes
                              INNER JOIN posts AS post
                              ON likes.post_id = post.id
                         GROUP BY post.user_id
                       ) AS likes
             ON user.id = likes.user_id
           ) AS rank
ON user.id = rank.user_id
INNER JOIN ( SELECT ( SELECT ( ROUND(COUNT(*)
                             / (SELECT COUNT(*) FROM users)
                             * 100
                             ))                    
                      FROM users AS user1
                      WHERE user1.rank < user2.rank) AS percentile, id
             FROM users AS user2) AS user3
ON user.id = user3.id
SET user.rank = rank.val,
    user.p_rank = user3.percentile
SQL
);
}
	// public function percentage_rank(){
	// 	$users = $this->user->get_all_users();
	// 	$count = count($users);
	// 	foreach($users as $u1){
	// 		$rank = 0;
	// 		foreach($users as $u2){
	// 			if($u1->rank > $u2->rank){
	// 				$rank +=1;
	// 			}
	// 		}
	// 	 $place = $rank/$count;
	// 	
	// 	 $percent = $place * 100;
	// 	 $this->db->where("id", $u1->id);
	// 	 $this->db->update("users", array("p_rank" => $percent));
	// 	}
	// 	
	// }
}
