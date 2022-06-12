<?php
    if(! isset($_SESSION['user'])){
        header('Location: ../public/?session=expired');
    }
?>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>CSEC ASTU</title>
<!-- Theme style -->
<link rel="stylesheet" href="../assets/dist/css/adminlte.min.css" />
<!-- Select2 -->
<link rel="stylesheet" href="../assets/select2/css/select2.min.css">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<link rel="stylesheet" href="../assets/custom-style.css" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
<!-- overlayScrollbars -->
<link rel="stylesheet" href="../assets/overlayScrollbars/css/OverlayScrollbars.min.css" />
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="../assets/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- Sweetalert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.14/dist/sweetalert2.min.css">
<!-- Sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.14/dist/sweetalert2.all.min.js"></script>