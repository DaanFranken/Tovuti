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
		$this->db = new Database();
		$this->user_id = $_SESSION['user_ID'];
		$this->misc = new Misc();

		if(!empty($thread_id))
		{
			$sth = $this->db->selectDatabase('thread', 'thread_ID', $thread_id, '');
			if($row = $sth->fetch())
			{
				$this->thread_id 	=	$row['thread_ID'];
				$this->user_id 		=	$row['user_ID'];
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
					$user = new User($_SESSION['Username']);
					if($user->permission == 2 || $user->permission == 3)
					{
						echo '<a href="?pageStr=thread&deleteThread='.$res['thread_ID'].'"><span class="w3-bar-item w3-hover-red w3-xlarge w3-right"><i class="fa fa-trash" aria-hidden="true"></i> </span></a>';

						echo '<span class="w3-bar-item w3-hover-green w3-xlarge w3-right"><i class="fa fa-pencil" aria-hidden="true"></i> </span>';
					}
					switch ($urgency) {
						case '0':
						echo '<i class="fa fa-sticky-note fa-3x w3-bar-item w3-circle w3-hide-small" aria-hidden="true" style="width:85px; color:#000000;"></i>';
						break;

						case '1':
						echo '<i class="fa fa-exclamation-triangle fa-3x w3-bar-item w3-circle w3-hide-small" aria-hidden="true" style="width:85px; color:#cc0000;"></i>';
						break;

						default:
				    			# code...
						break;
					}

					?>
					<div class="w3-bar-item" style="min-width: 20%;">
						<span class="w3-large"><?php echo '<a class="thread" href="?pageStr=thread&thread_id='.$res['thread_ID'] . '">' . $res['Title'] . '</a>'; ?></span><br>
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

	public function createThread($user_ID, $title, $thread, $urgency)
	{
		$user = new User();
		$user->getUserByID($this->user_id);

		if($user->permission != 0)
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

	public function editThread()
	{
		$misc = new Misc();
		if($misc->validateUserRights($thread_ID))
		{
			// Permission to edit thread
		}
		else
		{
			// No permission to edit thread
		}
	}

	// Thread form
	public function newThreadForm()
	{
		?>
		<form action="" method="POST">
			<input type="hidden" name="createNewThread" value="true">
			<label class="w3-text-teal"><b>Title</b></label>
			<input type="text" name="title" <?php echo (isset($_POST['newThread'])) ? 'value="'.$_POST['title'].'"' : 'placeholder="Title"'; ?> class="w3-input w3-border w3-light-grey" required>
			<label class="w3-text-teal"><b>Thread</b></label>
			<input type="text" name="thread" <?php echo (isset($_POST['newThread'])) ? 'value="'.$_POST['thread'].'"' : 'placeholder="Thread"'; ?> class="w3-input w3-border w3-light-grey" required>
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