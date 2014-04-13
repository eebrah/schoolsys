#SchoolSys

Open source, Web based Management Information System for schools

##Installation

##Database structure

<pre>

		+----------------+
		| studentDetails |
		+----------------+-------+---------------+
		| uniqueID               | VARCHAR( 5 )  |<-----|
		| name                   | VARCHAR( 80 ) |      |
		| yearOfStudyAtAdmission | INT           |      |
		| gender                 | INT           |      |
		| dateOfAdmission        | TIMESTAMP     |      |
		+------------------------+---------------+      |
				                                |
		+------------+                                  |
		| testScores |                                  |
		+-----------++-------------+                    |
		| studentID | VARCHAR( 5 ) |<-------------------|
	|------>| testID    | VARCHAR( 5 ) |
	|	| subjectID | VARCHAR( 5 ) |<-------------------|
	|	| score     | INT          |			|
	|	+-----------+--------------+			|
	|							|
	|	+-------------+					|
	|	| testDetails |					|
	|	+-----------+-+------------+			|
	|------>| uniqueID  | VARCHAR( 5 ) |			|
		| type      | INT          |			|
		| startDate | TIMESTAMP    |			|
		+-----------+--------------+			|
								|
		+----------------+				|
		| subjectDetails |				|
		+-------------+--+------------+			|
		| uniqueID    | VARCHAR( 5 )  |<----------------|
		| code        | VARCHAR( 3 )  |
		| name        | VARCHAR( 80 ) |
		| description | TEXT          |
		+-------------+---------------+

</pre>
