<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>New Email</title>
     <link rel="stylesheet" href="./css/style.css">
</head>
<body>
     <div class="form-container">
          <form method="post" action="./uploud/save_booking.php">
               <h2 class="form-title">Noah Academy</h2>

               <label for="booking_name">Order Name:</label>
               <input type="text" id="booking_name" name="booking_name" required><br>

               <label for="email">Email:</label>
               <input type="email" id="email" name="email" required><br>

               <label for="password">Password:</label>
               <input type="password" id="password" name="password" required><br>

               <label for="type">Booking Type:</label>
               <input type="text" id="type" name="type" placeholder="Enter booking type" required><br>

               <button type="submit" class="submit-btn">Save Booking</button>
          </form>
     </div>

</body>
</html>
