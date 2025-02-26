<?php
include 'db.php';

// Handle form submission for adding events
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_event'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $venue = $_POST['venue'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO events (title, description, date, time, venue) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $description, $date, $time, $venue);

    if ($stmt->execute()) {
        echo "<script>alert('Event scheduled successfully!');</script>";
    } else {
        echo "<script>alert('Error scheduling event.');</script>";
    }
    $stmt->close();
}

// Handle event deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<script>alert('Event deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting event.');</script>";
    }
    $stmt->close();
}

// Handle event update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_event'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $venue = $_POST['venue'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("UPDATE events SET title=?, description=?, date=?, time=?, venue=? WHERE id=?");
    $stmt->bind_param("sssssi", $title, $description, $date, $time, $venue, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Event updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating event.');</script>";
    }
    $stmt->close();
}

// Fetch all events from the database
$sql = "SELECT * FROM events";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PCTE EVENTS ON AIR </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i> <img src="img/logo 2.png" alt="" width="140px" height="45px"> </i> EVENTS</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.html" class="nav-item nav-link active">Home</a>
                <a href="about.html" class="nav-item nav-link">About</a>
                <a href="events.html" class="nav-item nav-link">Events</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="team.html" class="dropdown-item">Our Team</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                        <a href="404.html" class="dropdown-item">404 Page</a>
                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <a href="" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Join Now<i class="fa fa-arrow-right ms-3"></i></a>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Schedule Event Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <h1 class="text-center mb-5">Schedule Event</h1>
            <form action="schedule_event.php" method="POST">
                <input type="hidden" name="add_event" value="1">
                <div class="mb-3">
                    <label for="title" class="form-label">Event Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <div class="mb-3">
                    <label for="time" class="form-label">Time</label>
                    <input type="time" class="form-control" id="time" name="time" required>
                </div>
                <div class="mb-3">
                    <label for="venue" class="form-label">Venue</label>
                    <input type="text" class="form-control" id="venue" name="venue" required>
                </div>
                <button type="submit" class="btn btn-primary">Schedule Event</button>
            </form>
        </div>
    </div>
    <!-- Schedule Event End -->

    <!-- Display Events Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <h1 class="text-center mb-5">Manage Events</h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Venue</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['title']}</td>
                                    <td>{$row['description']}</td>
                                    <td>{$row['date']}</td>
                                    <td>{$row['time']}</td>
                                    <td>{$row['venue']}</td>
                                    <td>
                                        <a href='schedule_event.php?delete_id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this event?\");'>Delete</a>
                                        <button type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#updateModal{$row['id']}'>Update</button>
                                    </td>
                                </tr>";

                            // Update Modal for each event
                            echo "<div class='modal fade' id='updateModal{$row['id']}' tabindex='-1' aria-labelledby='updateModalLabel' aria-hidden='true'>
                                    <div class='modal-dialog'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='updateModalLabel'>Update Event</h5>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                            </div>
                                            <div class='modal-body'>
                                                <form action='schedule_event.php' method='POST'>
                                                    <input type='hidden' name='id' value='{$row['id']}'>
                                                    <input type='hidden' name='update_event' value='1'>
                                                    <div class='mb-3'>
                                                        <label for='title' class='form-label'>Event Title</label>
                                                        <input type='text' class='form-control' name='title' value='{$row['title']}' required>
                                                    </div>
                                                    <div class='mb-3'>
                                                        <label for='description' class='form-label'>Description</label>
                                                        <textarea class='form-control' name='description' rows='3' required>{$row['description']}</textarea>
                                                    </div>
                                                    <div class='mb-3'>
                                                        <label for='date' class='form-label'>Date</label>
                                                        <input type='date' class='form-control' name='date' value='{$row['date']}' required>
                                                    </div>
                                                    <div class='mb-3'>
                                                        <label for='time' class='form-label'>Time</label>
                                                        <input type='time' class='form-control' name='time' value='{$row['time']}' required>
                                                    </div>
                                                    <div class='mb-3'>
                                                        <label for='venue' class='form-label'>Venue</label>
                                                        <input type='text' class='form-control' name='venue' value='{$row['venue']}' required>
                                                    </div>
                                                    <button type='submit' class='btn btn-primary'>Update Event</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>No events found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Display Events End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Quick Link</h4>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Privacy Policy</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">FAQs & Help</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Contact</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Campus-1, Baddowal, Ferozepur Road, Ludhiana-142021, Punjab, India</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+0161 -2888550</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@pcte.edu.in</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Gallery</h4>
                    <div class="row g-2 pt-2">
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-1.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-2.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-3.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-2.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-3.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-1.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Newsletter</h4>
                    <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>

<?php
$conn->close();
?>