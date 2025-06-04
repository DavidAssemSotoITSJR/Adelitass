<?php
class PerfilController extends AppController
{
    public function index()
    {
        // Datos del usuario
        $this->nombre = "César Hernández Jr. 21590385";
        $this->titulo = "Ingeniero en Sistemas Computacionales";
        $this->descripcion = "Desarrollador apasionado con experiencia en desarrollo web, bases de datos y redes.";

        // Habilidades y conocimientos
        $this->habilidades = [
            "Desarrollo Web (HTML, PHP)",
            "Frameworks (Bootstrap, KumbiaPHP)",
            "Bases de Datos (MySQL, PostgreSQL, HeidiSQL)",
            "Administración de Servidores (Linux, Apache, Nginx)",
            "Redes y Seguridad Informática",
            "Programación en Python",
            "Gestión de Proyectos de Software",
            "Administración de Redes",
            "Fundamentos de Ciberseguridad"
        ];

        // Experiencia laboral
        $this->experiencia = [
            ["empresa" => "TechCom Solutions", "cargo" => "Desarrollador Web", "tiempo" => "2024 - Actualidad"],
            ["empresa" => "JICode", "cargo" => "Diseñador y Programador de App", "tiempo" => "2021 - 2023"],
            ["empresa" => "Freelancer", "cargo" => "Desarrollador Full Stack", "tiempo" => "2021 - Actualidad"]
        ];
    }
}
