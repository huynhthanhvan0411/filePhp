<?php
// define variable uploadOk if =1 can upload, =0 can not 
$uploadOk = 1;

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    if(isset($_FILES["fileToUpload"])) {
        // define where is folder save image
        $target_dir = "images/";
        // Kiểm tra xem người dùng đã chọn tệp để tải lên chưa
        if(!empty($_FILES["fileToUpload"]["name"])) {
            // define name of image will upload 
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            // convert to lower character of image file
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
            // Nếu tên file đã tồn tại, thực hiện ghi đè hoặc tạo file mới
            if (file_exists($target_file)) {
                // Kiểm tra xem người dùng đã chọn ghi đè hay tạo file mới
                if(isset($_POST['ghide'])) {
                    // Ghi đè 
                    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                    echo "File has been overwritten.";
                } elseif(isset($_POST['create'])) {
                    // Tạo file mới
                    $new_file_name = uniqid() . '.' . $imageFileType; 
                    $new_target_file = $target_dir . $new_file_name; 
                    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $new_target_file);
                    echo "New file has been created.";
                }
            } else {
                // Nếu file chưa tồn tại, tiến hành tải lên như bình thường
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            echo "Please select a file to upload.";
        }
    } else {
        echo "Error occurred while uploading file.";
    }

    // // Check file size not to large 5mb
    if ($_FILES["fileToUpload"]["size"] > 5000000000) {
    echo "Your file is too large.";
    $uploadOk = 0;
    }
    // // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png"  ) {
    echo "Only JPG, PNG  files are allowed.";
    $uploadOk = 0;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Upload</title>
</head>

<body>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <p>Please select your choice:</p>
        <input type="radio" id="ghide" name="ghide" value="ghide">
        <label for="ghide">Ghi đè</label><br>
        <input type="radio" id="create" name="create" value="create">
        <label for="create">Tạo file mới</label><br>
        <input type="submit" value="Upload Image" name="submit">
    </form>

</body>

</html>