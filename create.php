<?php
  ob_start();
  session_start();
    $title="Create List";
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
        
          if(isset($_POST['btn_create'])){            
              $listName = $_POST['listName'];
              $list->setUserIndex($_SESSION['user']); //set user index
              $names = $list->getLists(); //get user list names

              if(!in_array($listName, $names)){  //check if the new name already exists
                $list->setListName($listName);
                $add=$list->createList();
                header("location:lists.php");
              }else{ 
                echo '<script type="text/javascript">
                toastr.error("list name already exists!");</script>';
              }
          }
        ?>
        <div class="form">
          <form action="create.php" method="post" role="form" class="list">
            <div class="form-group">
              <input type="text" name="listName" value="<?php if(isset($_POST['listName'])){echo $_POST['listName'];}else{echo "";} ?>" class="form-control" id="listname" placeholder="List Name"/>
              <div class="validate"></div>
            </div>
            <div class="text-center"><button name="btn_create" type="submit">Create</button></div>
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

