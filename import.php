<?php
  ob_start();
  session_start();
    $title="Import Books";
    include_once "includes/header.php";
?>
<script>
    // functionality to copy text from inviteCode to clipboard

    // trigger copy event on click
    $('#copy').on('click', function(event) {
        console.log(event);
        console.log("event");
    copyToClipboard(event);
    });

    // event handler
    function myFunction() {
      /* Get the text field */
      var copyText = document.getElementById("myInput");

      /* Select the text field */
      copyText.select();
      copyText.setSelectionRange(0, 99999); /*For mobile devices*/

      /* Copy the text inside the text field */
      document.execCommand("copy");

      /* Alert the copied text */
      document.getElementById("mydiv").setAttribute('title',"copied");
    }
          
</script>
<section id="contact" class="padd-section"> 
  <div class="container" data-aos="fade-up">
    <div class="section-title text-center">
      <h2>Form</h2>
      <p class="separator">Choose List from below</p>
      <p class="separator">again it's only one shelf</p>
      <div class="col-md-4 mb-3 mt-5 " style="margin-left:358px">
        <div class="input-group">
          <input type="text" class="form-control" id="myInput" value="https://api.jsonbin.io/b/5f4ff13b514ec5112d14dc5f/latest" aria-describedby="inputGroupPrepend" readonly>
          <div class="input-group-prepend" id="mydiv" onclick="myFunction()" title="copy">
            <button class="input-group-text" id=""><i class="fa fa-copy fa-4x" aria-hidden="true"></i></button>
          </div>
        </div>
      </div>
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
                $list->setRemoteUrl($_POST['url']);
                //get remote list data
                $list->getRemote();
                $content = $list->getRemoteList();
                //extract books 
                $items = $content["books"];
                // add books one by one 
                for ($i=0; $i < sizeof($items); $i++){
                  $list->setItem($items[$i]);
                  $list->import();
                }
                //add book
                ob_start();
                header("location:view.php?list=$listName");
            }
        ?>
        <div class="form">
          <form action="" method="POST" class="list">
            <div class="form-group">
              <input type="hidden" name="listname" value="<?php echo $listName?>" />
              <input type="url" name="url" class="form-control" id="url" placeholder="List URL" required/>
            </div>
            <div class="text-center"><button name="btn_add" type="submit">Import</button></div>
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

