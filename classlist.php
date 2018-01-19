<?php
if($user->loginCheck())
{
	if($misc->readVar('GET','class_id'))
	{
		$sth = $db->selectDatabase('class','class_ID',$_GET['class_id'],'');
		$result = $sth->fetch();
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
		if(!isset($_POST['addUserToClass']))
		{
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
					}			

					?>	
				</div>
			</div>
		</div>
		<div id="addStudent"></div>
		</div>
		<?php 
		}
		else
		{
				//
		}
}
else $user->showLoginMessage();
?>
<script>
	var count = 0;
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
			document.getElementById('addStudent').innerHTML += '<select name="userID'+count+'">'+this.responseText+'</select>';
		}
	}
	xmlhttp.open("GET","addStudentToClass.php");
	xmlhttp.send();
	count++;
}
</script>
<!-- <div class="w3-card-4 w3-rest"></div> -->