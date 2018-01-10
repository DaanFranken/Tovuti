<?php

// Urgency
// 0  | Overig
// 1  | Algemeen
// 2  | Huiswerk
// 3  | Activiteit
// 4  | Belangrijk

// Specify timezone for correct time insertion in database
date_default_timezone_set('Europe/Amsterdam');

class Thread
{
	private $user;
	public $thread_id;
	protected $db;
	public $user_id;
	public $title;
	public $thread;
	public $threadDate;
	private $misc;

						// Db connection
	public function __construct($thread_id = NULL)
	{
		$this->user = new User();
		if($this->user->loginCheck())
		{
			$this->user = new User($_SESSION['Username']);
		}
		$this->db = new Database();
		$this->misc = new Misc();

		if(!empty($thread_id))
		{
			$sth = $this->db->selectDatabase('thread', 'thread_ID', $thread_id, '');
			if($row = $sth->fetch())
			{
				$this->thread_id 	=	$row['thread_ID'];
				$this->title 		= 	$row['Title'];
				$this->thread 		=	$row['Thread'];
				$this->threadDate 	=	$row['threadDate'];
			}
		}

	}

	public function getAllThreads($ID = NULL)
	{
		if(!empty($ID))
		{
			$addon = ' AND user_id = "'.$ID .'"';
		}
		else
		{
			$addon = '  ORDER BY Urgency DESC';
		}
		$sth = $this->db->selectDatabase('thread','Status','1',$addon);
		$result = $sth->fetchAll();
		echo '<ul class="w3-ul w3-card-4">';
		if(!$result)
		{
			echo 'Er zijn geen posts beschikbaar.';
		}
		else
		{
			foreach($result as $res)
			{
				// Required attributes
				$unformattedDate = DateTime::createFromFormat('Y-m-d H:i:s', $res['threadDate']);
				$formattedDate = $unformattedDate->format('d-m-Y H:i:s');
				$urgency = $res['Urgency'];
				$sth = $this->db->selectDatabase('users','user_ID',$res['user_ID'],'');
				$author = $sth->fetch();

				?>
				<li class="w3-bar">
					<?php
					if($this->user->permission == 2 || $this->user->permission == 3)
					{
						echo '<form action="" method="POST" id="deleteForm'.$res['thread_ID'].'"><input type="hidden" name="threadID" value="'.$res['thread_ID'].'"></form>';
						$threadID = "'".$res['thread_ID']."'";
						echo '<div onclick="deleteThread('.$threadID.')"><span class="w3-bar-item w3-hover-red w3-xlarge w3-right"><i class="fa fa-trash" aria-hidden="true"></i> </span></div>';
						echo '<a href="?pageStr=forum&editThread='.$res['thread_ID'].'"><span class="w3-bar-item w3-hover-green w3-xlarge w3-right"><i class="fa fa-pencil" aria-hidden="true"></i> </span></a>';
					}
					switch ($urgency) {
						case '0':
						echo '<i class="fa fa-clone fa-3x w3-bar-item w3-circle w3-hide-small" aria-hidden="true" style="width:85px; color:#000;"></i>';
						break;

						case '1':
						echo '<i class="fa fa-sticky-note-o fa-3x w3-bar-item w3-circle w3-hide-small" aria-hidden="true" style="width:85px;"></i>';
						break;

						case '2':
						echo '<i class="fa fa-book fa-3x w3-bar-item w3-circle w3-hide-small" aria-hidden="true" style="width:85px; "></i>';
						break;

						case '3':
						echo '<i class="fa fa-calendar-check-o fa-3x w3-bar-item w3-circle w3-hide-small" aria-hidden="true" style="width:85px; "></i>';
						break;

						case '4':
						echo '<i class="fa fa-exclamation-triangle fa-3x w3-bar-item w3-circle w3-hide-small" aria-hidden="true" style="width:85px; color:#cc0000;"></i>';
						break;

						default:
				    			# code...
						break;
					}

					?>
					<div class="w3-bar-item" style="min-width: 20%;">
						<span class="w3-large"><?php echo '<a class="thread" href="?pageStr=forum&thread_id='.$res['thread_ID'] . '">' . $res['Title'] . '</a>'; ?></span><br>
						<span><?php 
							$thread = substr($res['Thread'],0,20).'...';
							echo $thread;?></span>
					</div>
					<div class="w3-bar-item">
						<span><i class="fa fa-user-o" aria-hidden="true"></i>
							<?php
							echo '<a class="thread" href="?pageStr=account&user_id='.$author['user_ID'].'">';
							echo $author['Firstname'].'&nbsp;'.$author['Lastname'];
							echo '</a>';?>
						</span><br/>
						<span class="w3-margin-top"><i class="fa fa-clock-o" aria-hidden="true"></i>
							<?php echo $formattedDate; ?>
						</span>
					</div>
				</li>
				<?php
			}
		}
	}

	// Create thread
	public function createThread($user_ID, $title, $thread, $urgency)
	{
		$this->user->getUserByID($this->user_id);

		if($this->user->permission != 0)
		{
			$arrayValues['thread_ID'] 	= $this->misc->getGUID();
			$arrayValues['user_ID']		= $user_ID;
			$arrayValues['Title'] 		= $title;
			$arrayValues['Thread']		= $thread;
			$arrayValues['Urgency']		= $urgency;
			$arrayValues['threadDate']	= date("Y-m-d H:i:s");

			$this->db->insertDatabase('thread', $arrayValues);
			echo 'Uw bericht is geplaatst';
		}
	}

	// Delete thread
	public function deleteThread($threadID)
	{
		$updateArray['Status'] = 0;
		$this->db->updateDatabase('thread', 'thread_ID', $threadID, $updateArray);
	}

	// Thread form
	public function newThreadForm($check)
	{
		?>
		<form action="?pageStr=forum" method="POST">
			<?php
			if(!empty($check))
			{
				$row = $check->fetch();
				echo '<input type="hidden" name="editThread" value="true"><input type="hidden" name="threadID" value="'.$row['thread_ID'].'">';
			}
			else
			{
				echo '<input type="hidden" name="createNewThread" value="true">';
			}
			?>
			<label class="w3-text-teal"><b>Title</b></label>
			<input type="text" name="title" <?php if(empty($check)){ echo (isset($_POST['newThread'])) ? 'value="'.$_POST['title'].'"' : 'placeholder="Title"'; }else{echo 'value="'.$row['Title'].'"';} ?> class="w3-input w3-border w3-light-grey" required>
			<label class="w3-text-teal"><b>Thread</b></label>
			<input type="text" name="thread" <?php if(empty($check)){ echo (isset($_POST['newThread'])) ? 'value="'.$_POST['thread'].'"' : 'placeholder="Thread"'; }else{echo 'value="'.$row['Thread'].'"';} ?> class="w3-input w3-border w3-light-grey" required>
			<label class="w3-text-teal"><b>Urgency</b></label><br/>
			<select name="urgency">
				<option value="0" <?php if(isset($_POST['newThread']) AND $_POST['urgency'] == 0){echo 'selected';}elseif(!isset($_POST['newThread'])){echo 'selected';} ?>>Overig</option>
				<option value="1" <?php if(isset($_POST['newThread']) AND $_POST['urgency'] == 1) echo 'selected'; ?>>Algemeen</option>
				<option value="2" <?php if(isset($_POST['newThread']) AND $_POST['urgency'] == 2) echo 'selected'; ?>>Huiswerk</option>
				<option value="3" <?php if(isset($_POST['newThread']) AND $_POST['urgency'] == 3) echo 'selected'; ?>>Activiteit</option>
				<option value="4" <?php if(isset($_POST['newThread']) AND $_POST['urgency'] == 4) echo 'selected'; ?>>Belangrijk</option>
			</select><br/>
			<input type="submit" name="newThread" value="Save" class="w3-btn w3-margin" style="color: white;background-color: #89D162;border-bottom: 2px solid #58B327;">
		</form>
		<?php
	}
}
?>