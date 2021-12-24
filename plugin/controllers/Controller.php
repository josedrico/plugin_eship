<?php
namespace Eship\Plugin\Controllers;
#TODO FIXME realizar el ruteo correcto
class Eship_Controller {
    public function model($model)
    {
        if (file_exists(__MODELS__ . ucfirst($model) . "Model.php")) {
            require __MODELS__ . ucfirst($model) . "Model.php";
            $model = ucfirst($model . "Model");
            return new $model();
        } else {
            #TODO FIXME crear un log
            echo "El archivo del modelo no existe";
        }
    }

    public function view($view, $data = [])
    {
        if (file_exists(__VIEWS__ . $view . ".php")) {
            require __VIEWS__ . $view . ".php";
        } else {
            #TODO FIXME crear un log
            echo "El archivo de la vista no existe";
        }
    }
}