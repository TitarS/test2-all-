<?php
require 'database.php';

function get_all_posts() {
    global $mysqli;
    $sql = 'SELECT * FROM posts';
    $query = mysqli_query($mysqli, $sql);
    $posts = [];
    while($post = mysqli_fetch_assoc($query)) {
        $posts[] = $post;
    }
    return $posts;
}

function insert_post($title, $content, $image) {
    global $mysqli;

    $image_name = upload_image($image);
    $sql = "INSERT INTO posts (title, content, image) VALUE ('$title','$content','$image_name')";
    mysqli_query($mysqli, $sql) or die('error' . $mysqli->error);
}

function upload_image($image) {
    $image_name = generate_name();
    move_uploaded_file($image['tmp_name'], 'uploads/' . $image_name);
    return $image_name;
}

function generate_name() {
    $image = $_FILES['image'];
    $file_name = uniqid();
    $extension = explode('.', $image['name']);
    $image_name = $file_name . '.' . $extension[1];
    return $image_name;
}

function edit_post($id) {
        global $mysqli;

        $sql = "UPDATE posts SET title='" . $_POST['title'] . "', content='" . $_POST['content'] . "' WHERE id=" . $id;
        mysqli_query($mysqli, $sql) or die('error' . $mysqli->error);
        echo "<script>window.location.href='http://crudlast/edit.php?id=" . $id . "'</script>";
}

function delete_post($id) {
    global $mysqli;

    $sqlDel = 'DELETE FROM posts WHERE id=' . $id;
    mysqli_query($mysqli, $sqlDel) or die ('error' . $mysqli->error);
    header('Location: http://crudlast');
}

function get_post($id) {
    global $mysqli;

    $sql = 'SELECT title, content, image FROM posts WHERE id=' . $id;
    $query = mysqli_query($mysqli, $sql);
    $post = mysqli_fetch_assoc($query);
    return $post;
}