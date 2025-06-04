<?php

class Formbs{
    protected static function attrsdefaut($attrs, $defaults)
    {
        foreach ($defaults as $k => $v) {
            if (isset($attrs[$k])) {
                if (strpos($attrs[$k], $v) === false) {
                    $attrs[$k] .= ' ' . $v;
                }
            } else {
                $attrs[$k] = $v;
            }
        }
        return $attrs;
    }

    public static function btn_aceptar($text = "Aceptar", $attrs = []){
        $text = "💾 " . $text;
        $attrs = self::attrsdefaut($attrs, ["class" => "btn btn-primary"]);
        return Form::submit($text, $attrs);
    }

    public static function btn_guardar($text = "Guardar", $attrs = []){
        $text = "💾 " . $text;
        $attrs = self::attrsdefaut($attrs, ["class" => "btn btn-success"]);
        return Form::submit($text, $attrs);
    }

    public static function btn_regresar($text = "Regresar", $attrs = []){
        $text = "🔙 " . $text;
        $attrs = self::attrsdefaut($attrs, ["class" => "btn btn-secondary"]);
        return Form::submit($text, $attrs);
    }

    public static function btn_cancelar($text = "Cancelar", $attrs = []){
        $text = "❌ " . $text;
        $attrs = self::attrsdefaut($attrs, ["class" => "btn btn-danger"]);
        return Form::submit($text, $attrs);
    }

    public static function btn_eliminar($text = "Eliminar", $attrs = []){
        $text = "🗑️ " . $text;
        $attrs = self::attrsdefaut($attrs, ["class" => "btn btn-danger"]);
        return Form::submit($text, $attrs);
    }

    public static function btn_editar($text = "Editar", $attrs = []){
        $text = "✏️ " . $text;
        $attrs = self::attrsdefaut($attrs, ["class" => "btn btn-warning"]);
        return Form::submit($text, $attrs);
    }
}