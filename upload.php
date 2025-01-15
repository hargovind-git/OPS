<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['fileUpload'])) {
    $customerName = htmlspecialchars(trim($_POST['customerName']));
    $customerMobile = htmlspecialchars(trim($_POST['customerMobile']));
    $printType = htmlspecialchars(trim($_POST['printType']));
    $delivery = htmlspecialchars(trim($_POST['delivery']));
    $fileTmpPath = $_FILES['fileUpload']['tmp_name'];
    $fileName = $_FILES['fileUpload']['name'];
    $fileType = $_FILES['fileUpload']['type'];
    $uploadDir = 'uploads/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $allowedTypes = ['application/pdf', 'application/msword', 'image/jpeg', 'image/png', 'image/jpg'];
 
    if (in_array($fileType, $allowedTypes)) {
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        // Generate a safe and unique file name
        $randomNumber = mt_rand(100000, 999999);
        $safeFileName = strtolower(preg_replace("/[^a-zA-Z0-9]/", "_", $customerName . '_' . $customerMobile));
        $newFileName = $safeFileName . '_' . $randomNumber . '.' . $fileExtension;

        $uploadFile = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $uploadFile)) {
            // Estimate Calculation
            $pageCount = 10; // Placeholder for page count logic
            $costPerPage = ($printType === 'bw') ? 3 : 5;
            $estimatedCost = $pageCount * $costPerPage;

            // Save Order Data to JSON
            $orderData = [
                'customerName' => $customerName,
                'customerMobile' => $customerMobile,
                'documentName' => $newFileName,
                'pages' => $pageCount,
                'printType' => $printType,
                'estimatedCost' => $estimatedCost,
                'status' => 'pending'
            ];

            $jsonFilePath = 'orders.json';

            // Read existing JSON file
            $existingData = file_exists($jsonFilePath) ? json_decode(file_get_contents($jsonFilePath), true) : [];

            // Append new order
            $existingData[] = $orderData;

            // Save updated data back to JSON
            file_put_contents($jsonFilePath, json_encode($existingData, JSON_PRETTY_PRINT));

            // Redirect to feedback
            header("Location: feedback.php?name=" . urlencode($customerName) . "&mobile=" . urlencode($customerMobile) . "&pages=$pageCount&type=$printType&cost=$estimatedCost");
            exit;
        } else {
            echo 'There was an error uploading the file.';
        }
    } else {
        echo 'Invalid file type. Please upload a PDF, Word, or image file.';
    }
} else {
    echo 'No file uploaded or form submission error.';
}
?>

