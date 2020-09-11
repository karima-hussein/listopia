<?php
  ob_start();
  session_start();
    $lName = $_GET['list'];
    $title=$lName;
    include_once "includes/header.php";
    include_once "includes/booklist.php";
    $list = new booklist();
    $list->setUserIndex($_SESSION['user']);
    $list->setListName($lName);
    $books =$list->getBookByListIndex();

?>
    <section  class="padd-section text-center">
        <div class="container" >
            <div class="section-title text-center">
                <h2><?php echo $lName;?></h2>
            </div>
        </div>
        <div class="container">
            <?php
                if(empty($books)){
                    echo '<div class="section-title text-center">
                    <h2>No books has been added yet!</h2>
                </div>';
                }else{
            ?>
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
                    }
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
        <div>
            <a title="add new book" class="btn  btn-info" href="addbook.php?list=<?php echo $lName;?>" role="button"><i class="fa fa-pencil fa-4x" aria-hidden="true"></i></a>
            <a title="Import from library" class="btn  btn-success" href="import.php?list=<?php echo $lName;?>" role="button"><i class="fa fa-copy fa-4x" aria-hidden="true"></i></a>
        </div>

    </secion>

<?php include_once "includes/footer.php";?>