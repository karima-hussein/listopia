<?php
  ob_start();
  session_start();
    $title="Add Book";
    include_once "includes/header.php";
?>
<section id="contact" class="padd-section">
  
  <div class="container" data-aos="fade-up">
    <div class="section-title text-center">
      <h2>Form</h2>
      <p class="separator">create a new list</p>
    </div>

    <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="100">

      <div class="col-lg-5 col-md-8">
        <?php
            include_once "includes/booklist.php";
            $list = new booklist();
            $list->setUserIndex($_SESSION['user']);
            $listName=$_GET['list'];
                    
            if(isset($_POST['btn_add'])){
                // set list name first
                $list->setListName($_POST['listname']);
                //set book info
                $list->setName($_POST['bookName']);
                $list->setAuthor($_POST['author']);
                $list->setReleaseDate($_POST['release']);
                //handling cover image
                $file= $_FILES['img'];
                $img_name = $file['name'];
                $img_temp = $file['tmp_name'];
                $fileExe = explode('.',$img_name);
                $ext = strtolower(end($fileExe));
                $newName = uniqid('',true).".".$ext;
                $des ="assets/img/$newName";
                move_uploaded_file($img_temp,$des);
                $list->setCover($newName);
                //add book
                $add=$list->addBook();
                ob_start();
                header("location:view.php?list=$listName");
            }
        ?>
        <div class="form">
          <form action="" method="POST" class="list" enctype="multipart/form-data">
            <div class="form-group">
              <input type="hidden" name="listname" value="<?php echo $listName?>" />
              <input type="text" name="bookName" class="form-control" id="bookName" placeholder="Book Name" required/>
            </div>
            <div class="form-group">
              <input type="text" name="author" class="form-control" id="author" placeholder="Author Name" required/>
            </div>
            <div class="form-group">
              <input type="date" name="release" class="form-control" id="release" required/>
            </div>
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="img" required>
                <label class="custom-file-label" for="cover">Choose file...</label>
            </div>
            
            <div class="text-center"><button name="btn_add" type="submit">Add</button></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section><!-- End Contact Section -->
<?php
    include_once "includes/footer.php";
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

