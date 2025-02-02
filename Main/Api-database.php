<?php session_start();?>
<?php include 'functions.php';?>

<?php

$servername = "localhost";
$database = $_SESSION["_dbname"];
$username = "root";
$password = "";
$tableName;
$columns = array();
$columnNames = array();

/* Get the table Name */
if(isset($_POST["tableName"]) == false)
{
    $tableName = $_SESSION["_tableName"];
}
else
{
    $tableName = $_POST["tableName"];
    $_SESSION["_tableName"] = $_POST["tableName"];
}

createConnection1($servername, $username, $password, $database);

/* Check If Tablename is Valid */
validateTable($database, $tableName, $conn);      

/* Returns the column Infomation for the selected Table */
columnInfo($tableName, $conn);

?>

<?php
if($_SESSION["_dbname"] == "")
{
    header("location: ../Errors/Error-db.php");
}
?>
<head>
<link rel = "stylesheet" type = "text/css" href = "../CSS/Api-database.css" ></link>   
</head>
<body>
    <div class = "background-image">
        <div class = "modal2"></div>
    </div>

    <div class = "information2" style = "height: 125px;">
    <b>Connected to:</b> <?php print_r($database); ?> <br>
    
    <b>Using table:</b> <?php print_r($tableName)?> <br>
    
    <b>Column Names:</b> <br><?php
    for($i = 0; $i < sizeof($columnNames); $i++)
    {print_r($columnNames[$i] . " <br>");}
    ?> <br>

    </div>


    <!-- Edit the database -->
    <div class = "editdb" id = "edit">
        <div class = "text-in">Edit Database and tables</div>
        <div class = "line"></div>
        <br>
        <button class = "button5" type = "button" onclick = "window.location.href = 'Api-table.php';">View Table Information<i class = "m" style = "background-image: url('../Images/view.png');"></i></button><br>
        <button class = "button5" type = "button" id = "btn1">Add Table Information<i class = "m" style = "background-image: url('../Images/new.png');"></i></button><br>
        <button class = "button5" type = "button" id = "btn2">Update Table Information<i class = "m" style = "background-image: url('../Images/update.png'); left: 220px;"></i></button><br>
        <button class = "button5" type = "button" id = "btn3">Create New Table<i class = "m" style = "background-image: url('../Images/new.png');"></i></button><br> 
        <button class = "button5" type = "button" id = "btn4">Delete Table Information<i class = "m" style = "background-image: url('../Images/remove.png');"></i></button><br>
        <button class = "button5" type = "button" id = "btn5">Delete A Table<i class = "m" style = "background-image: url('../Images/remove2.png');"></i></button><br>
        <button class = "button5" type = "button" id = "btn6">Rename Table<i class = "m" style = "background-image: url('../Images/rename-32.png');"></i></button><br>
        <button class = "button5" type = "button" id = "btn7">Empty Table Information<i class = "m" style = "background-image: url('../Images/empty-box-32.png'); left: 220px;"></i></button><br>
        <button class = "button5" type = "button" id = "btn8">Connect to new Table<i class = "m" style = "background-image: url('../Images/connect-32.png');"></i></button><br>
        <button class = "button5" type = "button" id = "btn9">Upload Table Inforamtion<i class = "m" style = "background-image: url('../Images/upload-32.png'); left: 227px;"></i></button><br>
        <button class = "button5" type = "button" id = "btn5" onclick = "window.location.href = 'Api-main.php';">Return to home<i class = "m" style = "background-image:url('../Images/home.png');"></i></button><br>
    </div>

    <!-- Add info to database -->
    <div class = "database-div" id = "info1">
        <span id = "span01" onclick = "document.getElementById('info1').style.display = 'none'" class = "close" title = "Close Modal" ></span>
        <br>
        <div class = "text-modal">Add Information</div><br><br>
        <form method = "post" action = "worker.php">

        <?php
        /* enables the form to shift depending on the table information */
        for($i = 0; $i < sizeof($columnNames); $i++)
        {
            echo"
            <div class = 'text-modal'>$columnNames[$i]</div>
            <input type = 'text' name = 'value$i' placeholder = 'Enter value' autocomplete = 'off' required>
            <br><br>
            ";
        }
        ?>

            <button class = "button4" type = "submit" style = "left: 40%;" name = "addBtn">Confirm</button>
        </form>
    </div>

    <!-- Update database Info -->
    <div class = "database-div" id = "info2">
        <span id = "span02" onclick = "document.getElementById('info2').style.display = 'none'" class = "close" title = "Close Modal" ></span>
        <br>       
        <div class = "text-modal">Update Information</div><br>
        <form method = "post" action = "worker.php">
            <div class = "text-modal">Enter Old value</div><br>
            <input type = "text" name = "ID" placeholder = "Enter ID" autocomplete = "off" required>
            <br><br>
            <div class = "text-modal">Enter field(Column) that will be changed</div><br>
            <input type = "text" name = "changeID" placeholder = "Enter value" autocomplete = "off" required>
            <br><br>
            <div class = "text-modal">Enter new Value</div><br>
            <input type = "text" name = "newID" placeholder = "Enter new value" autocomplete = "off" required>
            <br><br>
            
            <button class = "button4" type = "submit" style = "left: 40%;" name = "updateBtn">Confirm</button>
        </form>
    </div>

    <!-- Create new Table -->
    <div class = "database-div" id = "info3">
        <span id = "span03" onclick = "document.getElementById('info3').style.display = 'none'" class = "close" title = "Close Modal" ></span>
        <br>       
        <div class = "text-modal">Create new Table</div><br>
        <form method = "post" action = "worker.php">
            <div class = "text-modal">New Table Name</div>
            <input type = "text" placeholder = "Table Name" name = "newTable" autocomplete = "off" required>
                <br>
                <br>
                    <div class = "text" style = "color: white;">Number of Table Columns:</div>
                                    <select style = "width:50px; height:25px; border-radius:5px; position:absolute; left: 268px;">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                    </select>
                                    <br>
                                    <br>
                <div class="tooltip">Additional Information
                    <span class="tooltiptext">When naming your database ensure that: <br>
                                            <br>
                                            1)It has no spaces between words<br>
                                            2)IF you want spaces, use the underscore(_)<br>
                                            3)These same rules apply to the column names<br>
                                            4)All database Names will be converted to LOWERCASE
                                            <br>
                                            When inserting column types: <br>
                                            <br>
                                            1)for 'int' values ensure you enter the type + number of digits<br>
                                            Example: varchar(255) or int(10)<br>
                                            2)for columns containing words: use varchar<br>
                                            3)for columns containing integers: use int<br>
                    </span>
                </div>
                <br>
                <br>                    
                <div class = "text" style = "color: white;">Column 1:</div>
                <input type = "text2" placeholder = "Name" name = "column1" autocomplete = "off" required><select style = "width: 80px; left:365px; top:2px;"name = "c1type">
                                                                                                    <option value = "none" selected disabled>Type</option>
                                                                                                    <option>varchar(255)</option>
                                                                                                    <option>int(15)</option>
                                                                                                  </select>
                <br>
                <div class = "text" style = "color: white;">Column 2:</div>
                <input type = "text2" placeholder = "Name" name = "column2" autocomplete = "off"><select style = "width: 80px; left:365px; top:2px;"name = "c2type">
                                                                                                    <option value = "none" selected disabled>Type</option>
                                                                                                    <option>varchar(255)</option>
                                                                                                    <option>int(15)</option>
                                                                                                  </select>
                <br>
                <div class = "text" style = "color: white;">Column 3:</div>
                <input type = "text2" placeholder = "Name" name = "column3" autocomplete = "off"><select style = "width: 80px; left:365px; top:2px;"name = "c3type">
                                                                                                    <option value = "none" selected disabled>Type</option>
                                                                                                    <option>varchar(255)</option>
                                                                                                    <option>int(15)</option>
                                                                                                  </select>
                <br>
                <div class = "text" style = "color: white;">Column 4:</div>
                <input type = "text2" placeholder = "Name" name = "column4" autocomplete = "off"><select style = "width: 80px; left:365px; top:2px;"name = "c4type">
                                                                                                    <option value = "none" selected disabled>Type</option>
                                                                                                    <option>varchar(255)</option>
                                                                                                    <option>int(15)</option>
                                                                                                  </select>
                <br>
                <button class = "button4" type = "submit" style = "left: 40%;" name = "tbBtn">Confirm</button>
                
            </form>
    </div>

    <!-- Delete database info-->
    <div class = "database-div" id = "info4">
        <span id = "span04" onclick = "document.getElementById('info4').style.display = 'none'" class = "close" title = "Close Modal" ></span>
        <br>     
        <div class = "text-modal">Delete Table Information</div>
        <form method = "post" action = "worker.php">
            <br>
            <div class = "text-modal">Enter ID</div>
            <input type = "text" name = "delID" placeholder = "Enter ID" autocomplete = "off" required>
            <br><br>

            <button class = "button4" type = "submit" style = "left: 40%;" name = "delDbBtn">Confirm</button>
        </form>
    </div>

    <!-- Delete Table -->
    <div class = "database-div" id = "info5">
        <span id = "span05" onclick = "document.getElementById('info5').style.display = 'none'" class = "close" title = "Close Modal" ></span>
        <br>       
        <div class = "text-modal">Delete A Table</div><br>
        <div class = "text-modal">This will remove the table from the database, unable to return, proceed with caution</div><br>
        <form method = "post" action = "worker.php">
            <div class = "text-modal">Enter Table Name</div><br>
            <input type = "text" name = "delTable" placeholder = "Enter table name" autocomplete = "off" required>
            <br><br>

            <button class = "button4" type = "submit" style = "left: 40%;" name = "delTbBtn">Confirm</button>
        </form>
    </div>
    
    <!-- Empty Table Information -->
    <div class = "database-div" id = "info7">
        <span id = "span07" onclick = "document.getElementById('info7').style.display = 'none'" class = "close" title = "Close Modal"></span>
        <br>
        <div class = "text-modal">Empty Table Data</div><br>
        <div class = "text-modal">This will remove all the information in the Table, please proceed with caution. Lost information cannot be returned again</div><br>
        <form method = "post" action = "worker.php">
            <div class = "text-modal">Enter Table Name</div><br>
            <input type = "text" name = "emptyTable" placeholder = "Enter table name" autocomplete = "off" required>
            <br><br>

            <button class = "button4" type = "submit" style = "left: 40%;" name = "emptyTb">Confirm</button>
        </form>
    </div>

    <!-- Rename Table -->
    <div class = "database-div" id = "info6">
        <span id = "span06" onclick = "document.getElementById('info6').style.display = 'none'" class = "close" title = "Close Modal"></span>
        <br>
        <div class = "text-modal">Rename Table</div><br>
        <form method = "post" action = "worker.php">
            <div class = "text-modal">Enter Old Table Name</div><br>
            <input type = "text" name = "oldTable" placeholder = "Enter old table name" autocomplete = "off" required>
            <br><br>

            <div class = "text-modal">Enter New Table Name</div><br>
            <input type = "text" name = "newTb" placeholder = "Enter new table name" autocomplete = "off" required>
            <br><br>

            <button class = "button4" type = "submit" style = "left: 40%;" name = "renameTb">Confirm</button>
        </form>
    </div>

    <!-- Connect to a Table -->
    <div class = "database-div" id = "info8">
        <span id = "span08" onclick = "document.getElementById('info8').style.display = 'none'" class = "close" title = "Close Modal"></span>
        <br>
        <div class = "text-modal">Connect to a Table</div><br>
        <form method = "post" action = "worker.php">
            <div class = "text-modal">Enter Table Name</div><br>
            <input type = "text" name = "connectTable" placeholder = "Table name" autocomplete = "off" required>
            <br><br>

            <button class = "button4" type = "submit" style = "left: 40%;" name = "renameTb">Confirm</button>
        </form>
    </div>

    <!-- Upload Table Information -->
    <div class = "database-div" id = "info9">
        <span id = "span09" onclick = "document.getElementById('info9').style.display = 'none'" class = "close" title = "Close Modal"></span>
        <br>
        <div class = "text-modal">Upload Table Information</div><br>
        <form method = "post" action = "worker.php">
            <div class = "text-modal">This Feature will be made available in the near future...</div><br>
            
        </form>
    </div>


</body>

<script src = "Api-database.js"></script>
