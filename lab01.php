<style type="text/css">
	table, th, td {
		border: 1px solid black;
		border-collapse: collapse;
		position: relative;
		padding: 0 5px;
	}
	.highest-score{
		background-color: blue;
	}
	.lowest-score{
		background-color:red;
	}
	.searching-notice {
		position: absolute;
		top: 0;
	}
	.searching-info {
		position: relative;
	}		
</style>

<body>
	<table>
		<tr>
			<th>STT</th>
			<th>Tên SV</th>
			<th>Ngày sinh</th>
			<th>Điểm trung bình</th>
		</tr>
		<tr>
			<?php
				$myFile = fopen("StudentList.txt","r") or die("Unable to open file");
				$students = [];
				while (!feof($myFile))
				{
					$line = fgets($myFile);
					$students[] = explode("| ", $line);
				}
				fclose($myFile);
				
				function findHighestAverage($students){
					$maxAverage = -INF;

					foreach ($students as $student) {
						$average = floatval($student[3]);
						if ($average > $maxAverage) {
							$maxAverage = $average;
						}
					}
					
					return $maxAverage;
				}				

				$time_start_max = microtime(true);
				$maxScore = max(array_column($students, 3));
				$time_end_max = microtime(true);
				
				$time_total_max = $time_end_max - $time_start_max;
				echo $time_total_max;
				echo "<br>";
				
				$time_start_function = microtime(true);
				$maxScoreStudent = findHighestAverage($students);
				$time_end_function = microtime(true);
				
				$time_total_function = $time_end_function - $time_start_function;
				echo $time_total_function;
				
				$time_distance = abs($time_total_function - $time_total_max);
				echo "<br>Thời gian chênh lệch ".$time_distance;
				
				$minScore = min(array_column($students, 3));

				foreach($students as $line)
				{
					$score = floatval($line[3]);
					$class = '';
					
					if ($score == $maxScore)
					{
						$class = 'highest-score';
					} elseif ($score == $minScore)
					{
						$class = 'lowest-score';
					}
					
					echo "<tr class = '$class'>";
					foreach($line as $value)
					{
						echo "<td>".$value."</td>";
					}
					echo "</tr>";
				}
			?>
		</tr>
	</table>
	
	<div class = "searching-info">
	<?php
		$time_start = microtime(true);
		//Searching
		$searchId = isset($_GET['Id']) ? $_GET['Id'] : null;
		$searchName = isset($_GET['Name']) ? $_GET['Name'] : null;

		$found = false;
		$printed = false;
		foreach ($students as $student) {
			if (($searchId !== null && $student[0] == $searchId) || ($searchName !== null && strpos($student[1], $searchName) !== false)) {
				$found = true;
				$printed = true;
			}
			if ($printed) {
				echo "<br>Thông tin sinh viên: <br>";
				echo "Số thứ tự: " . $student[0] . "<br>";
				echo "Tên SV: " . $student[1] . "<br>";
				echo "Ngày sinh: " . $student[2] . "<br>";
				echo "Điểm trung bình: " . $student[3] . "<br>";
			}
			$printed = false;
		}
		if($searchId == null && $searchName == null)
		{
			echo '';
		}
		elseif ($found) {
			echo "<div class = 'searching-notice'> <b>Search Found</b></div>";
		}
		else {
			echo "<div class = 'searching-notice'><b>Not Found</b></div>";
		}
		
		$time_end = microtime(true);
		$time_diff = $time_end - $time_start;
		echo "<div>Thời gian thực thi: ".$time_diff." giây</div>";
	?>
	</div>
</body>

