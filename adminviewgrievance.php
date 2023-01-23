<?php
require 'config.php';
session_start();

$sql = "SELECT g.usn,g.name,g.subject,g.text,g.radio FROM grievance g";

$result = $conn->query($sql);

$sql1 = "SELECT candidateusn,count(*) as votecount from vote v group by candidateusn ";
$result1 = mysqli_query($conn, $sql1);

while ($row = $result1->fetch_assoc()) {
  $countarray[$row["candidateusn"]] = $row["votecount"];
}

while ($row = $result->fetch_assoc()) {

  $storeusn[] = $row["usn"];
  $storename[] = $row["name"];
  $storesubject[] = $row["subject"];
  $storetext[] = $row["text"];
  

}

if (isset($_POST['usnval'])) {
  //$usnval[]=$_POST["usnval"];
  echo ("usn value is : " . $_POST['usnval']);
}


?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width ,initial-scale = 1.0">

  <title>Grievance List</title>
  <!-- <link rel="stylesheet" href="css/preloginstyle.css"> -->
  <link rel="stylesheet" href="css/navbarstyle.css">
  <link rel="stylesheet" href="css/preloginstyle.css">
  <style>
    * {
      font-family: sans-serif;
      margin: 0;
      padding: 0;
    }

    body {
      background: #ebeef1;
    }

    .container {
      width: 80%;
      margin: auto;
      padding-top: 100px;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    .boxes {
      border: none;
      border-radius: 20px;
      width: 50%;
      height: 220px;
      display: flex;
      margin: 5px;
      align-items: center;
      justify-content: center;
      text-align: center;
      box-shadow: 5px 5px 5px -1px rgba(10, 99, 169, 0.16),
        -5px -5px 5px -1px rgba(255, 255, 255, 0.70);
      transition: 300ms all;
      background-size: cover;
      background-position: center;
      background: #ebeef1;
      padding: 10px 5px;
    }

    a {
      color: blue;
      text-decoration: none;
    }

    .boxes:hover {
      transform: scale(1.05);
    }

    .boxes:hover .box-content {
      background-color: transparent;
      color: black;
    }

    .btn {
      width: 100%;
      border: transparent;
      margin: 42px 0 2px;
      height: 39px;
      font-size: 15px;
      border-radius: 10px;
      padding: 5px 12px;
      box-sizing: border-box;
      outline: none;
      box-shadow: 5px 5px 5px -1px rgba(10, 99, 169, 0.10),
        -5px -5px 5px -1px rgba(255, 255, 255, 0.50);
      cursor: pointer;
    }

    .btn:hover {
      box-shadow: inset 5px 5px 5px -1px rgba(10, 99, 169, 0.16),
        inset -5px -5px 5px -1px rgba(255, 255, 255, 0.70);
    }

    p {
      color: #496072;
    }

    .bottom-gap {
      padding: 40px;
    }
  </style>
</head>

<body>

  <header>
    <div class="logo">MCE Portal</div>
    <div class="hamburger">
      <div class="line"></div>
      <div class="line"></div>
      <div class="line"></div>
    </div>
    <nav class="nav-bar">
      <ul>
        <li>
          <a href="" href="adminlogout.php">Logout</a>
        </li>
        <li>
          <a href="adminviewlist.php">Schedule</a>
        </li>
        <li>
          <a class="active">Grievance</a>
        </li>
        <li>
          <a href="">About</a>
        </li>
        <!-- <li>
                <a href="">Link 4</a>
            </li> -->
      </ul>
    </nav>
  </header>

  <div class="container">

  </div>
  <div class="bottom-gap"></div>

  <!-- <script src="js/script.js" type="text/javascript" charset="utf-8"></script>-->
  <script src="displaydetails.js"></script>
</body>

</html>
<script>
  var namedetails = new Array();
  var usndetails = new Array();
  var subjectdetails = new Array();
  var textdetails = new Array();
  //var countvalue=new Array();
  namedetails = <?= json_encode($storename) ?>;
  usndetails = <?= json_encode($storeusn) ?>;
  subjectdetails = <?= json_encode($storesubject) ?>;
  textdetails = <?= json_encode($storetext) ?>;
  countvalue = <?= json_encode($countarray) ?>;
  console.log(countvalue);
  let keys = Object.keys(countvalue);
  for (let i = 0; i < usndetails.length; i++) {
    if (countvalue[usndetails[i]] == undefined) {
      countvalue[usndetails[i]] = 0;
    }
  }
  for (var i = 0; i < namedetails.length; i++) {

    let divelement = document.createElement('div');
    divelement.style.marginTop = "30px";
    divelement.innerHTML = `
  <form action="" method="post" style="display:flex">
  <div id="detfetch${i}">
    <p>Feedback ${i+1}</p><br>
    <h2>${namedetails[i]}</h2>
    <h2>${usndetails[i]}</h2><br>
   
    <h3>
      Votes: ${countvalue[usndetails[i]]}
    </h3>
    <input type="hidden" id="usnvalue" name="usnval" value="${usndetails[i]}" >

    <br><a href="displaydetails.html" class="btn" onclick=opengoogle(textdetails[${i}])>Read Grievance</a>
    </form>
  </div><br>`;
    var dynamic = document.querySelector('.container');
    dynamic.appendChild(divelement);
    divelement.classList.add("boxes");

  }
  //console.log(details);
  function opengoogle(name) {
    //console.log("abc",name);
    console.log(name);
    sessionStorage.setItem("fulldetails", name)
    // var data =name;

    //location.replace("displaydetails.html"+data);
  }
</script>