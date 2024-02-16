<?php

require 'flight/Flight.php';

// Register class with constructor parameters
Flight::register('db', PDO::class, ['mysql:host=localhost;dbname=crm', 'root', '']);



Flight::route('GET /clients', function () {
    $sentencia= Flight::db()->prepare("SELECT * FROM `clientes`");
    $datos= $sentencia->execute();
    $datos= $sentencia->fetchAll();
    Flight::json($datos);
});

Flight::route('POST /clients', function () {
    $nombres= (Flight::request()->data->nombres);
    $apellidos= (Flight::request()->data->apellidos);
    $sql= "INSERT INTO clientes (nombres, apellidos) VALUES(?,?)";
    $sentencia= Flight::db()->prepare($sql);
    $sentencia->bindParam(1, $nombres);
    $sentencia->bindParam(2, $apellidos);
    $sentencia->execute();
    
    Flight::jsonp("Cliente ha sido agregado");
});

Flight::route('DELETE /clients', function () {
    $id= (Flight::request()->data->id);
    $sql= "DELETE FROM clientes WHERE id=?";
    $sentencia= Flight::db()->prepare($sql);
    $sentencia->bindParam(1, $id);
    $sentencia->execute();
    
    Flight::jsonp("Cliente ha sido borrado");
});

Flight::route('PUT /clients', function () {
    $id= (Flight::request()->data->id);
    $nombres= (Flight::request()->data->nombres);
    $apellidos= (Flight::request()->data->apellidos);
    
    $sql= "UPDATE clientes SET nombres= ?, apellidos=? WHERE id=?";
    $sentencia= Flight::db()->prepare($sql);

    $sentencia->bindParam(1, $nombres);
    $sentencia->bindParam(2, $apellidos);
    $sentencia->bindParam(3, $id);
    $sentencia->execute();
    
    Flight::jsonp("Los datos del Cliente han sido actualizados");
});

Flight::route('GET /clients/@id', function ($id) {
    $sentencia= Flight::db()->prepare("SELECT * FROM `clientes` WHERE id=?");
    $sentencia->bindParam(1, $id);
    $datos= $sentencia->execute();
    $datos= $sentencia->fetchAll();
    Flight::json($datos);
});

Flight::start();
