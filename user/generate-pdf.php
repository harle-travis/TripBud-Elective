<?php
require_once('../vendor/autoload.php');
require_once('../tcpdf/tcpdf.php'); // Include TCPDF library
include ('../db/db.php');

// Function to generate PDF with booking and payment details
function generateBookingPDF($bookingId, $conn) {
    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Southpick Resort & Hotel');
    $pdf->SetTitle('Booking Details');
    $pdf->SetSubject('Booking Details');
    $pdf->SetKeywords('Booking, Details, PDF');

    // Set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

    // Set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // Add a page
    $pdf->AddPage();

    // Add Southpick Resort & Hotel heading
    $pdf->SetFont('helvetica', 'B', 24); // Larger font size and bold
    $pdf->Cell(0, 10, 'SOUTHPICK HOTEL & RESORT', 0, 1, 'C');
    $pdf->Ln(10); // Add some space after the heading

    // Add introduction paragraph
    $pdf->SetFont('helvetica', '', 14);
    $pdf->Cell(0, 10, 'Dear Receptionist,', 0, 1);
    $pdf->Ln(5); // Add some space after the heading
    $pdf->MultiCell(0, 10, "Please find below the booking and payment details provided by our guest for their stay at Southpick Resort & Hotel.", 0, 'L');
    $pdf->Ln(5); // Add some space after the introduction

    // Fetch booking and payment details from the database
    $sql = "SELECT b.*, p.*, r.room_name FROM bookings b 
            INNER JOIN payments p ON b.booking_id = p.booking_id 
            INNER JOIN rooms r ON b.room_id = r.room_id
            WHERE b.booking_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookingId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if booking exists
    if ($result->num_rows > 0) {
        $booking = $result->fetch_assoc();

        // Output booking and payment details
        $pdf->SetFont('helvetica', 'B', 16); // Adjust font size for headings
        $pdf->Cell(0, 10, 'Booking Details', 0, 1);
        $pdf->Ln(5); // Add some space after the heading

        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 10, 'Room #: ' . $booking['room_id'], 0, 1);

        $pdf->Cell(0, 10, 'Room Name: ' . $booking['room_name'], 0, 1);
        $pdf->Cell(0, 10, 'Check-in Date: ' . $booking['checkin_date'], 0, 1);
        $pdf->Cell(0, 10, 'Check-out Date: ' . $booking['checkout_date'], 0, 1);
        $pdf->Cell(0, 10, 'Total Price: ' . $booking['total_price'], 0, 1);

        $pdf->Ln(10); // Add some space between booking and payment details

        $pdf->SetFont('helvetica', 'B', 16); // Adjust font size for headings
        $pdf->Cell(0, 10, 'Payment Details', 0, 1);
        $pdf->Ln(5); // Add some space after the heading

        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 10, 'Payment Date: ' . $booking['payment_date'], 0, 1);
        $pdf->Cell(0, 10, 'Amount: ' . $booking['amount'], 0, 1);
        $pdf->Cell(0, 10, 'Payment Status: ' . $booking['payment_status'], 0, 1);

        // Close and output PDF document
        $pdf->Output('booking_details.pdf', 'I');
    } else {
        // Booking not found
        echo "Booking not found.";
    }
}

// Check if bookingId is set in the query parameters
if (isset($_GET['bookingId'])) {
    // Get the bookingId from the query parameters
    $bookingId = $_GET['bookingId'];

    // Call the function with the provided bookingId
    generateBookingPDF($bookingId, $conn);
} else {
    // Booking ID not provided
    echo "Booking ID not provided.";
}
?>
