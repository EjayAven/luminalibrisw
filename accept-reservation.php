<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'librarian') {
    header("Location: login-page.php");
    exit();
}

include 'db_connection.php';

if (isset($_GET['id'])) {
    $reservationId = $_GET['id'];

    $update_query = "UPDATE reservation SET status = 'accepted' WHERE reserve_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("i", $reservationId);

    if ($stmt->execute()) {
        header("Location: request.php?message=Reservation accepted");
    } else {
        header("Location:request.php?error=Failed to accept the reservation");
    }

    $stmt->close();
} else {
    header("Location: library-requests.php");
}

$conn->close();
?>
