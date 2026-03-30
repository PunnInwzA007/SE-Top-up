<?php
require_once "../config/db.php";

$id = $_GET['id'];

$conn->query("DELETE FROM rewards WHERE id=$id");

header("Location: rewards.php");