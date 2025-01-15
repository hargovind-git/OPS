<?php
// Include necessary libraries for PDF page count (FPDI)
require_once('fpdf.php');
require_once('fpdi.php');

// Initialize variables for error handling
$error = '';
$success = '';
$uploadDir = 'uploads/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $customerName = htmlspecialchars($_POST['name']);
    $customerMobile = htmlspecialchars($_POST['mobile']);
    $printType = htmlspecialchars($_POST['type']); // 'bw' or 'color'

    // Handle file upload
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png']; // Allowed file types

        // Validate file type
        if (in_array($fileExtension, $allowedExtensions)) {
            // Move file to upload directory
            $destinationPath = $uploadDir . $fileName;
            if (move_uploaded_file($fileTmpPath, $destinationPath)) {
                // Calculate page count for PDF or treat image as 1 page
                if ($fileExtension === 'pdf') {
                    $pdf = new FPDI();
                    $pageCount = $pdf->setSourceFile($destinationPath); // Get actual page count
                } else {
                    $pageCount = 1; // Non-PDF files are treated as single-page prints
                }

                // Calculate cost based on print type
                $costPerPage = ($printType === 'bw') ? 3 : 5; // 3 INR for B/W, 5 INR for Color
                $estimatedCost = $pageCount * $costPerPage;

                // Redirect to feedback page with details
                header("Location: feedback.php?name=$customerName&mobile=$customerMobile&pages=$pageCount&type=$printType&cost=$estimatedCost");
                exit;
            } else {
                $error = 'Error moving the file to the upload directory.';
            }
        } else {
            $error = 'Unsupported file type. Only PDF, JPG, JPEG, and PNG are allowed.';
        }
    } else {
        $error = 'Please upload a file.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #2193b0, #6dd5ed);
            color: #fff;
            text-align: center;
            padding: 50px;
        }
        .form-box {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            border-radius: 10px;
            padding: 30px;
            display: inline-block;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .form-box h1 {
            color: #2193b0;
        }
        .form-box input, .form-box select, .form-box button {
            width: 90%;
            margin: 10px auto;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .form-box button {
            background-color: #2193b0;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }
        .form-box button:hover {
            background-color: #6dd5ed;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
        .success {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h1>Upload Your Document</h1>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Enter Your Name" required>
            <input type="text" name="mobile" placeholder="Enter Your Mobile Number" required>
            <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png" required>
            <select name="type" required>
                <option value="bw">Black & White</option>
                <option value="color">Color</option>
            </select>
            <button type="submit">Upload</button>
        </form>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
