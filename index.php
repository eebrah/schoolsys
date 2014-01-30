<?php

session_start();

require_once( "Base.class.php" );

{	// Data
	
	$testTypes = Array( "CAT", "exam" );
	
	$output = '';
	
	$pageTitle = 'netivity SchoolSys';
	
	$pageHeader = '<!DOCTYPE html>
<html>
	<head>
		<title>' . $pageTitle . '</title>
		<link rel="stylesheet" 
		      type="text/css" 
		      href="style/dropdown.css" /> 
		<link rel="stylesheet" 
		      type="text/css" 
		      href="style/main.css" /> 
	</head>
	<body>
		<div id="wrapper">
			<div class="header">';
			
	$pageBody = '';		
			
	$pageFooter = '
			</div>
		</div>
	</body>
</html>';

}

if( isset( $_SESSION[ "user" ][ "loggedIn" ] ) ) {

	$pageBody .= '
				<ul id="nav_global">
					<li>
						<a href="?section=students">students</a>
						<ul>
							<li>
								<a href="?section=students&action=add">add student</a>
							</li>
							<li>
								<a href="?section=students&action=list">list students</a>
							</li>
						</ul>
					</li> <!--
					<li>
						<a href="?section=users">users</a>
						<ul>
							<li>
								<a href="?section=users&action=list">list</a>
							</li>
							<li>
								<a href="?section=users&action=add">add</a>
							</li>
						</ul>
					</li> -->
					<li>
						<a href="?section=subjects">subjects</a>
						<ul>
							<li>
								<a href="?section=subjects&action=add">add subject</a>
							</li>
							<li>
								<a href="?section=subjects&action=list">list subjects</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="?section=subjects">streams</a>
						<ul>
							<li>
								<a href="?section=streams&action=add">add stream</a>
							</li>
							<li>
								<a href="?section=streams&action=list">list stream</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="?section=tests">tests</a>
						<ul>
							<li>
								<a href="?section=tests&action=add">add test</a>
							</li>
							<li>
								<a href="?section=tests&action=list">list tests</a>
							</li>
							<li>
								<a href="?section=tests&action=entry">enter marks</a>
								<ul>
									<li>
										<a href="?section=tests&action=entry&mode=bulk">in bulk</a>
									</li>
									<li>
										<a href="?section=tests&action=entry&mode=individual">per student</a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li>
						<a href="?section=access">' . $_SESSION[ "user" ][ "loggedIn" ][ "screenName" ] . '</a>
						<ul>
							<li>
								<a href="?section=access&action=toggle">log out</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="body">';

	$section = "home";

	if( isset( $_REQUEST[ "section" ] ) ) {
		
		$section = $_REQUEST[ "section" ];
		
		switch( $section ) {
			
			case "students" : {
				
				$action = "list";
				
				if( isset( $_REQUEST[ "action" ] ) ) {
					
					$action = $_REQUEST[ "action" ];
					
				}
				
				switch( $action ) {
					
					case "add" : {
						
						$stage = "1";
						
						if( isset( $_REQUEST[ "stage" ] ) ) {
							
							$stage = $_REQUEST[ "stage" ];
						
						}
						
						switch( $stage ) {
							
							case "2" : 
							case "final" : {
								
								$student = new Student( "00000", $_POST[ "surname" ], $_POST[ "otherNames" ], $_POST[ "schoolID" ], $_POST[ "KCPEScore" ], $_POST[ "dateOfAdmission" ], $_POST[ "yearOfStudyAtAdmission" ], $_POST[ "gender" ] );
								
								if( $student -> saveToDB() ) {
								
									$pageBody .= '
<div class="dialog">
	<p>The following student : </p>
	<table>
		<tbody>
			<tr>
				<th>school ID</th>
				<td>' . $student -> getSchoolID() . '</td>
			</tr>
			<tr>
				<th>name</th>
				<td>' . $student -> getSurName() . ', ' . $student -> getOtherNames() . '</td>
			</tr>
			<tr>
				<th>KCPE Marks</th>
				<td>' . $student -> getKCPEScore() . '</td>
			</tr>
			<tr>
				<th>Admitted on</th>
				<td>' . $student -> getDateOfAdmission() . '</td>
			</tr>
		</tbody>
	</table>
	<p>Was successfully added to the system</p>
	<p>
		<a href="?section=students&action=add">add more</a> | <a href="?section=students&action=list">view list</a> | <a href="?">home</a> </p>
	</p>
</div>';

								}
								else {
									
									$pageBody .= '
<div class="dialog">
	<p>Unable to save the record</p>
</div>';
								
								}
							
							}
							break;
							
							case "1" :
							default : {
								
								$pageBody .= '
<div class="dialog">
	<form action="?section=students&action=add"
	      method="POST">
		<fieldset class="info">
			<legend>student details</legend>
			<div class="row">
				<label>school id</label>
				<input type="text"
				       name="schoolID"
				       placeholder="enter students admission number" />
			</div>
			<div class="row">
				<label>surname</label>
				<input type="text"
				       name="surname"
				       placeholder="enter students surname" />
			</div>
			<div class="row">
				<label>other names</label>
				<input type="text"
				       name="otherNames"
				       placeholder="enter any other names" />
			</div>
			<div class="row">
				<label>gender</label>
				<select name="gender">
					<option value="1">male</option>
					<option value="0">female</option>
				</select>
			</div>
			<div class="row">
				<label>stream</label>
				<select name="stream">';
								
							$streams = getStreams();	
								
							foreach( $streams as $streamID ) {	
								
								$stream = new Stream( $streamID );
											
								$pageBody .= '			
					<option value="' . $streamID . '">' . $stream -> getName() . '</option>';
					
							}
					
							$pageBody .= '
				</select>
			</div>
			<div class="row">
				<label>year of study</label>
				<select name="yearOfStudyAtAdmission">
					<option value="1">Form 1</option>
					<option value="2">Form 2</option>
					<option value="3">Form 3</option>
					<option value="4">Form 4</option>
				</select>
			</div>
			<div class="row">
				<label>date of birth</label>
				<input type="text"
				       name="KCPEScore"
				       placeholder="students KCPE Marks" />
			</div>
			<div class="row">
				<label>date of registration/admission</label>
				<input type="date"
				       name="dateOfAdmission"
				       placeholder="date on which student was registered"
				       value="' . date( "Y-m-d" ) . '" />
			</div>
		</fieldset>
		<fieldset class="buttons">
			<button type="reset">reset</button>
			<button type="submit"
			        name="stage"
			        value="final">submit</button>
		</fieldset>
	</form>
</div>';
							
							}
							break;
						
						}
					
					}
					break;
					
					case "edit" : {
						
						if( isset( $_REQUEST[ "target" ] ) ) {
							
							$target = $_REQUEST[ "target" ];
							
							$student = New Student( $target );
							
							$stage = "1";
							
							if( isset( $_REQUEST[ "stage" ] ) ) {
								
								$stage = $_REQUEST[ "stage" ];
							
							}
							
							switch( $stage ) {
								
								case "2" : 
								case "final" : {
									
									//$student = new Student( "00000", $_POST[ "surname" ], $_POST[ "otherNames" ], $_POST[ "schoolID" ], $_POST[ "dateOfBirth" ], $_POST[ "dateOfAdmission" ], $_POST[ "yearOfStudyAtAdmission" ], $_POST[ "gender" ] );
									
									$student -> setSurName( $_POST[ "surname" ] );
									$student -> setOtherNames( $_POST[ "otherNames" ] );
									$student -> setSchoolID( $_POST[ "schoolID" ] );
									$student -> setDateOfBirth( $_POST[ "dateOfBirth" ] );
									$student -> setDateOfAdmission( $_POST[ "dateOfAdmission" ] );
									$student -> setGender( $_POST[ "gender" ] );
									$student -> setYearOfStudyAtAdmission( $_POST[ "yearOfStudyAtAdmission" ] );
									
/*									
									if( $student -> saveToDB() ) {
*/									
										$pageBody .= '
<div class="dialog">
	<p>The following student : </p>
	<table>
		<tbody>
			<tr>
				<th>school ID</th>
				<td>' . $student -> getSchoolID() . '</td>
			</tr>
			<tr>
				<th>name</th>
				<td>' . $student -> getSurName() . ', ' . $student -> getOtherNames() . '</td>
			</tr>
			<tr>
				<th>Date of Birth</th>
				<td>' . $student -> getDateOfBirth() . '</td>
			</tr>
			<tr>
				<th>Admitted on</th>
				<td>' . $student -> getDateOfAdmission() . '</td>
			</tr>
		</tbody>
	</table>
	<p>Was successfully added to the system</p>
	<p>
		<a href="?section=students&action=add">add more</a> | <a href="?section=students&action=list">view list</a> | <a href="?">home</a> </p>
	</p>
</div>';
/*
									}
									else {
										
										$pageBody .= '
<div class="dialog">
	<p>Unable to save the record</p>
</div>';
								
									}
*/								
								}
								break;
								
								case "1" :
								default : {
									
									$pageBody .= '
<div class="dialog">
	<form action="?section=students&action=edit"
	      method="POST">
		<fieldset class="info">
			<legend>student details</legend>
			<div class="row">
				<label>school id</label>
				<input type="text"
				       name="schoolID"
				       value="' . $student -> getSchoolID() . '"
				       placeholder="enter students admission number" />
			</div>
			<div class="row">
				<label>surname</label>
				<input type="text"
				       name="surname"
				       value="' . $student -> getSurName() . '"
				       placeholder="enter students surname" />
			</div>
			<div class="row">
				<label>other names</label>
				<input type="text"
				       name="otherNames"
				       value="' . $student -> getOtherNames() . '"
				       placeholder="enter any other names" />
			</div>
			<div class="row">
				<label>gender</label>
				<select name="gender">
					<option value="1">male</option>
					<option value="0">female</option>
				</select>
			</div>
			<div class="row">
				<label>stream</label>
				<select name="gender">
					<option value="0">east</option>
					<option value="1">west</option>
					<option value="2">north</option>
					<option value="3">south</option>
				</select>
			</div>
			<div class="row">
				<label>year of study</label>
				<select name="yearOfStudyAtAdmission">
					<option value="1">Form 1</option>
					<option value="2">Form 2</option>
					<option value="3">Form 3</option>
					<option value="4">Form 4</option>
				</select>
			</div>
			<div class="row">
				<label>KCPE marks</label>
				<input type="text"
				       name="KCPEScore"
				       value="' . $student -> getKCPEScore() . '"
				       placeholder="students KCPE marks" />
			</div>
			<div class="row">
				<label>date of registration/admission</label>
				<input type="date"
				       name="dateOfAdmission"
				       placeholder="date on which student was registered"
				       value="' . substr( $student -> getDateOfAdmission(), 0, 10 ) . '" />
			</div>
		</fieldset>
		<fieldset class="buttons">
			<button type="reset">reset</button>
			<button type="submit"
			        name="stage"
			        value="final">submit</button>
		</fieldset>
	</form>
</div>';
							
								}
								break;
							
							}
														
						}
						else {
							
							$pageBody .= '
<div class="dialog">
	<p>Sorry, but a "target" must be specified in order for you to perfom this action</p>
</div>';
						
						}
					
					}
					break;
					
					case "view" : {
						
						if( isset( $_REQUEST[ "target" ] ) ) {
							
							$target = $_REQUEST[ "target" ];
							
							$student = New Student( $target );
							
						}
						else {
							
							$pageBody .= '
<div class="dialog">
	<p>Sorry, but a "target" must be specified in order for you to perfom this action</p>
</div>';
						
						}
					
					}
					break;
					
					case "list" : 
					default : {
						
						$students = getStudents( "all" );
						
						if( count( $students ) > 0 ) {
						
							$pageBody .= '
<table class="fancy sortable searchable">
	<thead>
		<tr>
			<th>#</th>
			<th>school ID</th>
			<th>form</th>
			<th>name</th>
			<th>actions</th>
		</tr>
	</thead>
	<tbody>';
						
							$count = 1;
						
							foreach( $students as $studentID ) {
								
								$student = new Student( $studentID );
		
								$pageBody .= '
		<tr>
			<td>' . $count . '</td>
			<td>' . $student -> getSchoolID() . '</td>
			<td>' . $student -> getYearOfStudy() . '</td>
			<td>' . $student -> getSurName() . ', ' . $student -> getOtherNames() . '</td>
			<td class="actions">
				<ul>
					<li>
						<a href="?section=students&action=view&target=' . $student -> getUniqueID() . '">view</a>
					</li>
					<li>
						<a href="?section=students&action=edit&target=' . $student -> getUniqueID() . '">edit</a>
					</li> <!--
					<li>
						<a href="?section=students&action=delete&target=' . $student -> getUniqueID() . '">delete</a>
					</li> -->
				</ul>
			</td>
		</tr>';
		
								$count++;
		
							}
			
							$pageBody .= '
	</tbody>
</table>';

						}
						else {
							
							$pageBody .= '
<div class="dialog">
	<p>Sorry, but no results were returned!</p>
</div>';
						
						}
					
					}
					break;
				
				}
			
			}
			break;
			
			case "employees" : {
				
				$action = "list";
				
				if( isset( $_REQUEST[ "action" ] ) ) {
					
					$action = $_REQUEST[ "action" ];
				
				}
				
				switch( $action ) {
					
					case "list" : 
					default : {
						
						$employees = getEmployees( "all" );
						
						if( count( $employees ) > 0 ) {
						
							$pageBody .= '
<table class="fancy sortable searchable">
	<thead>
		<tr>
			<th>#</th>
			<th>name</th>
		</tr>
	</thead>
	<tbody>';
						
							$count = 1;
						
							foreach( $employees as $employeeID ) {
								
								$employee = new Student( $employeeID );
		
								$pageBody .= '
		<tr>
			<td>' . $count . '</td>
			<td>' . $employee -> getSurName() . ', ' . $employee -> getOtherNames() . '</td>
			<td class="actions">
				<ul>
					<li>
						<a href="?section=employees&action=view&target=' . $employee -> getUniqueID() . '">view</a>
					</li>
					<li>
						<a href="?section=employees&action=edit&target=' . $employee -> getUniqueID() . '">edit</a>
					</li>
					<li>
						<a href="?section=employees&action=delete&target=' . $employee -> getUniqueID() . '">delete</a>
					</li>
				</ul>
			</td>
		</tr>';
		
							}
			
							$pageBody .= '
	</tbody>
</table>';

						}
						else {
							
							$pageBody .= '
<div class="dialog">
	<p>Sorry, but no results were returned!</p>
</div>';
						
						}
					
					}
					break;		
			
				}
			
			}
			break;
			
			case "teachers" : {
				
				$action = "list";
				
				if( isset( $_REQUEST[ "action" ] ) ) {
					
					$action = $_REQUEST[ "action" ];
				
				}
				
				switch( $action ) {
					
					case "list" : 
					default : {
						
						$teachers = getEmployees( "all", "teacher" );
						
						if( count( $teachers ) > 0 ) {
						
							$pageBody .= '
<table class="fancy sortable searchable">
	<thead>
		<tr>
			<th>#</th>
			<th>name</th>
		</tr>
	</thead>
	<tbody>';
						
							$count = 1;
						
							foreach( $teachers as $teacherID ) {
								
								$teacher = new Teacher( $teacherID );
		
								$pageBody .= '
		<tr>
			<td>' . $count . '</td>
			<td>' . $teacher -> getSurName() . ', ' . $teacher -> getOtherNames() . '</td>
			<td class="actions">
				<ul>
					<li>
						<a href="?section=teachers&action=view&target=' . $teacher -> getUniqueID() . '">view</a>
					</li>
					<li>
						<a href="?section=teachers&action=edit&target=' . $teacher -> getUniqueID() . '">edit</a>
					</li>
					<li>
						<a href="?section=teachers&action=delete&target=' . $teacher -> getUniqueID() . '">delete</a>
					</li>
				</ul>
			</td>
		</tr>';
		
							}
			
							$pageBody .= '
	</tbody>
</table>';

						}
						else {
							
							$pageBody .= '
<div class="dialog">
	<p>Sorry, but no results were returned!</p>
</div>';
						
						}
					
					}
					break;		
			
				}
			
			}
			break;
			
			case "streams" : {
				
				$action = "list";
				
				if( isset( $_REQUEST[ "action" ] ) ) {
					
					$action = $_REQUEST[ "action" ];
				
				}
				
				switch( $action ) {
					
					case "add" : {
						
						$stage = "1";
						
						if( isset( $_REQUEST[ "stage" ] ) ) {
							
							$stage = $_REQUEST[ "stage" ];
						
						}
						
						switch( $stage ) {
							
							case "1" : {
								
								$pageBody .= '
<div class="dialog">
	<form action="?section=streams&action=add"
	      method="POST">
		<fieldset class="info">
			<div class="row">
				<label>name</label>
				<input type="name"
				       name="name"
				       placeholder="name of stream" />
			</div>
			<div class="row">
				<label>start year</label>
				<select name="startYear">
					<option value="1" selected>1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
				</select>
			</div>
			<div class="row">
				<label>end year</label>
				<select name="stopYear">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4" selected>4</option>
				</select>
			</div>
			<div class="row">
				<label>notes</label>
				<textarea name="description"
				          placeholder="any other information"></textarea>
			</div>
		</fieldset>
		<fieldset class="buttons">
			<button type="reset">RESET</button>
			<button type="submit"
			        name="stage"
			        value="2">submit</button>
		</fieldset>
	</form>
</div>';
								
							}
							break;
							
							case "2" : {
								
								$stream = new Stream( "00000", $_POST[ "name" ], $_POST[ "description" ], $_POST[ "startYear" ], $_POST[ "stopYear" ] );
								
								if( $stream -> validate() ) {
									
									if( $stream -> saveToDB() ) {
										
										$pageBody .= '<div class="dialog">stream successfully saved</div>';
									
									}
								
								}
							
							}
							break;
						
						}
					
					}
					break;
					
					case "edit" : {
						
						if( isset( $_REQUEST[ "target" ] ) ) {
							
							$target = $_REQUEST[ "target" ];
							
							$stream = new Stream( $target );								
							
							$stage = "1";
							
							if( isset( $_REQUEST[ "stage" ] ) ) {
								
								$stage = $_REQUEST[ "stage" ];
							
							}
							
							switch( $stage ) {
								
								case "1" : {
									
									$pageBody .= '
<div class="dialog">
	<form action="?section=streams&action=edit"
	      method="POST">
		<fieldset class="info">
			<div class="row">
				<label>name</label>
				<input type="name"
				       name="name"
				       value="' . $stream -> getName() . '" />
			</div>
			<div class="row">
				<label>start year</label>
				<select name="startYear">';
				
									for( $i = 1; $i <= 4; $i++ ) {
										
										$addition = '';
										
										if( $i == $stream -> getStartYear() ) {
											
											$addition .= ' selected="selected"';
										
										}
				
										$pageBody .= '
					<option value="' . $i . '"' . $addition . '>' . $i . '</option>';
					
									}
					
									$pageBody .= '
				</select>
			</div>
			<div class="row">
				<label>end year</label>
				<select name="stopYear">';
				
									for( $i = 1; $i <= 4; $i++ ) {
										
										$addition = '';
										
										if( $i == $stream -> getStopYear() ) {
											
											$addition .= ' selected="selected"';
										
										}
				
										$pageBody .= '
					<option value="' . $i . '"' . $addition . '>' . $i . '</option>';
					
									}
					
									$pageBody .= '
				</select>
			</div>
			<div class="row">
				<label>notes</label>
				<textarea name="description"
				          placeholder="any other information">' . $stream -> getDescription() . '</textarea>
			</div>
		</fieldset>
		<fieldset class="buttons">
			<button type="reset">RESET</button>
			<button type="submit"
			        name="stage"
			        value="2">submit</button>
		</fieldset>
	</form>
</div>';
								
								}
								break;
								
								case "2" : {
									
								//	$stream = new Stream( "00000", $_POST[ "name" ], $_POST[ "description" ], $_POST[ "startYear" ], $_POST[ "stopYear" ] );
									
									$stream -> setName( $_POST[ "name" ] );
									$stream -> setDescription( $_POST[ "description" ] );
									$stream -> setStartYear( $_POST[ "startYear" ] );
									$stream -> setStopYear( $_POST[ "stopYear" ] );
									
									if( $stream -> validate() ) {
										
										if( $stream -> updateDB() ) {
											
											$pageBody .= '
<div class="dialog">
	<p>stream successfully saved</p>
</div>';
										
										}
									
									}
								
								}
								break;
								
							}
							
						}
						else {
							
							// You need to specify a target
						
						}
					
					}
					break;
					
					case "list" : {
						
						$streams = getStreams();
						
						if( count( $streams ) > 0 ) {
							
							$pageBody .= '
<table class="fancy">
	<thead>
		<tr>
			<th>#</th>
			<th>stream</th>
			<th>actions</th>
		</tr>
	</thead>
	<tbody>';
	
							$count = 1;
	
							foreach( $streams as $streamID ) {
								
								$stream = new Stream( $streamID );
	
								$pageBody .= '
		<tr>
			<td>' . $count . '</td>
			<td>' . $stream -> getName() . '</td>
			<td class="actions">
				<ul>
					<li>
						<a href="?section=streams&action=view&target=' . $stream -> getUniqueID() . '">view</a>
					</li>
					<li>
						<a href="?section=streams&action=edit&target=' . $stream -> getUniqueID() . '">edit</a>
					</li>
					<li>
						<a href="?section=streams&action=delete&target=' . $stream -> getUniqueID() . '">delete</a>
					</li>
				</ul>
			</td>
		</tr>';
								$count++;
			
							}
		
							$pageBody .= '
	</tbody>
</table>';
						
						}
					
					}
					break;
				
				}
			
			}
			break;
		
			case "subjects" : {
				
				$action = "list";
				
				if( isset( $_REQUEST[ "action" ] ) ) {
					
					$action = $_REQUEST[ "action" ];
				
				}
				
				switch( $action ) {
					
					case "add" : {
						
						$stage = "1";
						
						if( isset( $_REQUEST[ "stage" ] ) ) {
							
							$stage = $_REQUEST[ "stage" ];
						
						}
						
						switch( $stage ) {
							
							case "1" :
							default : {
								
								$pageBody .= '
<div class="dialog">
	<form action="?section=subjects&action=add"
	      method="POST">
		<fieldset class="info">
			<div class="row">
				<label>code</label>
				<input type="text"
				       name="code"
				       placeholder="KNEC subject code" />
			</div>
			<div class="row">
				<label>name</label>
				<input type="text"
				       name="name"
				       placeholder="What is the subject called" />
			</div>
			<div class="row">
				<label>description</label>
				<textarea name="description"
				          placeholder="any further information"></textarea>
			</div>
			<div class="row">
				<label>start year</label>
				<select name="startYear">
					<option value="1" selected>1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
				</select>
			</div>
			<div class="row">
				<label>end year</label>
				<select name="stopYear">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4" selected>4</option>
				</select>
			</div>
		</fieldset>
		<fieldset class="buttons">
			<button type="reset">RESET</button>
			<button type="submit"
			        name="stage"
			        value="2">submit</button>
		</fieldset>
	</form>
</div>';
							
							}
							break;
							
							case "2" : {
								
								$subject = new Subject( "00000", $_POST[ "code" ], $_POST[ "name" ], $_POST[ "description" ], $_POST[ "startYear" ], $_POST[ "stopYear" ] );
								
								if( $subject -> validate() ) {
									
									if( $subject -> saveToDB() ) {
								
										$pageBody .= '
<table>
	<tbody>
		<tr>
			<th>code</th>
			<td>' . $subject -> getCode() . '</td>
		</tr>
		<tr>
			<th>name</th>
			<td>' . $subject -> getName() . '</td>
		</tr>
		<tr>
			<th>description</th>
			<td>' . $subject -> getDescription() . '</td>
		</tr>
		<tr>
			<th>most junior year</th>
			<td>' . $subject -> getStartYear() . '</td>
		</tr>
		<tr>
			<th>most senior year</th>
			<td>' . $subject -> getStopYear() . '</td>
		</tr>
	</tbody>
</table>';
									}
									
								}
							
							}
							break;
						
						}
					
					}
					break;
					
					case "list" : {
						
						$subjects = getSubjects();
						
						if( count( $subjects ) > 0 ) {
							
							$pageBody .= '
<table class="fancy">
	<thead>
		<tr>
			<th>#</th>
			<th>code</th>
			<th>subject</th>
			<th>start class</th>
			<th>end class</th>
			<th>actions</th>
		</tr>
	</thead>
	<tbody>';

							$count = 1;
							
							foreach( $subjects as $subjectID ) {
								
								$subject = new Subject( $subjectID );
	
								$pageBody .= '
		<tr>
			<td>' . $count . '</td>
			<td>' . $subject -> getCode() . '</td>
			<td>' . $subject -> getName() . '</td>
			<td>Form' . $subject -> getStartYear() . '</td>
			<td>Form' . $subject -> getStopYear() . '</td>
			<td>
				<ul>
					<li>
						<a href="?section=subjects&action=view&target=' . $subject -> getUniqueID() . '">view</a>
					</li>
					<li>
						<a href="?section=subjects&action=edit&target=' . $subject -> getUniqueID() . '">edit</a>
					</li>
				</ul>
			</td>
		</tr>';
		
								$count++;
		
							}
		
							$pageBody .= '
	</tbody>
</table>';
						
						}
					
					}
					break;
					
					case "edit" : {
						
						if( isset( $_REQUEST[ "target" ] ) ) {
							
							$target = $_REQUEST[ "target" ];
							
							$subject = new Subject( $target );
							
							$stage = "1";
						
							if( isset( $_REQUEST[ "stage" ] ) ) {
								
								$stage = $_REQUEST[ "stage" ];
							
							}
							
							switch( $stage ) {
								
								case "1" :
								default : {
									
									$pageBody .= '
<div class="dialog">
	<form action="?section=subjects&action=edit"
	      method="POST">
		<fieldset class="info">
			<input type="hidden"
			       name="target"
			       value="' . $subject -> getUniqueID() . '" />
			<div class="row">
				<label>code</label>
				<input type="text"
				       name="code"
				       value="' . $subject -> getCode() . '" />
			</div>
			<div class="row">
				<label>name</label>
				<input type="text"
				       name="name"
				       value="' . $subject -> getName() . '" />
			</div>
			<div class="row">
				<label>description</label>
				<textarea name="description">' . $subject -> getDescription() . '</textarea>
			</div>
			<div class="row">
				<label>start year</label>
				<select name="startYear">
					<option value="1" selected>1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
				</select>
			</div>
			<div class="row">
				<label>end year</label>
				<select name="stopYear">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4" selected>4</option>
				</select>
			</div>
		</fieldset>
		<fieldset class="buttons">
			<button type="reset">RESET</button>
			<button type="submit"
			        name="stage"
			        value="2">submit</button>
		</fieldset>
	</form>
</div>';
							
							}
							break;
							
							case "2" : {
								
								$subject -> setCode( $_POST[ "code" ] );
								$subject -> setName( $_POST[ "name" ] );
								$subject -> setDescription( $_POST[ "description" ] ); 
								$subject -> setStartYear( $_POST[ "startYear" ] ); 
								$subject -> setStopYear( $_POST[ "stopYear" ] );
								
								if( $subject -> validate() ) {
									
									if( $subject -> updateDB() ) {
								
										$pageBody .= '
<table>
	<tbody>
		<tr>
			<th>code</th>
			<td>' . $subject -> getCode() . '</td>
		</tr>
		<tr>
			<th>name</th>
			<td>' . $subject -> getName() . '</td>
		</tr>
		<tr>
			<th>description</th>
			<td>' . $subject -> getDescription() . '</td>
		</tr>
		<tr>
			<th>most junior year</th>
			<td>' . $subject -> getStartYear() . '</td>
		</tr>
		<tr>
			<th>most senior year</th>
			<td>' . $subject -> getStopYear() . '</td>
		</tr>
	</tbody>
</table>';
										}
									
									}
								
								}
								break;
							
							}
						
						}
					
					}
					break;
					
					case "view" : {}
					break;
				
				}
			
			}
			break;
			
			case "tests" : {
				
				$action = "list";
				
				if( isset( $_REQUEST[ "action" ] ) ) {
					
					$action = $_REQUEST[ "action" ];
				
				}
				
				switch( $action ) {
					
					case "add" : {
						
						$stage = "1";
						
						if( isset( $_REQUEST[ "stage" ] ) ) {
							
							$stage = $_REQUEST[ "stage" ];
						
						}
						
						switch( $stage ) {
							
							case "1" : {
								
								$pageBody .= '
<div class="dialog">
	<form action="?section=tests&action=add"
	      method="POST">
		<fieldset class="info">
			<div class="row">
				<label>startDate</label>
				<input type="date"
				       name="startDate"
				       value="' . date( "Y-m-d" ) . '" />
			</div>
			<div class="row">
				<label>type</label>
				<select name="type">
					<option value="1">CAT</option>
					<option value="2">exam</option>
				</select>
			</div>
			<div class="row">
				<label>most junior class</label>
				<select name="startYear">
					<option value="1" selected>form 1</option>
					<option value="2">form 2</option>
					<option value="3">form 3</option>
					<option value="4">form 4</option>
				</select>
			</div>
			<div class="row">
				<label>most senior class</label>
				<select name="stopYear">
					<option value="1">form 1</option>
					<option value="2">form 2</option>
					<option value="3">form 3</option>
					<option value="4" selected>form 4</option>
				</select>
			</div>
		</fieldset>
		<fieldset class="buttons">
			<button type="reset">RESET</button>
			<button type="submit"
			        name="stage"
			        value="2">submit</button>
		</fieldset>
	</form>
</div>';
							
							}
							break;
							
							case "2" : {
					
								$test = new Test( "00000", $_POST[ "startDate" ], $_POST[ "type" ], $_POST[ "startYear" ], $_POST[ "stopYear" ] );
								
								if( $test -> validate() ) {
									
									if( $test -> saveToDB() ) {
								
										$pageBody .= '
<table>
	<tbody>
		<tr>
			<th>date</th>
			<td>' . $test -> getStartDate() . '</td>
		</tr>
		<tr>
			<th>type</th>
			<td>' . $test -> getType() . '</td>
		</tr>
		<tr>
			<th>senior year</th>
			<td>' . $test -> getStopYear() . '</td>
		</tr>
		<tr>
			<th>junior year</th>
			<td>' . $test -> getStartDate() . '</td>
		</tr>
	</tbody>
</table>';

									}

								}
							
							}
							break;
						
						}
					
					}
					break;
					
					case "edit" : {
						
						if( isset( $_REQUEST[ "target" ] ) ) {
						
							$target = $_REQUEST[ "target" ];
							
							$test = new Test( $target );
							
							$stage = "1";
							
							if( isset( $_REQUEST[ "stage" ] ) ) {
								
								$stage = $_REQUEST[ "stage" ];
							
							}
							
							switch( $stage ) {
								
								case "1" : {
									
									
								
								}
								break;
								
								case "2" : {
									
									
								
								}
								break;
							
							}

						}
						else {
							
							// There was an error, a target needs to be specified
						
						}
					
					}
					break;
					
					case "entry" : {
						
						$mode = "bulk";
						
						if( isset( $_REQUEST[ "mode" ] ) ) {
							
							$mode = $_REQUEST[ "mode" ];
							
						}
						
						switch( $mode ) {
							
							case "bulk" : {
						
								if( ( isset( $_REQUEST[ "yearOfStudy" ] ) ) && ( isset( $_REQUEST[ "subjectCode" ] ) ) && ( isset( $_REQUEST[ "yearSat" ] ) ) && ( isset( $_REQUEST[ "session" ] ) ) ) {
									
									// Get student who are in that year of study, who take that subject and also find which tests are in that year and session
								
								}
								else {
									
									// Error : please ensure all options were selected
									
									$pageBody .= '
<div class="dialog">
	<form action="?section=tests&action=entry&mode=bulk"
	      method="POST">
		<fieldset class="info">
			<div class="row">
				<label>year of study</label>
				<select name="yearOfStudy">
					<option value="1">Form 1</option>
					<option value="2">Form 2</option>
					<option value="3">Form 3</option>
					<option value="4">Form 4</option>
				</select>
			</div>
			<div class="row">
				<label>subject</label>
				<select name="subjectCode">
					<option value="101">English</option>
					<option value="102">Kiswahili</option>
				</select>
			</div>
			<div class="row">
				<label>year test was sat</label>
				<input type="text"
				       name="yearSat"
				       value="' . date( "Y" ) . '"
				       placeholder="" />
			</div>
			<div class="row">
				<label>term</label>
				<select name="session">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
				</select>
			</div>
		</fieldset>
		<fieldset>
			<button type="reset">reset</button>
			<button type="submit">submit</button>
		</fieldset>
	</form>
</div>';
								
								}
								
							}
							break;
							
							case "individual" : {
								
								
							
							}
							break;
							
						}
					
					}
					break;
					
					case "list" :
					default : {
						
						$tests = getTests();
												
						if( count( $tests ) > 0 ) {
						
							$pageBody .= '
<table class="fancy">
	<thead>
		<tr>
			<th>#</th>
			<th>type</th>
			<th>date</th>
			<th>most junior class</th>
			<th>most senior class</th>
		</tr>
	</thead>
	<tbody>';
	
							$count = 1;
	
							foreach( $tests as $testID ) {
								
								$test = new Test( $testID );
	
								$pageBody .= '
		<tr>
			<td>' . $count . '</td>
			<td>' . $testTypes[ $test -> getType() ] . '</td>
			<td>' . $test -> getStartDate() . '</td>
			<td>form ' . $test -> getStartYear() . '</td>
			<td>form ' . $test -> getStopYear() . '</td>
		</tr>';
		
								$count++;
		
							}
		
							$pageBody .= '
	</tbody>
</table>';
					
						}
						else {
							
							$pageBody .= '
<div class="dialog">
	<p>There is nothing to view here</p>
</div>';
						
						}

					}
					break;
				
				}
			
			}
			break;
		
		}
	
	}
	
}
else {
	
	// Not logged on, allow log in and registration
	
	$section = "access";
	
	if( isset( $_REQUEST[ "section" ] ) ) {
		
		$section = $_REQUEST[ "section" ];
	
	}
	
	switch( $section ) {
		
		case "access" :
		default : {
			
			$action = "toggle";
			
			if( isset( $_REQUEST[ "action" ] ) ) {
				
				$action = $_REQUEST[ "action" ];
			
			}
			
			switch( $action ) {
								
				case "toggle" :
				default : {
					
					$stage = "1";
					
					if( isset( $_REQUEST[ "stage" ] ) ) {
						
						$stage = $_REQUEST[ "stage" ];
					
					}
					
					switch( $stage ) {
						
						case "2" : {
							
							// Process the log in
						
							$query = '
SELECT
	COUNT(*)
FROM
	`userDetails`
WHERE
	`status` = "1"
AND
	`screenName` = "' . mysql_escape_string( $_POST[ "screenName" ] ) . '"
AND
	`passwordHash` = MD5( "' . mysql_escape_string( $_POST[ "password" ] ) . '" )';
						
											
							$query2 = '
SELECT
	`uniqueID`,
	`screenName`
FROM
	`userDetails`
WHERE
	`status` = "1"
AND
	`screenName` = "' . mysql_escape_string( $_POST[ "screenName" ] ) . '"
AND
	`passwordHash` = MD5( "' . mysql_escape_string( $_POST[ "password" ] ) . '" )';
											
							try {
								
								if( $result = $dbh -> query( $query ) ) {
									
									if( $result -> fetchColumn() == 1 ) {
										
										foreach( $dbh -> query( $query2 ) as $row ) {
							
											$_SESSION[ "user" ][ "loggedIn" ] = Array(
												  "screenName" => $row[ "screenName" ]
												, "userID" => $row[ "uniqueID" ]
											);							

										}
										
									}
									
								}
								else {
									
									$pageBody .= '
<div class="message">
	<h4>Log In Error : 001</h4>
	<p>There was an Error trying to log you in :(</p>
	<p>Please contact the site administrator if this persists</p>
</div>';
										
								}
								
							}
							catch( PDOException $e ) {

								print "Error!: " . $e -> getMessage() . "<br/>";

								die();

							}					
								
							// Redirect
							$host = $_SERVER[ 'HTTP_HOST' ];
							$uri = rtrim( dirname( $_SERVER[ 'PHP_SELF' ] ), '/\\' ); 
							
							// If no headers are sent, send one
							if( !headers_sent() ) {
								
								header( "Location: http://" . $host . $uri . "/" ); 
								exit;						

							}							
						
						}
						break;
						
						case "1" :
						default : {
							
							$pageBody .= '
<div class="dialog">
	<form action="?section=access&action=toggle"
		  method="POST">
		<fieldset class="info">
			<div class="row">
				<label>username</label>
				<input type="text"
					   name="screenName"
					   placeholder="your username" />
			</div>
			<div class="row">
				<label>password</label>
				<input type="password"
					   name="password" />
			</div>
		</fieldset>
		<fieldset class="buttons">
			<button type="reset">RESET</button>
			<button type="submit"
					name="stage"
					value="2">LOG IN</button>
		</fieldset>
	</form>
</div>';
							
						}
						break;
					
					}
				
				}
				break;
			
			}
		
		}
		break;
		
	}

}

	
	$format = "html";
	
	if( isset( $_REQUEST[ "format" ] ) ) {
	
		$format = $_REQUEST[ "format" ];
	
	}
	
	switch( $format ) {
		
		case "ajax" : {
			
			$output = $pageBody;
		
		}
		break;
		
		case "html" :
		default : {
			
			$output = $pageHeader . $pageBody . $pageFooter;
		
		}
		break;
	
	}
	
	echo $output;

?>
