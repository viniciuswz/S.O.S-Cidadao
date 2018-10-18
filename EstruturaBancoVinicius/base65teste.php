// baseFromJavascript will be the javascript base64 string retrieved of some way (async or post submited)
$baseFromJavascript = "data:image/png;base64,BBBFBfj42Pj4"; // $_POST['base64']; //your data in base64 'data:image/png....';
// We need to remove the "data:image/png;base64,"
$base_to_php = explode(',', $baseFromJavascript);
// the 2nd item in the base_to_php array contains the content of the image
$data = base64_decode($base_to_php[1]);
// here you can detect if type is png or jpg if you want
$filepath = "/path/to/my-files/image.png"; // or image.jpg

// Save the image in a defined path
file_put_contents($filepath,$data);


OU


// requires php5
    define('UPLOAD_DIR', 'images/');
    $img = $_POST['img'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $file = UPLOAD_DIR . uniqid() . '.png';
    $success = file_put_contents($file, $data);
    print $success ? $file : 'Unable to save the file.';
    
    
    ou
    
    define('UPLOAD_DIR', 'uploads/');
foreach ($_REQUEST['image'] as $value) {
$img = $value;
$img = str_replace('data:image/jpeg;base64,', '', $img);
$data = base64_decode($img);
$file = UPLOAD_DIR . uniqid() . '.png';
$success = file_put_contents($file, $data);
$data1[] = $file;
}
