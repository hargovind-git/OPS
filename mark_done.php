<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $documentId = $_POST['documentId'];

    // Load existing data
    $data = json_decode(file_get_contents('uploads/data.json'), true);

    // Update the status of the specific document
    foreach ($data as &$doc) {
        if ($doc['id'] === $documentId) {
            $doc['status'] = 'done';
            break;
        }
    }

    // Save the updated data back to the file
    file_put_contents('uploads/data.json', json_encode($data, JSON_PRETTY_PRINT));

    // Redirect back to the dashboard
    header('Location: shop_owner.php');
    exit;
}
?>
