<html>
<body>

import csv

Welcome <?php echo Number of Guides is $_POST["Guides"]; ?><br>
Your Shift Rotation is: <?php echo $_POST["Rotation"]; ?>

$expand = array("IF"=>"Info Desk",
				"RF"=>"Rain Forest",
				"A"=>"Australia",
				"LS"=>"Seashore",
				"BT"=>"Black Tip Reef",
				"3"=>"3rd Floor",
				"4"=>"4th Roam",
				"UV"=>"Underwater",
				"2"=>"2nd Floor",
				"J"=>"Jellies",
				"R"=>"Roam");



with open('Schedule.csv','r') as csvfile:
	#reader can iterate over lines of csv file
	csvreader = csv.reader(csvfile)
	
	#reading first row of field names
	fields = csvreader.__next__()
	print('Field Names\n--------------')
	for field in fields:
		print("%8s"%field, end='')

	print('\nRows\n---------------------')	
	#reading rows
	for row in csvreader:
		#access and print each field value of row
		for col in row: 
			print("%8s"%col, end='')
		print('\n')



</body>
</html>
