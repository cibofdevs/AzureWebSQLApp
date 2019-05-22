<html>
 <head>
 <Title>Employee Data</Title>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 </head>
 <body>
   <div class="container">
       <p style="margin-top: 20px" class="alert alert-danger">Fill in your identity, then click <strong>Submit</strong></p>
       <form method="post" action="index.php" enctype="multipart/form-data">
             <div class="form-group">
              <label>Name</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="Enter name">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="text" name="email" id="email" class="form-control" placeholder="Enter email">
            </div>
            <div class="form-group">
              <label>Job</label>
              <input type="text" name="job" id="job" class="form-control" placeholder="Enter job">
            </div>
            <input type="submit" name="submit" value="Submit" class="btn btn-success" />
            <input type="submit" name="load_data" value="Load Data" class="btn btn-primary" />
       </form>
       <?php
          $host = "cibofappserver.database.windows.net";
          $user = "cibof";
          $pass = "@cdesi9n'";
          $db = "db_cibofwebapp";

          try {
              $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
              $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
          } catch(Exception $e) {
              echo "Failed: " . $e;
          }

          if (isset($_POST['submit'])) {
              try {
                  $name = $_POST['name'];
                  $email = $_POST['email'];
                  $job = $_POST['job'];
                  $date = date("Y-m-d");
                  // Insert data
                  $sql_insert = "INSERT INTO Employee (name, email, job, date) 
                              VALUES (?,?,?,?)";
                  $stmt = $conn->prepare($sql_insert);
                  $stmt->bindValue(1, $name);
                  $stmt->bindValue(2, $email);
                  $stmt->bindValue(3, $job);
                  $stmt->bindValue(4, $date);
                  $stmt->execute();
              } catch(Exception $e) {
                  echo "Failed: " . $e;
              }

              echo "<h3>Submit Successfully!</h3>";
          } else if (isset($_POST['load_data'])) {
              try {
                  $sql_select = "SELECT * FROM Employee";
                  $stmt = $conn->query($sql_select);
                  $emps = $stmt->fetchAll(); 
                  if(count($emps) > 0) {
                      echo "<h3>Employee List:</h3>";
                      echo "<table class='table'>";
                      echo "<tr><th>Name</th>";
                      echo "<th>Email</th>";
                      echo "<th>Job</th>";
                      echo "<th>Date</th></tr>";
                      foreach($emps as $emp) {
                          echo "<tr><td>".$emp['name']."</td>";
                          echo "<td>".$emp['email']."</td>";
                          echo "<td>".$emp['job']."</td>";
                          echo "<td>".$emp['date']."</td></tr>";
                      }
                      echo "</table>";
                  } else {
                      echo "<h3>Employee data is empty.</h3>";
                  }
              } catch(Exception $e) {
                  echo "Failed: " . $e;
              }
          }
       ?>
   </div>
 </body>
 </html>
