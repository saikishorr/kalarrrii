<iframe  class="shrivraWidget" src="https://kalarrriiayurleticsstudio.salonist.io/booking" style="width: 100%; max-width: 770px; height: 500px;border: none; margin:10px auto;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:center!important;-ms-flex-pack:center!important;justify-content:center!important"></iframe>


    <script type="text/javascript" id="salonistScript" src="https://kalarrriiayurleticsstudio.salonist.io/js/booking-button.js"></script>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission</title>
</head>
<body>
    <h1>Submit Your Details</h1>
    <form action="processform.php" method="post">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="message">Message:</label><br>
        <textarea id="message" name="message" rows="4" cols="50" required></textarea><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
