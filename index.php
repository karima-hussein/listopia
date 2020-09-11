<?php
    ob_start();
    session_start();

    $title="Home";
    include_once "includes/headerBefore.php";
    //check if the user is loged in 
    if(!isset($_SESSION['user'])){
      
?>
      <script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous">
      </script>
      <script>
        $(document).ready(function() {
          popup();
          function popup() {
            $(".logindiv").css("display", "block");
            $("#hero").css("display", "none");
            $("#header").css("display", "none");
          };
        });
      </script>
    <?php 
      }else{
        include_once "includes/header.php";
      }
    ?>
  <!-- popup login form -->
  <section id="contact" style="display:none;" class="padd-section logindiv">
    
    <div class="container" data-aos="fade-up">
      <div class="section-title text-center">
        <h2>Login</h2>
        <p class="separator">you need to login first</p>
      </div>

      <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="100">
        <?php
            include_once "includes/user.php";
            $user = new user();
            if(isset($_POST['login'])){
              $user->setUsername($_POST['name']);
              $user->setPassword($_POST['password']);
              $login = $user->login();

              if($login === "username is not valid"){
                echo '<script type="text/javascript">
                toastr.error("username is not valid!");</script>';
              }else if($login === "wrong password"){
                echo '<script type="text/javascript">
                toastr.error("wrong password!");</script>';
              }else{
                $_SESSION['user']=$login;
                $_SESSION['name']=$_POST['name'];
                header("location:index.php");
              }
            }
        ?>
        <div class="col-lg-5 col-md-8">
          <div class="form">
            <form action="index.php" method="POST" class="list">
              <div class="form-group">
                <input type="text" name="name" class="form-control" id="name" placeholder="User Name" required/>
              </div>
              <div class="form-group">
                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required/>
              </div>
              <div class="text-center"><button name="login" type="submit">Login</button></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ======= Hero Section ======= -->
  <section id="hero">
      
    <div class="hero-container" data-aos="fade-in" id="main-content">
      
      <img src="assets/img/hero-img.png" alt="Hero Imgs" data-aos="zoom-out" data-aos-delay="100">
      <a href="create.php" class="btn-get-started scrollto">Get Started </a>

    </div>
  </section><!-- End Hero Section -->

  <main id="main">
<?php
  include_once "includes/footer.php";
?>
