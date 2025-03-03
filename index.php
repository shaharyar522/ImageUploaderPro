<?php include("./connection.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <div class="container">
        <h1>Image Upload</h1>
    </div>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="no">Enter Your Number</label>
        <input type="number" name="Number" id="no" placeholder="Enter Your Number">
        <br><br>
        <label for="img-file">Please Choose an Image</label>
        <input id="img-file" type="file" name="image_path">
        <br><br>
        <button type="submit">Upload Data</button>
        <input type="hidden" name="btnupload" value="sub">
    </form>

    <?php
    if (isset($_POST['btnupload'])  && $_POST['btnupload'] == 'sub') {

        $Number = $_POST['Number'];
        $image_name = $_FILES['image_path']['name'];
        $image_tmp_name = $_FILES['image_path']['tmp_name'];
        $image_size = $_FILES['image_path']['size'];
        $image_type = $_FILES['image_path']['type'];


        // ab mohjay batana hian ka maray pass jo images hian wo kn say folder main save hngi 
        $folder = "upload_image/" . $image_name;
        //ab main es ko buydefault ek jo k image ko move_pload ka funtion karo ga es main 2 arguments laita hian
        // ek harmaray pass image_tmp_name or dosra hamray pass image ka folder name

        move_uploaded_file($image_tmp_name, $folder);


        $insert_query = "INSERT INTO images (`img_id`, `Number`, `Image_path`) VALUES (img_id , '$Number' , '$folder')";

        $result = mysqli_query($conn, $insert_query);

        if ($result) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Your image has been inserted successfully!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                          window.location.href = 'index.php';
                    });
                  </script>";
            exit();
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Your image could not be inserted!',
                    });
                  </script>";
        }
    }
    ?>
    <br>
    <br>
    <br> 


    <!-- uay hamray pass table hian  -->
    <div class="container">
        <h2>Simple Table</h2>
        <table>
            <thead>
                <tr>
                    <th>img_id </th>
                    <th>Number</th>
                    <th>Image_path</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $select_query = "SELECT *FROM images";

                $result = mysqli_query($conn, $select_query);
                $img_id =0;
                while($row = mysqli_fetch_assoc($result))    {
                $img_id ++;
                 echo 
                 "<tr>
                 <td>".$row['img_id']."</td>
                 <td>".$row['Number']."</td>
                  <td><img src='" . $row['Image_path'] . "' width='100' height='100' style='border-radius: 8px;'></td>
                 </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
   

</body>

</html>