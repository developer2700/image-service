<!DOCTYPE html>
<html>
<head>
    <title>Generated Image</title>
</head>
<body>
    <h1>Generated Image</h1>
    <?php $imageName = filter_input(INPUT_GET, 'image', FILTER_SANITIZE_URL);?>
    
    <img src="storage/<?=$imageName?>" alt="Generated Image" />
    <div><a href="/" title="home" >Return to HomePage</a></div>
    
</body>
</html>
