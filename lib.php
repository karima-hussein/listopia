<?php
    $title="Library";
    ob_start();
    session_start();
    include_once "includes/header.php";
    include_once "includes/booklist.php";
    $list = new booklist();
    $list->setRemoteUrl("https://api.jsonbin.io/b/5f4ff13b514ec5112d14dc5f/latest");
    $list->getRemote();
    $content = $list->getRemoteList();
    $books = $content["books"];
?>

<section  class="padd-section text-center">
        <div class="container" >
            <div class="section-title text-center pt-5">
                <h2>welcome to our humble library :D</h2>
                <p>well , it's just one shelf </p>
            </div>
        </div>
        <div class="container">
        <table class="table table-striped table-hover" id="myDataTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Author</th>
                        <th scope="col">Release Date</th>
                        <th scope="col">Cover</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        for($i=0; $i< sizeof($books); $i++){
                    ?>
                    <tr>
                        <th scope="row"><?php echo $i+1;?></th>
                        <td><?php echo $books[$i]["book name"];?></td>
                        <td><?php echo $books[$i]["author"];?></td>
                        <td><?php echo $books[$i]["release date"];?></td>
                        <td><img src="assets/img/<?php echo $books[$i]["cover image"];?>" alt="book image" width="70px" height="65px"></td>
                        <td>
                            <a class="btn btn-tiny btn-danger" title="Delete" href="delete.php?book=<?php echo $books[$i]["book name"];?>&list=<?php echo $lName;?>" role="button"><i class="fa fa-trash fa-4x" aria-hidden="true"></i></a>

                            <a class="btn btn-tiny btn-info" title="View Book"  target="_blank" href="assets/books/<?php echo $books[$i]["book name"];?>.pdf" role="button"><i class="fa fa-eye fa-4x" aria-hidden="true"></i></a>

                            <a class="btn btn-tiny btn-success" title="Direct Download" href="download.php?n=<?php echo $books[$i]["book name"];?>" role="button"><i class="fa fa-download fa-4x" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                        <?php }?>
                </tbody>
            </table>

        </div>
        
</secion>
<?php
    include_once "includes/footer.php";
?>