<?php
  $insert = false;
  $update = false;
  $delete = false;
  //conct db
  $servername="localhost";
  $username="root";
  $password="";
  $db="vinotes";

  // Create a connection
  $conn=mysqli_connect($servername, $username, $password, $db);

  // Die if connection was not successful
  if (!$conn) {
    die("Connection Failed! Error: ". mysqli_connect_error());
  }

  if(isset($_GET['delete'])){
    $s_no = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `notes` WHERE `s_no` = $s_no";
    $result = mysqli_query($conn, $sql);
  }
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset( $_POST['s_noEdit'])){
      // Update the record
      $s_no = $_POST["s_noEdit"];
      $title = $_POST["titleEdit"];
      $description = $_POST["descriptionEdit"];

      // Sql query to be executed
      $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`s_no` = $s_no";
      $result = mysqli_query($conn, $sql);
      if($result){
        $update = true;
      }
      else{
        echo "We could not update the record successfully";
      }
    }

    else{
      $title=$_POST['title'];
      $description=$_POST['description'];

      $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
      $result = mysqli_query($conn, $sql);

      if($result){
        $insert = true;
      }
      else{
        echo "The record was not inserted successfully because of this error ---> ". mysqli_error($conn);
      }
    }
  }

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="css/master.css">

    <!-- Favicon -->
    <link rel="icon" href="/photos/favicon-32x32.png">

    <!-- font -->
    <link href="" rel="stylesheet" type="text/css"/>
    <link href="" rel="stylesheet">


    <title>ViNotes</title>
  </head>
  <body>

    <!-- Edit Modal -->
    <div class="modal" tabindex="-1" id="editModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit this Note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/PHP/ViNotes/index.php" method="post">
              <input type="hidden" name="s_noEdit" id="s_noEdit">
              <div class="mb-3 ">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="textlabel">
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Note Description</label>
                <textarea type="" class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


    <!-- navbar ------->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">ViNotes</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/PHP/ViNotes/index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contect us</a>
            </li>
          </ul>
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>

    <?php
      if ($insert) {
        echo '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
          <strong>Success!</strong> Your note has been inserted successfully!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div> ';
      }
    ?>
    <?php
    if($delete){
    echo '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
      <strong>Success!</strong> Your note has been deleted successfully!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div> ';
    }
    ?>
    <?php
      if($update){
      echo '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
        <strong>Success!</strong> Your note has been updated successfully!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div> ';
      }
    ?>


    <section class="top_section">
      <div class="insert_div">
        <h1>Add a Note to ViNotes</h1>
        <form action="/PHP/ViNotes/index.php" method="post">
          <div class="mb-3 ">
            <label for="title" class="form-label">Note Title</label>
            <input type="text" class="form-control" id="title" name="title" aria-describedby="textlabel">
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Note Description</label>
            <textarea type="" class="form-control" id="description" name="description" rows="3"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
      </div>
      <div class="notedata">
        <table class="table table-hover" id="myTable">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Title</th>
              <th scope="col">Description</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $sql = "SELECT * from `notes`";
              $result = mysqli_query($conn, $sql);
              $sno = 0;
              while($row = mysqli_fetch_assoc($result)){
                $sno++;
                echo "<tr>
                        <th scope='row'>".$sno."</th>
                        <td>".$row['title']."</td>
                        <td>".$row['description']."</td>
                        <td> <button class='edit btn btn-sm btn-primary' id=".$row['s_no'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['s_no'].">Delete</button></td>
                      </tr>";
              }
            ?>
          </tbody>
        </table>
      </div>
    </section>


    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready( function () {
        $('#myTable').DataTable();
      } );
    </script>
    <script type="text/javascript">
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
          console.log("edit ");
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          console.log(title, description);
          titleEdit.value = title;
          descriptionEdit.value = description;
          s_noEdit.value = e.target.id;
          console.log(e.target.id)
          $('#editModal').modal('toggle');
        })
      })

      deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
          console.log("delete");
          s_no = e.target.id.substr(1);
          console.log(s_no);
          if (confirm("Are you sure you want to delete this note!")) {
            console.log("yes");
            window.location = `/PHP/ViNotes/index.php?delete=${s_no}`;
            // TODO: Create a form and use post request to submit a form
          }
          else {
            console.log("no");
          }
        })
      })
    </script>
    <!-- Font Awesome -->
    <script src="" crossorigin="anonymous"></script>

  </body>
</html>
