<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="script.js"></script>
    <link rel="icon" href="assets/img/Kalarrrii-final-logo-150x150.ico" type="image/x-icon">

    <title>Registration Form</title>
</head>
<body>
    <h2 class="toph2">-</h2>  
     <h2 class="text-center">KALARI Ayurletics Studio</h2>
    <h2 class="text-center">Kerala Ayurveda & Panchakarma Clinic</h2>
    <h2 class="text-center">Booking Form</h2>
    <h2 class="toph2">-</h2> 
    <div class="container"> 
        <p style="color:red;"><b>* All the Fields are Required</b></p>
        <form  action="db.php" method="POST">

        <div class="row jumbotron">

            <!-- Educational Trust: -->
            <div class="col-sm-12 form-group">
            <label for="username" class="white">Name<span style="color:red;">*</span></label>
            <input class="form-control" type="text" id="username" name="username" required>
            </div>
            <div class="col-sm-6 form-group">
            <label for="phone" class="white">Phone<span style="color:red;">*</span></label>
        <input class="form-control" type="tel" id="phone" name="phone" required maxlength="10" pattern="[0-9]{10}">
        </div>
            
            <div class="col-sm-6 form-group">
        <label for="email" class="white">Email<span style="color:red;">*</span></label>
        <input class="form-control" type="email" id="email" name="email" required>
            </div>
            <div class="col-sm-6 form-group">
            <label for="address"class="white" >Address</label>
            <input class="form-control" type="text" id="address" name="address">
            </div>
	    <div class="col-sm-6 form-group">
            <label for="problem" class="white" >problem<span style="color:red;">*</span></label>
            <input class="form-control" type="problem" id="problem" name="problem" required>
	    </div> 

            <div class="col-sm-6 form-group">
            <label for="bookingDate" class="white">Booking Date<span style="color:red;">*</span></label>
            <input class="form-control" type="date" id="bookingDate" name="bookingDate" required>
            </div>
            <div class="col-sm-6 form-group">
            <label for="bookingTime" class="white" >Booking Time<span style="color:red;">*</span></label>
        <select class="form-control" id="bookingTime" name="bookingTime" required>
        </select>
            </div>
            

            <div class="col-sm-12 form-group mb-0">
                <button class="btn btn-warning" type="submit">Submit</button>  <button class="btn btn-warning" type="reset">Reset </button>
                <!--       <button class="btn btn-success">Submit</button>-->
            </div>
        </div>
        </form>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
    const bookingTimeSelect = document.getElementById('bookingTime');
    const bookingDateInput = document.getElementById('bookingDate');
    const now = new Date();

    // Populate Booking Date with Today's Date as Minimum
    const today = now.toISOString().split('T')[0];
    bookingDateInput.min = today;

    // Populate Time Options Based on Current Time
    function populateTimes() {
        const selectedDate = new Date(bookingDateInput.value);
        const isToday = selectedDate.toISOString().split('T')[0] === today;
        const startHour = 10; // Start at 10:00 AM
        const endHour = 20;  // End at 8:00 PM
        let currentHour = isToday ? Math.max(now.getHours() + 1, startHour) : startHour;

        bookingTimeSelect.innerHTML = ''; // Clear previous options

        while (currentHour <= endHour) {
            const timeOption = document.createElement('option');
            timeOption.value = `${currentHour}:00:00`;
            timeOption.textContent = `${currentHour}:00`;
            bookingTimeSelect.appendChild(timeOption);
            currentHour++;
        }
    }

    bookingDateInput.addEventListener('change', populateTimes);

    // Initialize time options on load
    bookingDateInput.value = today;
    populateTimes();
});
    </script>
</body>
</html>
