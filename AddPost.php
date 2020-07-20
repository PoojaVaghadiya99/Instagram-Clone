<head>
<style>
.btn-file 
{
  position: relative;
  overflow: hidden;
}
.btn-file input[type=file] 
{
  position: absolute;
  top: 0;
  right: 0;
  min-width: 100%;
  min-height: 100%;
  font-size: 100px;
  text-align: right;
  filter: alpha(opacity=0);
  opacity: 0;
  outline: none;
  background: white;
  cursor: inherit;
  display: block;
}

.select_image
{
    border:2px solid black;
    height:200;
    width:200;
}
</style>
</head>
<?php
    include("Header.php");
?>
<div class="container card p-3 mt-5 mb-5 col-lg-6 col-md-10 col-10">
  <h3 class="text-center mb-3">Add Post</h3>
    <form action="index.php" method="post" enctype="multipart/form-data">
    <div class="form-group m-2 p-2 h5 small">
        <label for="title">Title</label>
        <input type="tect"  class="form-control" placeholder="title" id="title" name="title" />
    </div>
    <div class="form-group m-2 p-2 h5 small">
        <label for="description">Title</label>
        <textarea name="description" id="description"  class="form-control" placeholder="Description"></textarea>
    </div>
    
    <center>
    <div class="form-group m-2 p-2 h5 small btn btn-primary btn-file">
        <label for="img">Choose File</label>
        <input type="file" id="img" onchange="loadFile(event)" class="form-control" name="img" />
        <img id="output" class="rounded mx-auto d-block img-fluid" height="200" width="100%" />
    </div>
    </center>
    <!-- <div class="text-center">
        
    </div> -->
    <!-- <input type="file" accept="image/*" onchange="loadFile(event)"> -->
    
    <!-- <img id="output"  class="select_image"/> -->
    <script>
    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
        }
    };
    </script>
        <center><button type="submit" name="add_post" class="btn btn-primary m-2"> Add Post</button></center>
 
    </form>
</div>
<?php
    include("Footer.php"); 
?>