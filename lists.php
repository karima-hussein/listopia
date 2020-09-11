<?php
  ob_start();
  session_start();
    $title="My Lists";
    include_once "includes/header.php";
    include_once "includes/booklist.php";
    $list = new booklist();
    $list->setUserIndex($_SESSION['user']);
    $listNames = $list->getLists();

?>
    <section id="get-started" class="padd-section text-center">
        <div class="container" data-aos="fade-up">
            <div class="section-title text-center">
            </div>
        </div>

        <div class="container">
            <div class="row">
                <?php
                    for($i=0;$i < sizeof($listNames); $i++){
                ?>
                <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="feature-block">
                        <img src="assets/img/svg/cloud.svg" alt="img" class="img-fluid">
                        <h4><?php echo $listNames[$i];?></h4>
                        <a href="view.php?list=<?php echo $listNames[$i];?>">view list</a>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>

</section><!-- End Get Started Section -->

<?php include_once "includes/footer.php";?>