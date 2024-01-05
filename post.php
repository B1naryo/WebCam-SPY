<?php

// Generate a unique timestamp
$date = date('dMYHis');

// Check if 'cat' is set in the POST data
if (isset($_POST['cat'])) {
    // Extract image data from POST
    $imageData = $_POST['cat'];

    // Remove data URI scheme and base64 decode the image data
    $filteredData = substr($imageData, strpos($imageData, ",") + 1);
    $unencodedData = base64_decode($filteredData);

    // Specify the folder and filename to save the image
    $folderPath = 'cam/';
    $filePath = $folderPath . 'cam' . $date . '.png';

    // Create the folder if it doesn't exist
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    // Open the file for writing
    $fp = fopen($filePath, 'wb');

    // Write the decoded image data to the file
    fwrite($fp, $unencodedData);

    // Close the file
    fclose($fp);

    // Log success
    error_log("Image saved at: $filePath" . "\r\n", 3, "Log.log");

    // Send a response if needed
    echo json_encode(['success' => true]);

} else {
    // Log an error if 'cat' is not set
    error_log("Error: 'cat' not set in POST data" . "\r\n", 3, "Log.log");

    // Send an error response if needed
    echo json_encode(['error' => 'Missing image data']);
}

// Exit the script
exit();
?>

