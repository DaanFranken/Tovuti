<?php
if($user->loginCheck())
{
	if($misc->readVar('GET','class_id'))
	{
		$sth = $db->selectDatabase('class','class_ID',$_GET['class_id'],'');
		$result = $sth->fetch();
	}

	// Save new students into class
	$userCount = 0;
	if(isset($_POST['saveNewClassStudents']) && $user->permission > 1)
	{
		$sth = $db->selectDatabase('students', 'user_ID', $_POST['userID'.$userCount], '');
		if($row = $sth->fetch())
		{
			if($row['class_ID'] == 0)
			{
				$arrayValues['class_ID'] = $_GET['class_id'];
				$db->updateDatabase('students', 'user_ID', $_POST['userID'.$userCount], $arrayValues, '');
				echo '<script>window.location.href = "class?class_id='.$_GET['class_id'].'";</script>';
			}
		}
		$userCount++;
	}

	// Remove user from class
	if(isset($_POST['remStudentFromClass']))
	{
		$sth = $db->selectDatabase('students', 'user_ID', $_POST['user_ID'], '');
		if($row = $sth->fetch())
		{
			$arrayValues['class_ID'] = 0;
			$db->updateDatabase('students', 'user_ID', $_POST['user_ID'], $arrayValues, '');
			echo '<script>window.location.href = "class?class_id='.$_GET['class_id'].'";</script>';
		}
		else
		{
			echo '<script>window.location.href = "class?class_id='.$_GET['class_id'].'";</script>';
		}
	}
	?>
	<div class="w3-container w3-margin">
		<?php 
		if($misc->readVar('GET','class_id'))
		{
			?>
			<a class="w3-button w3-block w3-hover-blue" style="text-decoration: none;max-width: 300px;background-color: #2C9AC9;" href="class"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i>&nbsp;Terug naar klassenoverzicht</a><br/>
			<?php
		}
		?>
		<div class="w3-card-4 w3-rest">
			<?php if($misc->readVar('GET','class_id') && $user->permission > 1)
			{
				?>
				<button class="w3-button w3-circle w3-teal w3-right w3-medium w3-card-4" style="position: absolute;top: 24px;right: 50px;padding: 10px 15px;" onclick="addNewStudent()">+</button>
				<?php
			}
			?>
			<header class="w3-container w3-light-grey">
				<h3><?php echo 'Klassenlijst '. (isset($_GET['class_id']) ? $result['Name'] : '');   ?></h3>
			</header>
			<div class="w3-container">
				<?php 
				if($misc->readVar('GET','class_id')) 
				{ 
					if($user->getTeacherByClassID($_GET['class_id'])) 
					{
						echo 'Docent: '. $user->getTeacherByClassID($_GET['class_id']); 
						echo '<hr>';
					}
				}
				if(!$misc->readVar('GET','class_id'))
				{
					$misc->getAllClassesAsList();
				}
				else
				{
					$misc->getAllStudentsInClass($_GET['class_id']);
					echo '<style>.w3-btn{transition: all 0.2s;}.w3-btn:hover{opacity: 1 !important;}</style>';
					$sth = $db->selectDatabase('students', 'class_ID', '0', '');
					$count = 0;
					while($sth->fetch())
					{
						$count++;
					}
					echo '<input type="hidden" name="count" value="'.$count.'" id="count">';
				}
				?>	
			</div>
		</div>
	</div>
	<form action="class?class_id=<?php echo $_GET['class_id']; ?>" method="POST" style="margin-left: 33px;">
		<div id="addStudent"></div>
		<input type="submit" name="saveNewClassStudents" value="Voeg studenten toe" class="w3-btn" id="newStudentsBtn" style="display: none;">
	</form>
	<i><div id="studentLimit" style="color: #575757;margin-left: 33px;"></div></i>
	</div>
	<?php
}
else $user->showLoginMessage();
?>
<script>
var count = 0;
var check1 = false;
var check2 = false;
function addNewStudent(){
	if(window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if(this.readyState==4 && this.status==200){
			if(count != document.getElementById('count').value){
				document.getElementById('addStudent').innerHTML += '<select name="userID'+count+'">'+this.responseText+'</select><br/>';
				count++;
			}
			else if(!check1){
				check1 = true;
				document.getElementById('studentLimit').innerHTML = 'Er zijn geen studenten meer om toe te voegen';
				setTimeout(function(){
					document.getElementById('studentLimit').innerHTML = '';
					check1 = false;
				}, 2000);
			}
			if(!check2 && document.getElementById('count').value != 0){
				document.getElementById('newStudentsBtn').style.cssText = 'display: block !important;color: white;background-color: #89D162;border-bottom: 2px solid #58B327;';
				check2 = true;
			}
		}
	}
	xmlhttp.open("GET","addStudentToClass.php");
	xmlhttp.send();
}
</script>
<!-- <div class="w3-card-4 w3-rest"></div> -->