<?php
    require_once("./config.php"); // Require configuration file

    if (isset($_POST['submit']))
    {
	    $file = $_FILES['file'];

	    $fileName = $file['name'];
	    $fileTmpName = $file['tmp_name'];
	    $fileSize = $file['size'];
	    $fileError = $file['error'];
	    $fileType = $file['type'];

	    $fileExt = explode('.', $fileName);
	    $fileActualExt = strtolower(end($fileExt));

	    $allowed = array('jpg', 'jpeg', 'png');

	    if (in_array($fileActualExt, $allowed))
        {
		    if ($fileError === 0)
            {
			    if ($fileSize < 2000000)
                {
				    $fileNameNew = uniqid('', true).".".$fileActualExt;
                    $filePath = '../uploads/' . $username . '/';
				    $fileDestination = $filePath . '/' . $fileNameNew;

                    // Create upload directory for user if it does not exist yet
                    if (!is_dir($filePath))
                    {
                        mkdir($filePath);
                        move_uploaded_file($fileTmpName, $fileDestination);
                        header("Location: ../account.php?uploadsuccess");
                        exit();
                    }
                    else
                    {
                        move_uploaded_file($fileTmpName, $fileDestination);
                        header("Location: ../account.php?uploadsuccess");
                        exit();
                    }
			    }
                else
                {
				    //echo "Your file is too big!";
                    header("Location: ../account.php?uploaderror=size");
			    }
		    }
            else
            {
                // Error type 1 is a max_file_size error
                if ($fileError === 1)
                {
                    header("Location: ../account.php?uploaderror=size");
                }
                else
                {
                    header("Location: ../account.php?uploaderror=general");
                }
		    }
	    }
        else
        {
		    //echo "You cannot upload files of this type!";
            header("Location: ../account.php?uploaderror=type");
	    }
    }

?>