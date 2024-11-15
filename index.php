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
     <h2 class="text-center">KALARRRII Ayrletics Studio</h2>
    <h2 class="text-center">Kerla Ayurveda & Panchakarma Clinic</h2>
    <h2 class="text-center">Booking Form</h2>
    <h2 class="toph2">-</h2>
    <div class="container">
        <p style="color:red;"><b>* All the Fields are Required</b></p>
        <form id="bookingForm">

        <div class="row jumbotron">

            <!-- Educational Trust: -->
            <div class="col-sm-12 form-group">
            <label for="username" class="white">Name*</label>
            <input class="form-control" type="text" id="username" name="username" required>
            </div>
            <div class="col-sm-12 form-group">
            <label for="phone">Phone*</label>
        <input class="form-control" type="tel" id="phone" name="phone" required maxlength="10" pattern="[0-9]{10}">
        </div>
            
            <div class="col-sm-12 form-group">
        <label for="email">Email*</label>
        <input class="form-control" type="email" id="email" name="email" required>
            </div>
            <div class="col-sm-12 form-group">
            <label for="address">Address</label>
            <textarea class="form-control" id="address" name="address"></textarea>
            </div>
            <div class="col-sm-12 form-group">
            <label for="bookingDate">Booking Date*</label>
            <input class="form-control" type="date" id="bookingDate" name="bookingDate" required>
            </div>
            <div class="col-sm-12 form-group">
            <label for="bookingTime">Booking Time*</label>
        <select class="form-control" id="bookingTime" name="bookingTime" required>
            <!-- Options will be populated dynamically -->
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
        // Populate initial date and time
        document.addEventListener('DOMContentLoaded', function () {
            // Fetch client's date
            const currentDate = new Date().toISOString().split('T')[0];
            document.getElementById('bookingDate').setAttribute('min', currentDate);
            document.getElementById('bookingDate').value = currentDate;

            // Populate time slots
            const timeSelect = document.getElementById('bookingTime');
            const startTime = 9; // 9:00 AM
            const endTime = 17; // 5:00 PM
            for (let hour = startTime; hour < endTime; hour++) {
                const timeOption = document.createElement('option');
                timeOption.value = `${hour}:00`;
                timeOption.textContent = `${hour}:00`;
                timeSelect.appendChild(timeOption);

                // const halfHourOption = document.createElement('option');
                // halfHourOption.value = `${hour}:30`;
                // halfHourOption.textContent = `${hour}:30`;
                // timeSelect.appendChild(halfHourOption);
            }
        });

        // Example JS to disable booked slots (client-side simulation)
        document.getElementById('bookingDate').addEventListener('change', function () {
            // Simulated booked slots for a specific date
            const bookedSlots = {
                '2024-11-16': ['9:00', '9:30']
            };

            const selectedDate = this.value;
            const timeSelect = document.getElementById('bookingTime');
            const options = timeSelect.querySelectorAll('option');
            options.forEach(option => {
                option.disabled = bookedSlots[selectedDate]?.includes(option.value) || false;
            });
        });

        // Form submission
        // Form submission
document.getElementById('bookingForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const form = this;
    const formData = new FormData(form);
    fetch('process_booking.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.includes('already booked')) {
            alert(data); // Alert user if the slot is already booked
        } else if (data.includes('successful')) {
            alert(data); // Display success message
            form.reset(); // Reset the form
        } else {
            console.error(data); // Log any other errors
        }
    })
    .catch(error => console.error('Error:', error));
});


    </script>
</body>
</html>
