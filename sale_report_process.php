<?php
$page_title = 'Sales Report';
$results = '';
require_once('includes/load.php');

// Check user permission level to view this page
page_require_level(3);

// Process form submission to fetch sales data within specified dates
if(isset($_POST['submit'])) {
    $req_dates = array('start-date', 'end-date');
    validate_fields($req_dates);

    if(empty($errors)) {
        $start_date = remove_junk($db->escape($_POST['start-date']));
        $end_date = remove_junk($db->escape($_POST['end-date']));
        $results = find_sale_by_dates($start_date, $end_date);
    } else {
        $session->msg("d", $errors);
        redirect('sales_report.php', false);
    }
} else {
    $session->msg("d", "Select dates");
    redirect('sales_report.php', false);
}
?>

<!doctype html>
<html lang="en-US">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <style>
        @media print {
            html, body {
                font-size: 9.5pt;
                margin: 0;
                padding: 0;
            }
            .page-break {
                page-break-before: always;
                width: auto;
                margin: auto;
            }
        }
        .page-break {
            width: 980px;
            margin: 0 auto;
        }
        .sale-head {
            margin: 40px 0;
            text-align: center;
        }
        .sale-head h1, .sale-head strong {
            padding: 10px 20px;
            display: block;
        }
        .sale-head h1 {
            margin: 0;
            border-bottom: 1px solid #212121;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table thead tr th, table tbody tr td, table tfoot tr td {
            border: 1px solid #212121;
            white-space: nowrap;
            text-align: center;
            padding: 8px;
        }
        table thead tr th {
            background-color: #f8f8f8;
        }
        tfoot {
            color: #000;
            text-transform: uppercase;
            font-weight: 500;
        }
    </style>
</head>
<body>
<?php if($results): ?>
    <div class="page-break">
        <div class="sale-head">
            <h1>Inventory Management System - Sales Report</h1>
            <strong><?php if(isset($start_date)) { echo $start_date; } ?> TILL DATE <?php if(isset($end_date)) { echo $end_date; } ?></strong>
        </div>
        <table class="table table-border">
            <thead>
            <tr>
                <th>Date</th>
                <th>Product Title</th>
                <th>Buying Price</th>
                <th>Selling Price</th>
                <th>Total Qty</th>
                <th>TOTAL</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($results as $result): ?>
                <tr>
                    <td><?php echo remove_junk($result['date']); ?></td>
                    <td><?php echo remove_junk(ucfirst($result['name'])); ?></td>
                    <td>$<?php echo remove_junk($result['buy_price']); ?></td>
                    <td>$<?php echo remove_junk($result['sale_price']); ?></td>
                    <td><?php echo remove_junk($result['total_sales']); ?></td>
                    <td>$<?php echo remove_junk($result['total_saleing_price']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr class="text-right">
                <td colspan="4"></td>
                <td>Grand Total</td>
                <td>$<?php echo number_format(total_price($results)[0], 2); ?></td>
            </tr>
            <tr class="text-right">
                <td colspan="4"></td>
                <td>Profit</td>
                <td>$<?php echo number_format(total_price($results)[1], 2); ?></td>
            </tr>
            </tfoot>
        </table>
    </div>
<?php else: ?>
    <div class="text-center">
        <p>No sales have been found.</p>
    </div>
<?php endif; ?>
</body>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } ?>
